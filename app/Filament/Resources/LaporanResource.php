<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanResource\Pages;
use App\Models\Laporan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanResource extends Resource
{
    protected static ?string $model = Laporan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Laporan TPS Liar';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function isOperator(): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function isKomandoLapangan(): bool
    {
        return auth()->user()?->role === 'komando_lapangan';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_tiket')
                    ->label('Kode Tiket')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\FileUpload::make('foto')
                    ->label('Foto Laporan')
                    ->image()
                    ->disk('public')
                    ->directory('laporan')
                    ->required(),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('lat')
                    ->label('Latitude')
                    ->numeric()
                    ->minValue(-90)
                    ->maxValue(90)
                    ->required(),

                Forms\Components\TextInput::make('lng')
                    ->label('Longitude')
                    ->numeric()
                    ->minValue(-180)
                    ->maxValue(180)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_tiket')
                    ->label('Kode Tiket')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->disk('public')
                    ->square()
                    ->url(fn (Laporan $record): ?string =>
                        $record->foto
                            ? Storage::disk('public')->url($record->foto)
                            : null
                    )
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(40)
                    ->placeholder('Tidak ada deskripsi'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'terverifikasi' => 'info',
                        'dalam_proses' => 'primary',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('klaster_id')
                    ->label('ID Klaster')
                    ->placeholder('Belum masuk klaster'),

                Tables\Columns\TextColumn::make('lat')
                    ->label('Latitude')
                    ->numeric(decimalPlaces: 7),

                Tables\Columns\TextColumn::make('lng')
                    ->label('Longitude')
                    ->numeric(decimalPlaces: 7),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Laporan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'terverifikasi' => 'Terverifikasi',
                        'dalam_proses' => 'Dalam Proses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('verifikasi')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Laporan $record): bool =>
                        self::isOperator()
                        && $record->status === 'menunggu'
                    )
                    ->action(function (Laporan $record): void {
                        abort_unless(self::isOperator(), 403);
                        abort_unless($record->status === 'menunggu', 409);

                        $record->update([
                            'status' => 'terverifikasi',
                        ]);
                    }),

                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('alasan_tolak')
                            ->label('Alasan Penolakan')
                            ->placeholder('Masukkan alasan mengapa laporan ditolak...')
                            ->required()
                            ->minLength(5)
                            ->maxLength(1000),
                    ])
                    ->visible(fn (Laporan $record): bool =>
                        self::isOperator()
                        && $record->status === 'menunggu'
                    )
                    ->action(function (Laporan $record, array $data): void {
                        abort_unless(self::isOperator(), 403);
                        abort_unless($record->status === 'menunggu', 409);

                        $alasan = trim($data['alasan_tolak'] ?? '');

                        abort_unless(mb_strlen($alasan) >= 5, 422);

                        DB::transaction(function () use ($record, $alasan): void {
                            $laporan = Laporan::query()
                                ->whereKey($record->getKey())
                                ->lockForUpdate()
                                ->firstOrFail();

                            abort_unless($laporan->status === 'menunggu', 409);

                            $laporan->update([
                                'status' => 'ditolak',
                                'alasan_tolak' => $alasan,
                                'klaster_id' => null,
                            ]);
                        });

                        Notification::make()
                            ->title('Laporan berhasil ditolak')
                            ->success()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporans::route('/'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'operator';
    }

    protected static ?int $navigationSort = 2;
}
