<?php

namespace App\Filament\Resources\JadwalPenjemputanResource\Pages;

use App\Filament\Resources\JadwalPenjemputanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJadwalPenjemputan extends CreateRecord
{
    protected static string $resource = JadwalPenjemputanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
