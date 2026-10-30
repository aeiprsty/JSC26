<?php

namespace App\Filament\Widgets;

use App\Models\Klaster;
use App\Models\Laporan;
use App\Enums\StatusKlaster;
use Filament\Widgets\Widget;

class DashboardOverview extends Widget
{
    protected static string $view = 'filament.widgets.dashboard-overview';

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $role = auth()->user()?->role;

        // Ringkasan jumlah laporan berdasarkan status.
        $stats = [
            'menunggu' => Laporan::where('status', 'menunggu')->count(),
            'terverifikasi' => Laporan::where('status', 'terverifikasi')->count(),
            'dalam_proses' => Laporan::where('status', 'dalam_proses')->count(),
            'selesai' => Laporan::where('status', 'selesai')->count(),
            'ditolak' => Laporan::where('status', 'ditolak')->count(),
        ];

        if ($role === 'operator') {
            $reports = Laporan::query()
                ->latest()
                ->limit(10)
                ->get();

            $mapPoints = Laporan::query()
                ->whereNotNull('lat')
                ->whereNotNull('lng')
                ->latest()
                ->limit(500)
                ->get()
                ->map(fn ($report) => [
                    'lat' => (float) $report->lat,
                    'lng' => (float) $report->lng,
                    'title' => $report->kode_tiket,
                    'description' => $report->deskripsi ?? 'Tidak ada deskripsi',
                    'status' => $report->status,
                ])
                ->values();

            return [
                'role' => $role,
                'stats' => $stats,
                'reports' => $reports,
                'clusters' => collect(),
                'mapPoints' => $mapPoints,
                'mapTitle' => 'Peta Sebaran Laporan TPS Liar',
            ];
        }

        // Batasi klaster sesuai kewenangan pengguna.
        $clusterQuery = Klaster::query()
            ->with('petugas')
            ->withCount('laporan');

        if ($role === 'kabid') {
            $clusterQuery->where(
                'status',
                StatusKlaster::Terverifikasi->value
            );
        } elseif ($role === 'subkoordinator') {
            $clusterQuery->where(
                'status',
                StatusKlaster::Disposisi->value
            );
        } elseif ($role === 'komando_lapangan') {
            $clusterQuery
                ->where('assigned_to', auth()->id())
                ->whereIn('status', [
                    StatusKlaster::Ditugaskan->value,
                    StatusKlaster::DalamProses->value,
                ]);
        }

        $clusters = $clusterQuery
            ->latest()
            ->limit(100)
            ->get();

        $mapPoints = $clusters
            ->map(fn ($cluster) => [
                'lat' => (float) $cluster->anchor_lat,
                'lng' => (float) $cluster->anchor_lng,
                'title' => 'Klaster #' . $cluster->id,
                'description' => $cluster->laporan_count . ' laporan',
                'status' => $cluster->status->value,
                'url' => \App\Filament\Resources\KlasterResource::getUrl(
                    'view',
                    ['record' => $cluster]
                ),
            ])
            ->values();

        return [
            'role' => $role,
            'stats' => $stats,
            'reports' => collect(),
            'clusters' => $clusters,
            'mapPoints' => $mapPoints,
            'mapTitle' => 'Peta Sebaran Klaster TPS Liar',
        ];
    }
}