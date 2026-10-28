<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Services\ClusterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class LaporanController extends Controller
{
    public function store(
        Request $request,
        ClusterService $clusterService
    ): JsonResponse {
        $validated = $request->validate([
            'foto' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'lat' => [
                'required',
                'numeric',
                'between:-90,90',
            ],
            'lng' => [
                'required',
                'numeric',
                'between:-180,180',
            ],
        ]);

        // Simpan foto pada disk public.
        $fotoPath = $request->file('foto')->store(
            'laporan',
            'public'
        );

        try {
            $laporan = DB::transaction(function () use (
                $validated,
                $fotoPath,
                $clusterService
            ): Laporan {
                // Buat kode tiket yang unik.
                do {
                    $kodeTiket = 'TPS-' . Str::upper(
                        Str::random(10)
                    );
                } while (
                    Laporan::where('kode_tiket', $kodeTiket)->exists()
                );

                $laporan = Laporan::create([
                    'kode_tiket' => $kodeTiket,
                    'foto' => $fotoPath,
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'lat' => $validated['lat'],
                    'lng' => $validated['lng'],
                    'status' => 'menunggu',
                    'klaster_id' => null,
                    'alasan_tolak' => null,
                ]);

                // Cari klaster aktif atau buat klaster baru.
                $klaster = $clusterService->assignToCluster(
                    $laporan
                );

                return $laporan->refresh();
            });

            return response()->json([
                'message' => 'Laporan berhasil dikirim.',
                'data' => [
                    'kode_tiket' => $laporan->kode_tiket,
                    'status' => $laporan->status,
                    'klaster_id' => $laporan->klaster_id,
                ],
            ], 201);
        } catch (Throwable $exception) {
            // Hindari meninggalkan foto jika penyimpanan gagal.
            Storage::disk('public')->delete($fotoPath);

            throw $exception;
        }
    }
}