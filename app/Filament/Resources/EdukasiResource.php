<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EdukasiResource\Pages;
use App\Models\Edukasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Get;

class EdukasiResource extends Resource
{
    protected static ?string $model = Edukasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Edukasi';

    protected static ?string $navigationGroup = 'Konten Publik';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'operator';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jenis')
                    ->label('Jenis Konten')
                    ->options([
                        'video' => 'Video',
                        'artikel' => 'Artikel',
                    ])
                    ->required()
                    ->live(),

                Forms\Components\TextInput::make('judul')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Forms\Components\TextInput::make('kategori')
                    ->label('Kategori')
                    ->required()
                    ->maxLength(100),

                Forms\Components\Textarea::make('ringkasan')
                    ->label('Ringkasan')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('isi')
                    ->label('Isi Artikel')
                    ->visible(fn (Forms\Get $get): bool =>
                        $get('jenis') === 'artikel'
                    )
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('gambar')
                    ->label('Thumbnail / Gambar')
                    ->image()
                    ->disk('public')
                    ->directory('edukasi')
                    ->imageEditor()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('url_video')
                    ->label('URL Video')
                    ->url()
                    ->visible(fn (Forms\Get $get): bool =>
                        $get('jenis') === 'video'
                    ),

                Forms\Components\TextInput::make('durasi')
                    ->label('Durasi (menit)')
                    ->numeric()
                    ->suffix('menit')
                    ->minValue(1)
                    ->visible(fn (Get $get) => in_array($get('jenis'), ['video', 'artikel'])),

                Forms\Components\Select::make('status')
                    ->label('Status Publikasi')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->required()
                    ->live(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public')
                    ->height(60)
                    ->width(60),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->formatStateUsing(fn ($state): string => match ($state?->value ?? $state) {
                        'video' => 'Video',
                        'artikel' => 'Artikel',
                        default => ucfirst(str_replace('_', ' ', $state?->value ?? $state ?? '-')),
                    })
                    ->badge()
                    ->color(fn ($state): string => match ($state?->value ?? $state) {
                        'video' => 'info',
                        'artikel' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state): string => match ($state?->value ?? $state) {
                        'published' => 'Dipublikasikan',
                        'draft' => 'Draf',
                        default => ucfirst(str_replace('_', ' ', $state?->value ?? $state ?? '-')),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEdukasis::route('/'),
            'create' => Pages\CreateEdukasi::route('/create'),
            'edit' => Pages\EditEdukasi::route('/{record}/edit'),
        ];
    }
}