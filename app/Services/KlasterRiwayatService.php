<?php

namespace App\Services;

use App\Models\Klaster;
use App\Models\KlasterRiwayat;
use App\Models\Laporan;

class KlasterRiwayatService
{
    public static function catat(
        Klaster $klaster,
        mixed $statusSebelum,
        mixed $statusSesudah,
        mixed $petugasSebelum = null,
        mixed $petugasSesudah = null,
        ?string $keterangan = null,
    ): void {
        $statusSebelum = $statusSebelum instanceof \BackedEnum
            ? $statusSebelum->value
            : $statusSebelum;

        $statusSesudah = $statusSesudah instanceof \BackedEnum
            ? $statusSesudah->value
            : $statusSesudah;

        $petugasBerubah = (string) ($petugasSebelum ?? '')
            !== (string) ($petugasSesudah ?? '');

        if ($statusSebelum === $statusSesudah && ! $petugasBerubah) {
            return;
        }

        $aktivitas = match ($statusSesudah) {
            'terverifikasi' => 'Verifikasi Klaster',
            'disposisi' => 'Disposisi Klaster',
            'ditugaskan' => 'Penugasan Petugas',
            'dalam_proses' => 'Mulai Pengerjaan',
            'selesai' => 'Penyelesaian Klaster',
            'ditolak' => 'Penolakan Klaster',
            default => $petugasBerubah
                ? 'Perubahan Penugasan'
                : 'Perubahan Status',
        };

        KlasterRiwayat::create([
            'klaster_id' => $klaster->id,
            'user_id' => auth()->id(),
            'role' => auth()->user()?->role,
            'aktivitas' => $aktivitas,
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => $statusSesudah,
            'assigned_to_sebelum' => $petugasSebelum,
            'assigned_to_sesudah' => $petugasSesudah,
            'keterangan' => $keterangan,
        ]);
    }

    public static function catatLaporan(
        Laporan $laporan,
        string $statusSebelum,
        string $statusSesudah,
        ?string $keterangan = null,
        ?int $klasterId = null,
    ): void {
        KlasterRiwayat::create([
            'klaster_id' => $klasterId ?? $laporan->klaster_id,
            'laporan_id' => $laporan->id,
            'user_id' => auth()->id(),
            'role' => auth()->user()?->role,
            'aktivitas' => match ($statusSesudah) {
                'terverifikasi' => 'Verifikasi Laporan',
                'ditolak' => 'Penolakan Laporan',
                default => 'Perubahan Status Laporan',
            },
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => $statusSesudah,
            'keterangan' => $keterangan,
        ]);
    }

}