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
                    ->square(),

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
                        $record->update([
                            'status' => 'terverifikasi',
                        ]);
                    }),

                Tables\Actions\Action::make('mulai_proses')
                    ->label('Mulai Proses')
                    ->icon('heroicon-o-arrow-path')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->visible(fn (Laporan $record): bool => false)
                    ->action(function (Laporan $record): void {
                        $record->update([
                            'status' => 'dalam_proses',
                        ]);
                    }),

                Tables\Actions\Action::make('selesaikan')
                    ->label('Selesaikan')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Laporan $record): bool => false)
                    ->action(function (Laporan $record): void {
                        $record->update([
                            'status' => 'selesai',
                        ]);
                    }),

                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('alasan_tolak')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->minLength(5)
                            ->maxLength(1000),
                    ])
                    ->visible(fn (Laporan $record): bool =>
                        self::isOperator()
                        && ! in_array(
                            $record->status,
                            ['ditolak', 'selesai'],
                            true
                        )
                    )
                    ->form([
                        Forms\Components\Textarea::make('alasan_tolak')
                            ->label('Alasan Penolakan')
                            ->placeholder('Masukkan alasan mengapa laporan ditolak...')
                            ->required()
                            ->maxLength(1000),
                    ])
                    ->action(function (Laporan $record, array $data): void {
                        $record->update([
                            'status' => 'ditolak',
                            'alasan_tolak' => $data['alasan_tolak'],
                            'klaster_id' => null,
                        ]);

                        Notification::make()
                            ->title('Laporan berhasil ditolak')
                            ->success()
                            ->send();
                    })
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
}
