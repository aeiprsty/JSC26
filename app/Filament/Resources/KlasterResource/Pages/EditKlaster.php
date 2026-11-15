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
use App\Services\KlasterRiwayatService;

class EditKlaster extends EditRecord
{
    protected static string $resource = KlasterResource::class;

    protected mixed $statusSebelum = null;

    protected mixed $petugasSebelum = null;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function beforeSave(): void
    {
        $this->statusSebelum = $this->record->status;
        $this->petugasSebelum = $this->record->assigned_to;
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
        $this->record->refresh();

        $statusSaatIni = $this->record->status instanceof StatusKlaster
            ? $this->record->status->value
            : $this->record->status;

        // Jika klaster selesai, perbarui seluruh laporan di dalamnya.
        if ($statusSaatIni === StatusKlaster::Selesai->value) {
            $jumlahLaporan = DB::transaction(function (): int {
                return Laporan::query()
                    ->where('klaster_id', $this->record->getKey())
                    ->where('status', '!=', 'ditolak')
                    ->update([
                        'status' => 'selesai',
                    ]);
            });

            Notification::make()
                ->title('Klaster berhasil diselesaikan')
                ->body("{$jumlahLaporan} laporan berhasil diperbarui menjadi Selesai.")
                ->success()
                ->send();
        }

        // Catat riwayat setelah pembaruan laporan.
        KlasterRiwayatService::catat(
            klaster: $this->record,
            statusSebelum: $this->statusSebelum,
            statusSesudah: $this->record->status,
            petugasSebelum: $this->petugasSebelum,
            petugasSesudah: $this->record->assigned_to,
        );
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
        return KlasterResource::getUrl('index');
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