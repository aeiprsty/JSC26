<?php

namespace App\Filament\Resources\JadwalPenjemputanResource\Pages;

use App\Filament\Resources\JadwalPenjemputanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJadwalPenjemputans extends ListRecords
{
    protected static string $resource = JadwalPenjemputanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
