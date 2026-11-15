<?php

namespace App\Filament\Resources\KlasterRiwayatResource\Pages;

use App\Filament\Resources\KlasterRiwayatResource;
use Filament\Resources\Pages\ListRecords;

class ListKlasterRiwayats extends ListRecords
{
    protected static string $resource = KlasterRiwayatResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
