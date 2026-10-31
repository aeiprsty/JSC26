<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KlasterResource\Pages;
use App\Filament\Resources\KlasterResource\RelationManagers;
use App\Models\Klaster;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\StatusKlaster;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;

class KlasterResource extends Resource
{
    protected static ?string $model = Klaster::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('anchor_lat')
                    ->label('Latitude')
                    ->disabled(),

                Forms\Components\TextInput::make('anchor_lng')
                    ->label('Longitude')
                    ->disabled(),

                Forms\Components\Select::make('status')
                ->label('Status Klaster')
                ->options(fn (): array => match (auth()->user()?->role) {
                    'kabid' => [
                        StatusKlaster::Terverifikasi->value => 'Terverifikasi',
                        StatusKlaster::Disposisi->value => 'Disposisi',
                    ],

                    'subkoordinator' => [
                        StatusKlaster::Disposisi->value => 'Disposisi',
                        StatusKlaster::Ditugaskan->value => 'Ditugaskan',
                    ],

                    'komando_lapangan' => [
                        StatusKlaster::Ditugaskan->value => 'Ditugaskan',
                        StatusKlaster::DalamProses->value => 'Dalam Proses',
                        StatusKlaster::Selesai->value => 'Selesai',
                    ],

                    default => [],
                })
                ->visible(fn (): bool => in_array(
                    auth()->user()?->role,
                    ['kabid', 'subkoordinator', 'komando_lapangan'],
                    true
                ))
                ->required(),

