<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;

class KlasterSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Klaster Aktif untuk Uji Radius Dekat & Jauh
        Klaster::create([
            'anchor_lat' => -1.6091000,
            'anchor_lng' => 103.6072000,
            'status' => 'menunggu_verifikasi',
        ]);

        // 2. Klaster Selesai (Harus diabaikan oleh sistem)
        Klaster::create([
            'anchor_lat' => -1.6150000,
            'anchor_lng' => 103.6100000,
            'status' => 'selesai',
        ]);

        // 3. Klaster Ditolak (Disimpan untuk audit, diabaikan dari klaster aktif)
        Klaster::create([
            'anchor_lat' => -1.6200000,
            'anchor_lng' => 103.6150000,
            'status' => 'ditolak',
        ]);
    }
}
