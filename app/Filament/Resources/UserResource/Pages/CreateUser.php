<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Operator hanya boleh membuat akun petugas tertentu.
        abort_unless(
            in_array($data['role'] ?? null, [
                'kabid',
                'subkoordinator',
                'komando_lapangan',
            ], true),
            403
        );

        if (($data['role'] ?? null) !== 'komando_lapangan') {
            $data['tim_komando'] = null;
        }

        $data['is_active'] = true;

        return $data;
    }
}