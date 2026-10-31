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

        // Operator: ringkasan berdasarkan status laporan.
        if ($role === 'operator') {
            $stats = [
                'menunggu' => Laporan::where('status', 'menunggu')->count(),
                'terverifikasi' => Laporan::where('status', 'terverifikasi')->count(),
                'dalam_proses' => Laporan::where('status', 'dalam_proses')->count(),
                'selesai' => Laporan::where('status', 'selesai')->count(),
                'ditolak' => Laporan::where('status', 'ditolak')->count(),
            ];

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
                ->values()
                ->all();

            return [
                'role' => $role,
                'stats' => $stats,
                'reports' => $reports,
                'clusters' => collect(),
                'mapPoints' => $mapPoints,
                'mapTitle' => 'Peta Sebaran Laporan TPS Liar',
            ];
        }

        // Ringkasan seluruh klaster berdasarkan status.
        $stats = [
            'menunggu_verifikasi' => Klaster::where(
                'status',
                StatusKlaster::MenungguVerifikasi
            )->count(),

            'terverifikasi' => Klaster::where(
                'status',
                StatusKlaster::Terverifikasi
            )->count(),

            'disposisi' => Klaster::where(
                'status',
                StatusKlaster::Disposisi
            )->count(),

            'ditugaskan' => Klaster::where(
                'status',
                StatusKlaster::Ditugaskan
            )->count(),

            'dalam_proses' => Klaster::where(
                'status',
                StatusKlaster::DalamProses
            )->count(),

            'selesai' => Klaster::where(
                'status',
                StatusKlaster::Selesai
            )->count(),

            'ditolak' => Klaster::where(
                'status',
                StatusKlaster::Ditolak
            )->count(),
        ];

        // Daftar klaster sesuai kewenangan role.
        $clusterQuery = Klaster::query()
            ->with('petugas')
            ->withCount('laporan');

        if ($role === 'kabid') {
            $clusterQuery->where(
                'status',
                StatusKlaster::Terverifikasi
            );
        } elseif ($role === 'subkoordinator') {
            $clusterQuery->where(
                'status',
                StatusKlaster::Disposisi
            );
        } elseif ($role === 'komando_lapangan') {
            $clusterQuery
                ->where('assigned_to', auth()->id())
                ->whereIn('status', [
                    StatusKlaster::Ditugaskan,
                    StatusKlaster::DalamProses,
                ]);
        }

        $clusters = $clusterQuery
            ->latest()
            ->limit(100)
            ->get();

        $mapPoints = $clusters
            ->filter(fn ($cluster) =>
                $cluster->anchor_lat !== null
                && $cluster->anchor_lng !== null
            )
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
            ->values()
            ->all();

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