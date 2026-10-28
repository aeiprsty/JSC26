<?php

namespace App\Services;

use App\Models\Klaster;

class ClusterService
{
    /**
     * Mencari klaster terdekat yang masih aktif dalam radius tertentu (default 50 meter).
     */
    public function cariKlasterTerdekat($lat, $lng, $radius = 50)
    {
        $lat = (float) $lat;
        $lng = (float) $lng;

        return Klaster::whereNotIn('status', ['selesai', 'ditolak'])
            ->whereRaw("ST_Distance_Sphere(POINT(anchor_lng, anchor_lat), POINT(?, ?)) <= ?", [$lng, $lat, $radius])
            ->first();
    }
}