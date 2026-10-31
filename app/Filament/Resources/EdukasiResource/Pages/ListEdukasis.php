<?php

namespace App\Filament\Resources\EdukasiResource\Pages;

use App\Filament\Resources\EdukasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEdukasis extends ListRecords
{
    protected static string $resource = EdukasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Edukasi'),
        ];
    }
}