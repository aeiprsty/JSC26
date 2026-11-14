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
use Filament\Forms\Set;
use Illuminate\Support\Str;
use App\Services\YouTubeService;
use Filament\Notifications\Notification;

class EdukasiResource extends Resource
{
    protected static ?string $model = Edukasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Kelola Edukasi & Media';

    protected static ?string $navigationGroup = 'Informasi & Edukasi';

    protected static ?int $navigationSort = 3;

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
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('slug', Str::slug($state ?? ''));
                    })
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('penulis')
                    ->label('Nama Penulis')
                    ->placeholder('Masukkan nama penulis artikel')
                    ->maxLength(100)
                    ->visible(fn (Get $get) => $get('jenis') === 'artikel'),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Terbentuk otomatis dari judul, tetapi bisa diubah secara manual.'),

                Forms\Components\Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Lingkungan Hidup & Pengelolaan Sampah' => 'Lingkungan Hidup & Pengelolaan Sampah',
                        'Kesehatan & Sanitasi' => 'Kesehatan & Sanitasi',
                        'Kebijakan & Layanan Publik' => 'Kebijakan & Layanan Publik',
                        'Aksi Sosial & Komunitas' => 'Aksi Sosial & Komunitas',
                        'Tips & Gaya Hidup' => 'Tips & Gaya Hidup',
                    ])
                    ->placeholder('Pilih kategori edukasi')
                    ->native(false)
                    ->searchable()
                    ->required(),

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
                    ->label('Gambar Artikel')
                    ->image()
                    ->disk('public')
                    ->directory('edukasi')
                    ->imageEditor()
                    ->visible(fn (Forms\Get $get): bool =>
                        $get('jenis') === 'artikel'
                    )
                    ->columnSpanFull(),


                Forms\Components\TextInput::make('url_video')
                    ->label('URL Video YouTube')
                    ->url()
                    ->visible(fn (Get $get) => $get('jenis') === 'video')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (?string $state, Set $set) {
                        if (!$state) {
                            $set('durasi', null);
                            return;
                        }

                        $durasi = app(YouTubeService::class)->getDuration($state);

                        if ($durasi) {
                            $set('durasi', $durasi);

                            Notification::make()
                                ->success()
                                ->title('Durasi video berhasil diambil')
                                ->body("Durasi video: {$durasi}")
                                ->send();
                        } else {
                            $set('durasi', null);

                            Notification::make()
                                ->warning()
                                ->title('Durasi video tidak berhasil diambil')
                                ->body('Periksa URL YouTube atau konfigurasi API Key.')
                                ->send();
                        }
                    }),

                Forms\Components\TextInput::make('durasi')
                    ->label(fn (Get $get) =>
                        $get('jenis') === 'video' ? 'Durasi Video' : 'Estimasi Waktu Baca'
                    )
                    ->placeholder(fn (Get $get) =>
                        $get('jenis') === 'video' ? 'Otomatis dari YouTube' : 'Contoh: 5 menit'
                    )
                    ->readOnly(fn (Get $get) => $get('jenis') === 'video')
                    ->helperText(fn (Get $get) =>
                        $get('jenis') === 'video'
                            ? 'Durasi diambil otomatis setelah URL YouTube diisi.'
                            : 'Isi estimasi waktu membaca artikel.'
                    )
                    ->visible(fn (Get $get) => in_array($get('jenis'), ['video', 'artikel']))
                    ->dehydrated(),

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
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Gambar')
                    ->height(60)
                    ->width(100)
                    ->extraImgAttributes([
                        'class' => 'object-cover rounded-lg',
                    ])
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                
                Tables\Columns\TextColumn::make('penulis')
                    ->label('Penulis')
                    ->searchable()
                    ->placeholder('-')
                    ->alignment('center'),

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
                    })
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state): string => match ($state?->value ?? $state) {
                        'published' => 'Dipublikasikan',
                        'draft' => 'Draf',
                        default => ucfirst(str_replace('_', ' ', $state?->value ?? $state ?? '-')),
                    })
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->alignment('center'),
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