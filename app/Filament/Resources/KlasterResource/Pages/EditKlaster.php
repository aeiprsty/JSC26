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

class EditKlaster extends EditRecord
{
    protected static string $resource = KlasterResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function beforeSave(): void
    {
        $statusBaru = $this->data['status'] ?? null;
        $statusLama = $this->record->status;

        if (
            $statusBaru === StatusKlaster::Selesai->value
            && empty($this->data['foto_bukti'])
        ) {
            throw ValidationException::withMessages([
                'data.foto_bukti' => 'Foto bukti pembersihan wajib diunggah sebelum klaster diselesaikan.',
            ]);
        }

        if (
            $statusLama === StatusKlaster::Selesai
            && $statusBaru !== StatusKlaster::Selesai->value
        ) {
            throw ValidationException::withMessages([
                'data.status' => 'Klaster yang sudah selesai tidak dapat diubah kembali.',
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
}