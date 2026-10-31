<?php

namespace App\Filament\Resources\KlasterResource\Pages;

use App\Enums\StatusKlaster;
use App\Filament\Resources\KlasterResource;
use App\Models\Laporan;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Arr;

class EditKlaster extends EditRecord
{
    protected static string $resource = KlasterResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function beforeSave(): void
    {
        $role = auth()->user()?->role;

        $statusLama = $this->record->status instanceof StatusKlaster
            ? $this->record->status->value
            : $this->record->status;

        $statusBaru = $this->data['status'] ?? $statusLama;

        $transitions = [
            'kabid' => [
                StatusKlaster::Terverifikasi->value =>
                    StatusKlaster::Disposisi->value,
            ],

            'subkoordinator' => [
                StatusKlaster::Disposisi->value =>
                    StatusKlaster::Ditugaskan->value,
            ],

            'komando_lapangan' => [
                StatusKlaster::Ditugaskan->value =>
                    StatusKlaster::DalamProses->value,

                StatusKlaster::DalamProses->value =>
                    StatusKlaster::Selesai->value,
            ],
        ];

        if (
            ! isset($transitions[$role][$statusLama])
            || $transitions[$role][$statusLama] !== $statusBaru
        ) {
            throw ValidationException::withMessages([
                'data.status' => 'Perubahan status tidak sesuai kewenangan atau alur klaster.',
            ]);
        }

        // Hanya Subkoordinator yang boleh mengubah penugasan.
        $assignedToLama = (string) ($this->record->assigned_to ?? '');

        $assignedToBaru = (string) (
            $this->data['assigned_to'] ?? $assignedToLama
        );

        if (
            $role !== 'subkoordinator'
            && $assignedToBaru !== $assignedToLama
        ) {
            throw ValidationException::withMessages([
                'data.assigned_to' => 'Anda tidak memiliki kewenangan mengubah petugas.',
            ]);
        }

        // Pastikan petugas yang dipilih benar-benar Komando Lapangan.
        if ($role === 'subkoordinator') {
            $petugasValid = User::query()
                ->whereKey($assignedToBaru)
                ->where('role', 'komando_lapangan')
                ->where('is_active', true)
                ->exists();

            if (! $petugasValid) {
                throw ValidationException::withMessages([
                    'data.assigned_to' => 'Petugas yang dipilih tidak valid.',
                ]);
            }
        }

        // Foto bukti wajib saat klaster diselesaikan.
        if (
            $statusBaru === StatusKlaster::Selesai->value
            && empty($this->data['foto_bukti'])
        ) {
            throw ValidationException::withMessages([
                'data.foto_bukti' => 'Foto bukti pembersihan wajib diunggah sebelum klaster diselesaikan.',
            ]);
        }
    }

    protected function afterSave(): void
    {
        if ($this->record->status !== StatusKlaster::Selesai) {
            return;
        }

        DB::transaction(function (): void {
            Laporan::query()
                ->where('klaster_id', $this->record->id)
                ->where('status', '!=', 'ditolak')
                ->update(['status' => 'selesai']);
        });

        Notification::make()
            ->title('Klaster berhasil disimpan')
            ->body('Status laporan yang valid dalam klaster ini telah diperbarui.')
            ->success()
            ->send();
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return match (auth()->user()?->role) {
            'kabid' => Arr::only($data, [
                'status',
            ]),

            'subkoordinator' => Arr::only($data, [
                'status',
                'assigned_to',
            ]),

            'komando_lapangan' => Arr::only($data, [
                'status',
                'foto_bukti',
            ]),

            default => [],
        };
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $status = $this->record->status instanceof StatusKlaster
            ? $this->record->status->value
            : $this->record->status;

        $data['status'] = match (auth()->user()?->role) {
            'kabid' => StatusKlaster::Disposisi->value,
            'subkoordinator' => StatusKlaster::Ditugaskan->value,
            default => $status,
        };

        return $data;
    }
}