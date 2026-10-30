<?php

namespace App\Services;

use App\Enums\StatusKlaster;
use App\Models\Klaster;
use App\Models\Laporan;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use LogicException;

class ClusterService
{
    private const RADIUS_METERS = 50;

    /**
     * Menghubungkan laporan yang sudah tersimpan ke klaster aktif
     * terdekat dalam radius 50 meter, atau membuat klaster baru.
     *
     * Pemanggilan sebaiknya dilakukan di dalam DB::transaction()
     * pada proses penerimaan laporan.
     */
    public function assignToCluster(Laporan $laporan): Klaster
    {
        if (! $laporan->exists) {
            throw new LogicException(
                'Laporan harus disimpan sebelum dimasukkan ke klaster.'
            );
        }

        $lat = (float) $laporan->lat;
        $lng = (float) $laporan->lng;

        if (
            ! is_finite($lat) ||
            ! is_finite($lng) ||
            $lat < -90 ||
            $lat > 90 ||
            $lng < -180 ||
            $lng > 180
        ) {
            throw new InvalidArgumentException(
                'Koordinat laporan tidak valid.'
            );
        }

        // Batas koordinat untuk menyaring kandidat klaster.
        $latDelta = self::RADIUS_METERS / 111_320;
        $cosLat = cos(deg2rad($lat));

        // Hindari pembagian dengan angka mendekati nol.
        $lngDelta = abs($cosLat) < 0.000001
            ? 180
            : min(180, self::RADIUS_METERS / (111_320 * abs($cosLat)));

        $activeStatuses = [
            StatusKlaster::MenungguVerifikasi->value,
        ];

        $candidates = Klaster::query()
            ->whereIn('status', $activeStatuses)
            ->whereBetween('anchor_lat', [
                max(-90, $lat - $latDelta),
                min(90, $lat + $latDelta),
            ])
            ->whereBetween('anchor_lng', [
                max(-180, $lng - $lngDelta),
                min(180, $lng + $lngDelta),
            ])
            ->get();

        $nearest = $this->findNearestCluster($candidates, $lat, $lng);

        $klaster = $nearest ?? Klaster::create([
            'anchor_lat' => $lat,
            'anchor_lng' => $lng,
            'status' => StatusKlaster::MenungguVerifikasi->value,
        ]);

        $laporan->klaster()->associate($klaster);
        $laporan->save();

        return $klaster;
    }

    private function findNearestCluster(
        Collection $candidates,
        float $lat,
        float $lng
    ): ?Klaster {
        $nearest = null;
        $nearestDistance = self::RADIUS_METERS;

        foreach ($candidates as $candidate) {
            $distance = $this->distanceInMeters(
                $lat,
                $lng,
                (float) $candidate->anchor_lat,
                (float) $candidate->anchor_lng,
            );

            if ($distance <= $nearestDistance) {
                $nearest = $candidate;
                $nearestDistance = $distance;
            }
        }

        return $nearest;
    }

    public function distanceInMeters(
        float $lat1,
        float $lng1,
        float $lat2,
        float $lng2
    ): float {
        $earthRadius = 6_371_000;

        $latDifference = deg2rad($lat2 - $lat1);
        $lngDifference = deg2rad($lng2 - $lng1);

        $a = sin($latDifference / 2) ** 2
            + cos(deg2rad($lat1))
            * cos(deg2rad($lat2))
            * sin($lngDifference / 2) ** 2;

        $a = min(1, max(0, $a));

        return 2 * $earthRadius * asin(sqrt($a));
    }
}