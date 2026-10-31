<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Pengelolaan Akun';

    protected static ?string $modelLabel = 'Akun';

    protected static ?string $pluralModelLabel = 'Pengelolaan Akun';

    protected static ?string $navigationGroup = 'Manajemen Pengguna';

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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('role', [
                'kabid',
                'subkoordinator',
                'komando_lapangan',
                'operator',
            ])
            ->orderByRaw("
                CASE
                    WHEN role = 'kabid' THEN 1
                    WHEN role = 'subkoordinator' THEN 2
                    WHEN role = 'komando_lapangan' THEN 3
                    WHEN role = 'operator' THEN 4
                    ELSE 5
                END
            ")
            ->orderBy('tim_komando');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Forms\Components\Select::make('role')
                ->label('Jabatan')
                ->options([
                    'kabid' => 'Kabid',
                    'subkoordinator' => 'Subkoordinator',
                    'komando_lapangan' => 'Komando Lapangan',
                ])
                ->required()
                ->disabled(fn (?User $record) => $record !== null)
                ->dehydrated(),

            Forms\Components\Select::make('tim_komando')
                ->label('Tim Komando')
                ->options([
                    'A' => 'Komando A',
                    'B' => 'Komando B',
                    'C' => 'Komando C',
                    'D' => 'Komando D',
                ])
                ->visible(fn (Forms\Get $get) => $get('role') === 'komando_lapangan')
                ->required(fn (Forms\Get $get) => $get('role') === 'komando_lapangan')
                ->dehydrated(),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->required(fn (string $operation) => $operation === 'create')
                ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : null)
                ->dehydrated(fn ($state) => filled($state))
                ->minLength(8),

            Forms\Components\Toggle::make('is_active')
                ->label('Status Akun')
                ->onColor('success')
                ->offColor('danger')
                ->onIcon('heroicon-m-check')
                ->offIcon('heroicon-m-x-mark')
                ->default(true)
                ->visible(fn (?User $record) => $record?->role !== 'operator')
                ->dehydrated(fn (?User $record) => $record?->role !== 'operator'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Jabatan')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'operator' => 'Operator',
                        'kabid' => 'Kabid',
                        'subkoordinator' => 'Subkoordinator',
                        'komando_lapangan' => 'Komando Lapangan',
                        default => $state,
                    })
                    ->badge(),

                Tables\Columns\TextColumn::make('tim_komando')
                    ->label('Tim')
                    ->formatStateUsing(fn ($state) => $state ? "Komando {$state}" : '-'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status Akun')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Jabatan')
                    ->options([
                        'operator' => 'Operator',
                        'kabid' => 'Kabid',
                        'subkoordinator' => 'Subkoordinator',
                        'komando_lapangan' => 'Komando Lapangan',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Akun')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\Action::make('toggle_status')
                    ->label(fn (User $record) => $record->is_active ? 'Nonaktifkan' : 'Aktifkan')
                    ->icon(fn (User $record) => $record->is_active
                        ? 'heroicon-o-no-symbol'
                        : 'heroicon-o-check-circle')
                    ->color(fn (User $record) => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn (User $record) => $record->is_active
                        ? 'Nonaktifkan Akun?'
                        : 'Aktifkan Akun?')
                    ->visible(fn (User $record) => $record->role !== 'operator')
                    ->action(fn (User $record) => $record->update([
                        'is_active' => ! $record->is_active,
                    ])),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}