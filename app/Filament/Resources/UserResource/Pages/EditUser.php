<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->record;

        // Role akun tidak boleh diubah melalui manipulasi request.
        $data['role'] = $record->role;

        // Akun Operator tidak boleh dinonaktifkan.
        if ($record->role === 'operator') {
            $data['is_active'] = $record->is_active;
            $data['tim_komando'] = null;
        }

        if ($record->role !== 'komando_lapangan') {
            $data['tim_komando'] = null;
        }

        return $data;
    }
}