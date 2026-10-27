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
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('anchor_lng')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('assigned_to')
                    ->numeric(),
                Forms\Components\Textarea::make('alasan_tolak')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('foto_bukti'),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'create' => Pages\CreateKlaster::route('/create'),
            'edit' => Pages\EditKlaster::route('/{record}/edit'),
        ];
    }
}
