<div class="w-full min-w-0 space-y-6">

    {{-- RINGKASAN --}}
    <div>
        <h2 class="text-lg font-bold mb-3">Ringkasan Laporan</h2>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            @php
                $cards = [
                    ['label' => 'Menunggu', 'key' => 'menunggu', 'color' => 'warning'],
                    ['label' => 'Terverifikasi', 'key' => 'terverifikasi', 'color' => 'info'],
                    ['label' => 'Dalam Proses', 'key' => 'dalam_proses', 'color' => 'primary'],
                    ['label' => 'Selesai', 'key' => 'selesai', 'color' => 'success'],
                    ['label' => 'Ditolak', 'key' => 'ditolak', 'color' => 'danger'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $card['label'] }}
                    </p>

                    <p class="text-2xl font-bold mt-1">
                        {{ $stats[$card['key']] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- DAFTAR LAPORAN OPERATOR --}}
    @if ($role === 'operator')
        <div class="rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Laporan Terbaru</h2>

                <a
                    href="{{ \App\Filament\Resources\LaporanResource::getUrl('index') }}"
                    class="text-primary-600 hover:underline text-sm font-medium"
                >
                    Kelola Semua Laporan
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b dark:border-gray-700 text-left">
                            <th class="p-3">Kode Tiket</th>
                            <th class="p-3">Deskripsi</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Waktu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($reports as $report)
                            <tr class="border-b dark:border-gray-800">
                                <td class="p-3 font-medium">
                                    {{ $report->kode_tiket }}
                                </td>
                                <td class="p-3">
                                    {{ \Illuminate\Support\Str::limit($report->deskripsi ?? '-', 45) }}
                                </td>
                                <td class="p-3">
                                    <span class="capitalize">
                                        {{ str_replace('_', ' ', $report->status) }}
                                    </span>
                                </td>
                                <td class="p-3 whitespace-nowrap">
                                    {{ $report->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">
                                    Belum ada laporan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else

        {{-- DAFTAR KLASTER ROLE PENANGANAN --}}
        <div class="rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <h2 class="text-lg font-bold mb-4">Daftar Klaster</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b dark:border-gray-700 text-left">
                            <th class="p-3">ID Klaster</th>
                            <th class="p-3">Jumlah Laporan</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Petugas</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($clusters as $cluster)
                            <tr class="border-b dark:border-gray-800">
                                <td class="p-3">#{{ $cluster->id }}</td>
                                <td class="p-3">{{ $cluster->laporan_count }}</td>
                                <td class="p-3 capitalize">
                                    {{ str_replace('_', ' ', $cluster->status->value) }}
                                </td>
                                <td class="p-3">
                                    {{ $cluster->petugas?->name ?? 'Belum ditugaskan' }}
                                </td>
                                <td class="p-3">
                                    <a
                                        href="{{ \App\Filament\Resources\KlasterResource::getUrl('view', ['record' => $cluster]) }}"
                                        class="text-primary-600 hover:underline font-medium"
                                    >
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">
                                    Belum ada klaster yang perlu ditangani.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    
    {{-- PETA --}}
    <div class="rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
        <h2 class="text-lg font-bold mb-3">{{ $mapTitle }}</h2>

        <div
            id="dashboard-map-{{ $this->getId() }}"
            wire:ignore
            x-data="{
                initMap(element, points) {
                    const drawMap = () => {
                        if (!window.L) {
                            setTimeout(drawMap, 200);
                            return;
                        }

                        if (element._leaflet_id) return;

                        const map = L.map(element).setView([-1.6101, 103.6131], 13);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(map);

                        points.forEach(point => {
                            const marker = L.marker([point.lat, point.lng]).addTo(map);

                            const popup = document.createElement('div');

                            const title = document.createElement('strong');
                            title.textContent = point.title;

                            const description = document.createElement('p');
                            description.textContent = point.description;

                            const status = document.createElement('p');
                            status.textContent = 'Status: ' + point.status.replaceAll('_', ' ');

                            popup.append(title, description, status);

                            if (point.url) {
                                const link = document.createElement('a');
                                link.href = point.url;
                                link.textContent = 'Lihat Detail Klaster';
                                popup.append(link);
                            }

                            marker.bindPopup(popup);
                        });

                        if (points.length > 0) {
                            map.fitBounds(
                                L.latLngBounds(points.map(point => [point.lat, point.lng])),
                                { padding: [30, 30], maxZoom: 16 }
                            );
                        }

                        setTimeout(() => map.invalidateSize(), 300);

                        console.log('Peta berhasil diinisialisasi:', points);
                    };

                    drawMap();
                }
            }"
            x-init="$nextTick(() => initMap($el, @js($mapPoints)))"
            style="height: 420px; width: 100%; border-radius: 12px; z-index: 1;"
        ></div>
    </div>
    
    {{-- LEAFLET --}}
    @assets
        <link
            rel="stylesheet"
            href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @endassets

</div>