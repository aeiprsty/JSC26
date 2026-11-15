<?php

namespace App\Filament\Resources\KlasterRiwayatResource\Pages;

use App\Filament\Resources\KlasterRiwayatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKlasterRiwayat extends EditRecord
{
    protected static string $resource = KlasterRiwayatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
