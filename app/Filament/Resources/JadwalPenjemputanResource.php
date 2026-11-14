<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalPenjemputanResource\Pages;
use App\Models\JadwalPenjemputan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JadwalPenjemputanResource extends Resource
{
    protected static ?string $model = JadwalPenjemputan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Kelola Jadwal OPBM';

    protected static ?string $navigationGroup = 'Informasi & Edukasi';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Jadwal Penjemputan';

    protected static ?string $pluralModelLabel = 'Jadwal Penjemputan';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kelurahan')
                    ->label('Kelurahan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('kecamatan')
                    ->label('Kecamatan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('cakupan_rt')
                    ->label('Cakupan RT')
                    ->placeholder('Contoh: RT 01 s/d RT 08')
                    ->required()
                    ->maxLength(255),

                Forms\Components\CheckboxList::make('hari_penjemputan')
                    ->label('Hari Penjemputan')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                    ])
                    ->columns(4)
                    ->required(),

                Forms\Components\TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->native(false)
                    ->seconds(false)
                    ->displayFormat('H:i')
                    ->required(),

                Forms\Components\TimePicker::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->native(false)
                    ->seconds(false)
                    ->displayFormat('H:i')
                    ->after('jam_mulai')
                    ->required(),

                Forms\Components\TextInput::make('urutan')
                    ->label('Urutan Tampilan')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Forms\Components\Toggle::make('status')
                    ->label('Tampilkan di Halaman Publik')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('urutan')
            ->columns([
                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable()
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('kelurahan')
                    ->label('Kelurahan')
                    ->searchable()
                    ->sortable()
                    ->extraHeaderAttributes(['class' => 'text-center'])
                    ->extraAttributes(['class' => 'text-left']),

                Tables\Columns\TextColumn::make('kecamatan')
                    ->label('Kecamatan')
                    ->searchable()
                    ->extraHeaderAttributes(['class' => 'text-center'])
                    ->extraAttributes(['class' => 'text-left']),

                Tables\Columns\TextColumn::make('cakupan_rt')
                    ->label('Cakupan RT')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('hari_penjemputan')
                    ->label('Hari Penjemputan')
                    ->formatStateUsing(function ($state, $record) {
                        $hari = $record->hari_penjemputan;

                        if (is_string($hari)) {
                            $hari = json_decode($hari, true);
                        }

                        if (!is_array($hari)) {
                            return '-';
                        }

                        return implode(', ', $hari);
                    })
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->formatStateUsing(fn ($state) => $state
                        ? \Carbon\Carbon::parse($state)->format('H.i')
                        : '-')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->formatStateUsing(fn ($state) => $state
                        ? \Carbon\Carbon::parse($state)->format('H.i')
                        : '-')
                    ->alignment('center'),

                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->alignment('center'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwalPenjemputans::route('/'),
            'create' => Pages\CreateJadwalPenjemputan::route('/create'),
            'edit' => Pages\EditJadwalPenjemputan::route('/{record}/edit'),
        ];
    }
}