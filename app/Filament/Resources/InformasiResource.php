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
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;

class InformasiResource extends Resource
{
    protected static ?string $model = Informasi::class;

   protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationLabel = 'Kelola Transparansi Dana';

    protected static ?string $navigationGroup = 'Informasi & Edukasi';

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

                Forms\Components\Select::make('ikon')
                    ->label('Pilih Ikon')
                    ->placeholder('Pilih simbol yang sesuai')
                    ->options(fn () => collect([
                        'fas fa-truck' => 'Truk Pengangkut Sampah',
                        'fas fa-trash' => 'Tempat Sampah',
                        'fas fa-recycle' => 'Daur Ulang',
                        'fas fa-broom' => 'Kebersihan',
                        'fas fa-dumpster' => 'Tempat Penampungan',
                        'fas fa-users' => 'Masyarakat',
                        'fas fa-user-group' => 'Kelompok Masyarakat',
                        'fas fa-user-tie' => 'Petugas',
                        'fas fa-handshake' => 'Kerja Sama',
                        'fas fa-leaf' => 'Lingkungan',
                        'fas fa-seedling' => 'Penghijauan',
                        'fas fa-tree' => 'Pohon',
                        'fas fa-droplet' => 'Air',
                        'fas fa-wallet' => 'Dana',
                        'fas fa-coins' => 'Keuangan',
                        'fas fa-chart-pie' => 'Statistik',
                        'fas fa-file-invoice-dollar' => 'Laporan Keuangan',
                        'fas fa-calendar-days' => 'Jadwal',
                        'fas fa-clock' => 'Jam Operasional',
                        'fas fa-building' => 'Gedung',
                        'fas fa-house' => 'Rumah',
                        'fas fa-location-dot' => 'Lokasi',
                        'fas fa-tools' => 'Peralatan',
                        'fas fa-wrench' => 'Perawatan',
                        'fas fa-gas-pump' => 'Bahan Bakar',
                        'fas fa-shield-halved' => 'Keamanan',
                        'fas fa-circle-check' => 'Selesai',
                        'fas fa-circle-info' => 'Informasi',
                        'fas fa-triangle-exclamation' => 'Peringatan',
                    ])->mapWithKeys(fn ($label, $icon) => [
                        $icon => view('filament.forms.components.icon-option', [
                            'icon' => $icon,
                            'label' => $label,
                        ])->render(),
                    ])->all())
                    ->allowHtml()
                    ->searchable()
                    ->native(false)
                    ->live()
                    ->required()
                    ->helperText('Pilih ikon yang paling sesuai dengan informasi.'),

                Forms\Components\Placeholder::make('preview_ikon')
                    ->label('Pratinjau Ikon')
                    ->content(fn (Get $get) => new HtmlString(
                        filled($get('ikon'))
                            ? '<i class="' . e($get('ikon')) . '" style="font-size: 24px;"></i>'
                            : '<span class="text-gray-400">Belum ada ikon dipilih</span>'
                    )),

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
                    ->sortable()
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->extraAttributes(['class' => 'text-left']),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->extraAttributes(['class' => 'text-left']),

                Tables\Columns\TextColumn::make('rincian')
                    ->label('Jumlah Rincian')
                    ->getStateUsing(function (\App\Models\Informasi $record): string {
                        return count($record->rincian ?? []) . ' poin';
                    })
                    ->alignment('center'),

                Tables\Columns\ViewColumn::make('ikon')
                    ->label('Ikon')
                    ->view('filament.tables.columns.icon-preview')
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Aktif')
                    ->boolean()
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->alignment('center'),
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