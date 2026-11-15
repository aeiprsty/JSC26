<?php

namespace App\Filament\Resources\KlasterResource\Pages;

use App\Enums\StatusKlaster;
use App\Filament\Resources\KlasterResource;
use App\Models\Klaster;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\KlasterResource\Pages\EditKlaster;

class KelolaKlaster extends EditKlaster
{
    protected static string $resource = KlasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('verifikasi')
                ->label('Verifikasi Klaster')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool =>
                    auth()->user()?->role === 'operator'
                    && $this->record->status === StatusKlaster::MenungguVerifikasi
                )
                ->requiresConfirmation()
                ->modalHeading('Verifikasi Klaster')
                ->modalDescription(
                    'Sahkan klaster setelah semua laporan di dalamnya diperiksa?'
                )
                ->action(function (): void {
                    $berhasil = DB::transaction(function (): bool {
                        $record = Klaster::query()
                            ->whereKey($this->record->getKey())
                            ->lockForUpdate()
                            ->firstOrFail();

                        if (
                            auth()->user()?->role !== 'operator'
                            || $record->status !== StatusKlaster::MenungguVerifikasi
                            || ! $record->laporan()
                                ->where('status', 'terverifikasi')
                                ->exists()
                            || ! $record->laporan()->exists()
                            || $record->laporan()
                                ->where('status', 'menunggu')
                                ->exists()
                            || $record->laporan()
                                ->whereNotIn('status', [
                                    'terverifikasi',
                                    'ditolak',
                                    'selesai',
                                ])
                                ->exists()
                        ) {
                            return false;
                        }

                        $record->update([
                            'status' => StatusKlaster::Terverifikasi,
                        ]);

                        return true;
                    });

                    if (! $berhasil) {
                        Notification::make()
                            ->title('Klaster belum memenuhi syarat verifikasi')
                            ->warning()
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->title('Klaster berhasil diverifikasi')
                        ->success()
                        ->send();

                    $this->redirect(KlasterResource::getUrl('index'));
                }),

            Actions\Action::make('kembali')
                ->label('Kembali ke Daftar Klaster')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(KlasterResource::getUrl('index')),
        ];
    }

    protected function getFormActions(): array
    {
        // Operator hanya memeriksa dan memverifikasi.
        if (auth()->user()?->role === 'operator') {
            return [];
        }

        return parent::getFormActions();
    }

    protected function authorizeAccess(): void
    {
        abort_unless(
            auth()->user()?->role === 'operator'
            || static::getResource()::canEdit($this->getRecord()),
            403
        );
    }
}