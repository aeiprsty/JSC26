<?php

namespace App\Filament\Resources\KlasterResource\Pages;

use App\Filament\Resources\KlasterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKlaster extends ViewRecord
{
    protected static string $resource = KlasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali')
                ->label('Kembali ke Daftar Klaster')
                ->icon('heroicon-o-arrow-left')
                ->url(KlasterResource::getUrl('index')),
        ];
    }
}