                Forms\Components\Select::make('assigned_to')
                    ->label('Pilih Petugas Komando Lapangan')
                    ->relationship(
                        name: 'petugas',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) =>
                            $query->where('role', 'komando_lapangan')
                                ->orderBy('name')
                    )
                    ->searchable()
                    ->preload()
                    ->visible(fn (): bool => self::isSubkoordinator())
                    ->required(),

                Forms\Components\Textarea::make('alasan_tolak')
                    ->label('Alasan Penolakan')
                    ->visible(fn (Forms\Get $get): bool =>
                        $get('status') === 'ditolak'
                    )
                    ->required(fn (Forms\Get $get): bool =>
                        $get('status') === 'ditolak'
                    ),

                Forms\Components\FileUpload::make('foto_bukti')
                    ->label('Foto Bukti Pembersihan')
                    ->image()
                    ->disk('public')
                    ->directory('bukti-klaster')
                    ->visible(fn (): bool =>
                        auth()->user()?->role === 'komando_lapangan'
                    )
                    ->required(fn (Forms\Get $get): bool =>
                        $get('status') === StatusKlaster::Selesai->value
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Klaster')
                    ->sortable(),

                Tables\Columns\TextColumn::make('anchor_lat')
                    ->label('Latitude')
                    ->numeric(decimalPlaces: 6),

                Tables\Columns\TextColumn::make('anchor_lng')
                    ->label('Longitude')
                    ->numeric(decimalPlaces: 6),

                Tables\Columns\TextColumn::make('laporan_count')
                    ->counts('laporan')
                    ->label('Jumlah Laporan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status Klaster')
                    ->badge(),

                Tables\Columns\TextColumn::make('petugas.name')
                    ->label('Petugas')
                    ->placeholder('Belum ditugaskan'),

                Tables\Columns\ImageColumn::make('foto_bukti')
                    ->label('Foto Bukti')
                    ->disk('public')
                    ->height(60)
                    ->width(60),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
            Tables\Actions\ViewAction::make()
                ->label('Lihat Detail')
                ->icon('heroicon-o-eye')
                ->color('info'),
            
            Tables\Actions\EditAction::make()
            ->label('Kelola Klaster')
            ->icon('heroicon-o-pencil-square')
            ->visible(fn (Klaster $record): bool =>
                self::canEdit($record)
            ),

            Tables\Actions\Action::make('verifikasi')
                ->label('Verifikasi Klaster')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Verifikasi Klaster')
                ->modalDescription(
                    'Sahkan klaster setelah semua laporan di dalamnya diperiksa?'
                )
                ->visible(fn (Klaster $record): bool =>
                    auth()->user()?->role === 'operator'
                    && $record->status === StatusKlaster::MenungguVerifikasi
                    && $record->laporan()
                        ->where('status', 'terverifikasi')
                        ->exists()
                    && ! $record->laporan()
                        ->where('status', 'menunggu')
                        ->exists()
                    && ! $record->laporan()
                        ->whereNotIn('status', [
                            'terverifikasi',
                            'ditolak',
                            'selesai',
                        ])
                        ->exists()
                )
                ->action(function (Klaster $record): void {
                    $berhasil = DB::transaction(function () use ($record): bool {
                        $record = Klaster::query()
                            ->whereKey($record->getKey())
                            ->lockForUpdate()
                            ->firstOrFail();

                        if (
                            auth()->user()?->role !== 'operator'
                            || $record->status !== StatusKlaster::MenungguVerifikasi
                            || ! $record->laporan()
                                ->where('status', 'terverifikasi')
                                ->exists()
                            || $record->laporan()->exists() === false
                            || $record->laporan()
                                ->where('status', 'menunggu')
                                ->exists()
                            || $record->laporan()
                                ->whereNotIn('status', [
                                    'terverifikasi',
                                    'ditolak',
                                    'selesai',
                                ])
                                ->exists()
                        ) {
                            return false;
                        }

                        $record->update([
                            'status' => StatusKlaster::Terverifikasi,
                        ]);

                        return true;
                    });

                    if (! $berhasil) {
                        Notification::make()
                            ->title('Klaster belum memenuhi syarat verifikasi')
                            ->warning()
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->title('Klaster berhasil diverifikasi')
                        ->success()
                        ->send();
                }),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\LaporanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKlasters::route('/'),
            'view' => Pages\ViewKlaster::route('/{record}'),
            'edit' => Pages\EditKlaster::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function isKabid(): bool
    {
        return auth()->user()?->role === 'kabid';
    }

    public static function isSubkoordinator(): bool
    {
        return auth()->user()?->role === 'subkoordinator';
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Klaster')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('ID Klaster'),

                                TextEntry::make('status')
                                    ->label('Status Klaster')
                                    ->badge(),

                                TextEntry::make('anchor_lat')
                                    ->label('Latitude Anchor')
                                    ->numeric(decimalPlaces: 7),

                                TextEntry::make('anchor_lng')
                                    ->label('Longitude Anchor')
                                    ->numeric(decimalPlaces: 7),

                                TextEntry::make('total_laporan')
                                    ->label('Total Laporan')
                                    ->state(fn (Klaster $record): int =>
                                        $record->laporan()->count()
                                    ),

                                TextEntry::make('laporan_terverifikasi')
                                    ->label('Laporan Terverifikasi')
                                    ->state(fn (Klaster $record): int =>
                                        $record->laporan()
                                            ->where('status', 'terverifikasi')
                                            ->count()
                                    ),

                                TextEntry::make('laporan_menunggu')
                                    ->label('Laporan Menunggu')
                                    ->state(fn (Klaster $record): int =>
                                        $record->laporan()
                                            ->where('status', 'menunggu')
                                            ->count()
                                    ),

                                TextEntry::make('radius_clustering')
                                    ->label('Radius Clustering')
                                    ->state('50 meter'),
                            ]),
                    ]),
            ]);
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return match ($user->role) {
            'kabid' => $record->status === StatusKlaster::Terverifikasi,

            'subkoordinator' => $record->status === StatusKlaster::Disposisi,

            'komando_lapangan' =>
                (int) $record->assigned_to === (int) $user->id
                && in_array($record->status, [
                    StatusKlaster::Ditugaskan,
                    StatusKlaster::DalamProses,
                ], true),

            default => false,
        };
    }

    public static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()?->role, [
            'operator',
            'kabid',
            'subkoordinator',
            'komando_lapangan',
        ], true);
    }

    protected static ?string $navigationLabel = 'Klaster';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['petugas'])
            ->withCount('laporan');

        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        return match ($user->role) {
            'operator' => $query,

            'kabid' => $query->where(
                'status',
                StatusKlaster::Terverifikasi
            ),

            'subkoordinator' => $query->where(
                'status',
                StatusKlaster::Disposisi
            ),

            'komando_lapangan' => $query
                ->where('assigned_to', $user->id)
                ->whereIn('status', [
                    StatusKlaster::Ditugaskan,
                    StatusKlaster::DalamProses,
                ]),

            default => $query->whereRaw('1 = 0'),
        };
    }

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, [
            'operator',
            'kabid',
            'subkoordinator',
            'komando_lapangan',
        ], true);
    }

    public static function canView(Model $record): bool
    {
        return in_array(auth()->user()?->role, [
            'operator',
            'kabid',
            'subkoordinator',
            'komando_lapangan',
        ], true);
    }
}
