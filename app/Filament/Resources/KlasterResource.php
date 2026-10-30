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
                    ->options([
                        StatusKlaster::Terverifikasi->value => 'Terverifikasi',
                        StatusKlaster::Disposisi->value => 'Disposisi',
                        StatusKlaster::Ditugaskan->value => 'Ditugaskan',
                    ])
                    ->disabled(fn (): bool => ! self::isKabid())
                    ->dehydrated(fn (): bool => self::isKabid())
                    ->required(),

                Forms\Components\Select::make('assigned_to')
                    ->label('Petugas')
                    ->relationship('petugas', 'name')
                    ->searchable()
                    ->preload()
                    ->disabled(fn (): bool => ! self::isSubkoordinator())
                    ->dehydrated(fn (): bool => self::isSubkoordinator()),

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
                    ->directory('bukti-klaster'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKlasters::route('/'),
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
}
