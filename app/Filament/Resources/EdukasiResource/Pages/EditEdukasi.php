<?php

namespace App\Filament\Resources\EdukasiResource\Pages;

use App\Filament\Resources\EdukasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEdukasi extends EditRecord
{
    protected static string $resource = EdukasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus'),
        ];
    }
}