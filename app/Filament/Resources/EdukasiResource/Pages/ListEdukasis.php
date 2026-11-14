<?php

namespace App\Filament\Resources\EdukasiResource\Pages;

use App\Filament\Resources\EdukasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEdukasis extends ListRecords
{
    protected static string $resource = EdukasiResource::class;

    public function getTitle(): string
    {
        return 'Kelola Edukasi & Media';
    }

    public function getHeading(): string
    {
        return 'Kelola Edukasi & Media';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Edukasi & Media'),
        ];
    }
}