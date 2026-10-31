<?php

namespace App\Filament\Resources\JadwalPenjemputanResource\Pages;

use App\Filament\Resources\JadwalPenjemputanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJadwalPenjemputan extends EditRecord
{
    protected static string $resource = JadwalPenjemputanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}