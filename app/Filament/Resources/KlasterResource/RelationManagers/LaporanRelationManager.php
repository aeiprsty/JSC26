<?php

namespace App\Filament\Resources\KlasterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Laporan;
use App\Services\ClusterService;
use Illuminate\Support\Facades\Storage;

class LaporanRelationManager extends RelationManager
{
    protected static string $relationship = 'laporan';

    protected static ?string $title = 'Daftar Laporan dalam Klaster';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_tiket')
                    ->label('Kode Tiket')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto Laporan')
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
                    ->limit(50)
                    ->placeholder('Tidak ada deskripsi'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status Laporan')
                    ->badge(),

                Tables\Columns\TextColumn::make('lat')
                    ->label('Latitude')
                    ->numeric(decimalPlaces: 7),

                Tables\Columns\TextColumn::make('lng')
                    ->label('Longitude')
                    ->numeric(decimalPlaces: 7),

                Tables\Columns\TextColumn::make('jarak_dari_anchor')
                ->label('Jarak dari Anchor')
                ->state(function (Laporan $record): string {
                    $klaster = $this->getOwnerRecord();

                    $jarak = app(ClusterService::class)->distanceInMeters(
                        (float) $klaster->anchor_lat,
                        (float) $klaster->anchor_lng,
                        (float) $record->lat,
                        (float) $record->lng,
                    );

                    return number_format($jarak, 1, ',', '.') . ' m';
                }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Laporan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }
}