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
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'terverifikasi' => 'Terverifikasi',
                        'disposisi' => 'Disposisi',
                        'ditugaskan' => 'Ditugaskan',
                        'dalam_proses' => 'Dalam Proses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ])
                    ->required(),

                Forms\Components\Select::make('assigned_to')
                    ->label('Petugas')
                    ->relationship('petugas', 'name')
                    ->searchable()
                    ->preload(),

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
                Tables\Columns\TextColumn::make('anchor_lat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anchor_lng')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('assigned_to')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('foto_bukti')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
}
