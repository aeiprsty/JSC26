<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KlasterRiwayatResource\Pages;
use App\Models\KlasterRiwayat;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KlasterRiwayatResource extends Resource
{
    protected static ?string $model = KlasterRiwayat::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Riwayat Aktivitas';

    protected static ?string $navigationGroup = 'Manajemen Klaster';

    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Aktivitas')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('klaster.id')
                    ->label('ID Klaster')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('laporan.kode_tiket')
                    ->label('Kode Tiket')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('aktivitas')
                    ->label('Aktivitas')
                    ->searchable()
                    ->badge(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Dilakukan Oleh')
                    ->placeholder('Sistem')
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Peran')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'operator' => 'Operator',
                        'kabid' => 'Kabid',
                        'subkoordinator' => 'Subkoordinator',
                        'komando_lapangan' => 'Komando Lapangan',
                        default => ucfirst(str_replace('_', ' ', $state ?? '-')),
                    }),

                Tables\Columns\TextColumn::make('status_sebelum')
                    ->label('Status Sebelumnya')
                    ->formatStateUsing(fn (?string $state): string => self::formatStatus($state))
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('status_sesudah')
                    ->label('Status Berikutnya')
                    ->formatStateUsing(fn (?string $state): string => self::formatStatus($state))
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('petugasSesudah.name')
                    ->label('Petugas Ditugaskan')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('-')
                    ->wrap(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('aktivitas')
                    ->label('Jenis Aktivitas')
                    ->options(fn (): array => KlasterRiwayat::query()
                        ->distinct()
                        ->orderBy('aktivitas')
                        ->pluck('aktivitas', 'aktivitas')
                        ->all()),

                Tables\Filters\SelectFilter::make('klaster_id')
                    ->label('ID Klaster')
                    ->relationship('klaster', 'id'),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function formatStatus(?string $status): string
    {
        return match ($status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'terverifikasi' => 'Terverifikasi',
            'disposisi' => 'Disposisi',
            'ditugaskan' => 'Ditugaskan',
            'dalam_proses' => 'Dalam Proses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => $status
                ? ucfirst(str_replace('_', ' ', $status))
                : '-',
        };
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKlasterRiwayats::route('/'),
        ];
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

    public static function shouldRegisterNavigation(): bool
    {
        return self::canViewAny();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['klaster', 'laporan', 'user', 'petugasSesudah']);

        $user = auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        // Operator dapat melihat seluruh riwayat.
        if ($user->role === 'operator') {
            return $query;
        }

        // Pengguna lain hanya melihat aktivitas yang melibatkan dirinya.
        return $query->where(function (Builder $q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere('assigned_to_sebelum', $user->id)
                ->orWhere('assigned_to_sesudah', $user->id);
        });
    }
}
