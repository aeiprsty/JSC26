<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InformasiResource\Pages;
use App\Models\Informasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class InformasiResource extends Resource
{
    protected static ?string $model = Informasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'Informasi';

    protected static ?string $navigationGroup = 'Konten Publik';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function canDelete(Model $record): bool
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
                Forms\Components\TextInput::make('judul')
                    ->label('Judul Komponen')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\TagsInput::make('rincian')
                    ->label('Rincian Alokasi')
                    ->placeholder('Ketik rincian, lalu tekan Enter')
                    ->helperText('Setiap rincian menjadi satu poin pada halaman Transparansi.')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('ikon')
                    ->label('Ikon')
                    ->placeholder('Contoh: fas fa-truck')
                    ->helperText('Masukkan nama class ikon yang digunakan frontend.'),

                Forms\Components\TextInput::make('urutan')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->default(0)
                    ->required(),

                Forms\Components\Toggle::make('status')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Jika dinonaktifkan, informasi tidak ditampilkan kepada masyarakat.'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50),

                Tables\Columns\TextColumn::make('rincian')
                    ->label('Jumlah Rincian')
                    ->getStateUsing(function (\App\Models\Informasi $record): string {
                        return count($record->rincian ?? []) . ' poin';
                    }),

                Tables\Columns\TextColumn::make('ikon')
                    ->label('Ikon')
                    ->placeholder('Tidak ada'),

                Tables\Columns\IconColumn::make('status')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('urutan', 'asc')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInformasis::route('/'),
            'create' => Pages\CreateInformasi::route('/create'),
            'edit' => Pages\EditInformasi::route('/{record}/edit'),
        ];
    }
}