<?php

namespace App\Filament\Resources\EdukasiResource\Pages;

use App\Filament\Resources\EdukasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEdukasi extends CreateRecord
{
    protected static string $resource = EdukasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
}
}