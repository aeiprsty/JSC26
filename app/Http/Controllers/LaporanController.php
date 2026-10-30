<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClusterService;
use App\Models\Klaster;
use App\Models\Laporan;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    protected $clusterService;

    // Inject ClusterService melalui constructor
    public function __construct(ClusterService $clusterService)
    {
        $this->clusterService = $clusterService;
    }

    public function store(Request $request)
    {
        if ($request->filled('website')) {
            return response()->json([
                'success' => false,
                'message' => 'Aktivitas mencurigakan terdeteksi.'
            ], 422); // Forbidden
        }
        // 1. Validasi input dari form warga
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'deskripsi' => 'required|string',
            // tambahkan validasi foto/field lain jika ada
        ]);

        $lat = $request->lat;
        $lng = $request->lng;

        // 2. Cari klaster aktif terdekat menggunakan ClusterService (radius default 50m)
        $klaster = $this->clusterService->cariKlasterTerdekat($lat, $lng);

        // 3. Jika tidak ada klaster aktif dalam radius 50 meter, buat klaster baru
        if (!$klaster) {
            $klaster = Klaster::create([
                'anchor_lat' => $lat,
                'anchor_lng' => $lng,
                'status' => 'menunggu_verifikasi',
            ]);
        }

        // 4. Simpan laporan baru (tiket terpisah) dan hubungkan ke klaster_id
        $laporan = Laporan::create([
            'klaster_id' => $klaster->id,
            'lat' => $lat,
            'lng' => $lng,
            'deskripsi' => $request->deskripsi,
            // 'foto' => ...
        ]);

        // Respon sukses (bisa disesuaikan dengan redirect atau JSON response)
        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim dan dipetakan ke klaster!',
            'data' => [
                'laporan_id' => $laporan->id,
                'klaster_id' => $klaster->id,
            ]
        ], 201);
    }
}