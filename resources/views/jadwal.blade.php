<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- PWA Configuration -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#1F3D2E">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="JambiBersih">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-512.png') }}">

    <title>Jadwal OPBM - JambiBersih</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-angsa.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Inter & Font Awesome Icons (Link CDN Sudah Diperbaiki) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#DCC8A3]/30 text-[#5A4A3A] antialiased min-h-screen flex flex-col">

    <!-- ==========================================
         NAVBAR UTAMA (KONSISTEN DI SEMUA HALAMAN)
         ========================================== -->
    <header class="sticky top-0 z-50 bg-[#1F3D2E] text-white shadow-md transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Branding -->
                <a href="{{ url('/') }}" class="flex items-center gap-1 group">
                    <!-- Logo simbol -->
                    <img
                        src="{{ asset('images/logo-angsa.png') }}"
                        alt="Logo JambiBersih"
                        class="w-10 h-10 object-contain"
                    >

                    <!-- Tulisan JambiBersih -->
                    <img
                        src="{{ asset('images/font-angsa.png') }}"
                        alt="JambiBersih"
                        class="h-11 w-auto object-contain"
                    >
                </a>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex items-center gap-8 ml-auto">
                    <a href="{{ url('/') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors">
                        Beranda
                    </a>
                    
                    <a href="{{ url('/lapor') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors">
                        Lapor TPS
                    </a>

                    <a href="{{ url('/lacak') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors">
                        Cek Penanganan TPS
                    </a>

                    <!-- Dropdown Informasi & Edukasi (Active Highlight) -->
                    <div class="relative group" id="desktop-dropdown">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-white bg-white/10 transition-colors focus:outline-none" onclick="toggleDropdown('desktop-menu')">
                            <span>Informasi & Edukasi</span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                        </button>
                        
                        <div id="desktop-menu" class="hidden group-hover:block absolute right-0 mt-1 w-64 bg-white rounded-xl shadow-xl border border-[#5A4A3A]/10 py-2 text-[#5A4A3A] z-50 animate-fadeIn">
                            <a href="{{ url('/jadwal') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold bg-[#DCC8A3]/30 text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#6B7F4E] text-white flex items-center justify-center">
                                    <i class="fa-solid fa-calendar-alt text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-bold">Jadwal OPBM</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Layanan Kebersihan Wilayah</div>
                                </div>
                            </a>
                            <a href="{{ url('/transparansi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#4C6A73]/10 flex items-center justify-center text-[#4C6A73]">
                                    <i class="fa-solid fa-chart-pie text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Transparansi Dana</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Rincian Komponen Alokasi</div>
                                </div>
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ url('/edukasi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#1F3D2E]/10 flex items-center justify-center text-[#1F3D2E]">
                                    <i class="fa-solid fa-book-open text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Edukasi & Media</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Artikel, Tips & Video Edukasi</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Mobile Hamburger Button -->
                <div class="md:hidden flex items-center">
                    <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-lg text-emerald-100 hover:text-white hover:bg-white/10 focus:outline-none">
                        <i id="hamburger-icon" class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Navigation Panel -->
        <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-[#1F3D2E] border-t border-b border-white/10 px-4 pt-3 pb-6 space-y-2 shadow-2xl z-50">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Beranda
            </a>
            <a href="{{ url('/lapor') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Lapor TPS
            </a>
            <a href="{{ url('/lacak') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Cek Penanganan TPS
            </a>
            
            <div class="pt-2 border-t border-white/10">
                <div class="px-3 py-1 text-xs font-semibold text-[#DCC8A3] uppercase tracking-wider">
                    Informasi & Edukasi
                </div>

                <a href="{{ url('/jadwal') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-white bg-white/10 rounded-lg">
                    <i class="fa-solid fa-calendar-alt text-xs text-[#6B7F4E]"></i>
                    <span>Jadwal OPBM</span>
                </a>

                <a href="{{ url('/transparansi') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-chart-pie text-xs"></i>
                    <span>Transparansi Dana</span>
                </a>

                <a href="{{ url('/edukasi') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-book-open text-xs"></i>
                    <span>Edukasi & Media</span>
                </a>
            </div>
        </div>
    </header>

    <!-- ==========================================
         MAIN CONTENT: HALAMAN JADWAL OPBM
         ========================================== -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto w-full">
        
        <!-- HEADER HALAMAN -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="bg-[#6B7F4E]/20 text-[#1F3D2E] text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5">
                <i class="fa-solid fa-truck-ramp-box text-[#6B7F4E]"></i> Layanan Kebersihan Wilayah
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F3D2E] mt-3">Jadwal Penjemputan Sampah OPBM</h1>
            <p class="text-sm text-[#5A4A3A] mt-2">Pantau jadwal rutin penjemputan sampah lingkungan oleh armada gerobak motor hijau di wilayah tempat tinggalmu.</p>
        </div>

        <!-- MENU PENCARIAN REAL-TIME DI ATAS TABEL -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl shadow-lg border border-[#5A4A3A]/15 mb-8 max-w-3xl mx-auto">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">

                <div class="relative flex-1 min-w-0">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-[#5A4A3A]/50"></i>
                    </div>

                    <input
                        type="text"
                        id="opbm-search"
                        oninput="filterJadwalOPBM()"
                        placeholder="Masukkan nama Kelurahan, Kecamatan, atau RT..."
                        class="w-full h-[50px] pl-11 pr-3 bg-[#FFFAE8]/50 border border-[#5A4A3A]/20 rounded-2xl text-sm font-medium text-[#1F3D2E] placeholder:text-xs sm:placeholder:text-sm placeholder:tracking-tight focus:outline-none focus:ring-2 focus:ring-[#6B7F4E] transition-all">
                </div>

                <button
                    type="button"
                    onclick="filterJadwalOPBM()"
                    class="w-full sm:w-auto h-[50px] bg-[#1F3D2E] hover:bg-[#4C6A73] text-white font-bold px-8 rounded-2xl shadow-md transition-colors flex items-center justify-center gap-2 shrink-0">
                    <span>Cari</span>
                </button>

            </div>
        </div>

        <!-- JADWAL PENJEMPUTAN -->
        <div class="bg-white rounded-3xl shadow-xl border border-[#5A4A3A]/15 overflow-hidden">

            <!-- TAMPILAN DESKTOP -->
            <div id="jadwal-desktop" class="hidden md:block overflow-x-auto">
                <table class="w-full table-fixed text-left border-collapse" id="tabel-jadwal">

                    <colgroup>
                        <col class="w-[25%]">
                        <col class="w-[20%]">
                        <col class="w-[25%]">
                        <col class="w-[30%]">
                    </colgroup>

                    <thead>
                        <tr class="bg-[#1F3D2E] text-white text-xs uppercase tracking-wider font-semibold text-center">
                            <th class="py-4 px-6">Kelurahan/Kecamatan</th>
                            <th class="py-4 px-6">Cakupan RT</th>
                            <th class="py-4 px-6">Hari Penjemputan</th>
                            <th class="py-4 px-6">Jam Operasional</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm font-medium text-[#5A4A3A]">

                        @forelse ($jadwals as $jadwal)
                            <tr class="jadwal-row hover:bg-[#DCC8A3]/10 transition-colors">

                                <td class="py-4 px-6">
                                    <div class="font-bold text-[#1F3D2E]">
                                        Kel. {{ $jadwal->kelurahan }}
                                    </div>
                                    <div class="text-xs text-[#5A4A3A]/70">
                                        Kec. {{ $jadwal->kecamatan }}
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <span class="bg-[#6B7F4E]/10 text-[#1F3D2E] text-xs px-2.5 py-1 rounded-md font-semibold">
                                        {{ $jadwal->cakupan_rt }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap text-center">
                                    <div class="font-bold text-[#1F3D2E]">
                                        {{ implode(', ', $jadwal->hari_penjemputan ?? []) }}
                                    </div>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap text-center">
                                    <span class="text-xs bg-amber-50 text-amber-800 border border-amber-200 px-3 py-1 rounded-lg font-bold inline-flex items-center gap-1.5">
                                        <i class="fa-regular fa-clock"></i>
                                        @if ($jadwal->jam_mulai && $jadwal->jam_selesai)
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H.i') }} WIB
                                        @else
                                            {{ $jadwal->jam_operasional ?? '-' }}
                                        @endif
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 px-6 text-center text-sm text-[#5A4A3A]/70">
                                    <p class="font-bold text-[#1F3D2E]">Belum ada jadwal penjemputan</p>
                                    <p class="text-xs mt-1">Jadwal OPBM untuk saat ini belum tersedia.</p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            
            </div>

            <!-- TAMPILAN MOBILE -->
            <div id="jadwal-mobile" class="md:hidden p-3 space-y-3">

                @forelse ($jadwals as $jadwal)
                    <div class="jadwal-row bg-white rounded-2xl shadow-sm border border-[#5A4A3A]/10 p-3"
                        data-search="{{ strtolower($jadwal->kelurahan . ' ' . $jadwal->kecamatan . ' ' . $jadwal->cakupan_rt . ' ' . implode(' ', $jadwal->hari_penjemputan ?? []) . ' ' . ($jadwal->jam_operasional ?? '') . ' ' . ($jadwal->jam_mulai ?? '') . ' ' . ($jadwal->jam_selesai ?? '')) }}">

                        <!-- KELURAHAN -->
                        <div class="border-b border-[#5A4A3A]/10 pb-2 mb-2">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6B7F4E] mb-0.5">
                                Wilayah Penjemputan
                            </p>

                            <h3 class="text-sm font-bold text-[#1F3D2E]">
                                Kel. {{ $jadwal->kelurahan }}
                            </h3>

                            <p class="text-[11px] text-[#5A4A3A]/70">
                                Kec. {{ $jadwal->kecamatan }}
                            </p>
                        </div>

                        <!-- DETAIL JADWAL -->
                        <div class="grid grid-cols-2 gap-2">

                            <div>
                                <p class="text-[10px] font-semibold text-[#6B7F4E] mb-0.5">
                                    Cakupan RT
                                </p>
                                <p class="text-xs font-semibold text-[#1F3D2E]">
                                    {{ $jadwal->cakupan_rt }}
                                </p>
                            </div>

                            <div>
                                <p class="text-[10px] font-semibold text-[#6B7F4E] mb-0.5">
                                    Hari Penjemputan
                                </p>
                                <p class="text-xs font-semibold text-[#1F3D2E]">
                                    {{ implode(', ', $jadwal->hari_penjemputan ?? []) }}
                                </p>
                            </div>

                            <div class="col-span-2">
                                <p class="text-[10px] font-semibold text-[#6B7F4E] mb-1">
                                    Jam Operasional
                                </p>

                                <span class="inline-flex items-center gap-1.5 text-[10px] bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-1 rounded-lg font-bold">
                                    <i class="fa-regular fa-clock"></i>

                                    @if ($jadwal->jam_mulai && $jadwal->jam_selesai)
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H.i') }} WIB
                                    @else
                                        {{ $jadwal->jam_operasional ?? '-' }}
                                    @endif
                                </span>
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="text-center py-8 text-xs text-[#5A4A3A]/70">
                        <p class="font-bold text-[#1F3D2E]">Belum ada jadwal penjemputan</p>
                        <p class="mt-1">Jadwal OPBM untuk saat ini belum tersedia.</p>
                    </div>
                @endforelse

            </div>

            <!-- PESAN JIKA HASIL PENCARIAN KOSONG -->
            <div id="no-jadwal-msg" class="hidden p-10 text-center text-[#5A4A3A]/70 text-sm">
                <i class="fa-solid fa-circle-exclamation text-3xl mb-3 text-[#4C6A73]"></i>
                <p class="font-bold text-[#1F3D2E]">Wilayah tidak ditemukan</p>
                <p class="text-xs mt-1">Pastikan penulisan nama kelurahan, kecamatan, atau RT sudah benar.</p>
            </div>
        </div>

    </main>

    <!-- ==========================================
         FOOTER UTAMA
         ========================================== -->
    <footer class="bg-[#1F3D2E] text-white border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Branding Left -->
                <div class="flex items-center gap-1">
                    <img
                        src="{{ asset('images/logo-jambibersih.png') }}"
                        alt="Logo JambiBersih"
                        class="w-14 h-14 object-contain mt-1"
                    >

                    <div>
                        <span class="font-bold text-base text-white">Sistem Pelaporan TPS Liar</span>
                        <p class="text-xs text-[#DCC8A3]">
                            Layanan Resmi Pengaduan & Informasi Kebersihan Lingkungan
                        </p>
                    </div>
                </div>

                <!-- Footer Quick Links -->
                <div class="flex flex-wrap justify-center gap-6 text-xs text-emerald-200 font-medium">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
                    <a href="{{ url('/lapor') }}" class="hover:text-white transition-colors">Lapor TPS</a>
                    <a href="{{ url('/lacak') }}" class="hover:text-white transition-colors">Cek Penanganan TPS</a>
                    <a href="{{ url('/jadwal') }}" class="hover:text-white transition-colors">Jadwal OPBM</a>
                    <a href="{{ url('/transparansi') }}" class="hover:text-white transition-colors">Transparansi Dana</a>
                    <a href="{{ url('/edukasi') }}" class="hover:text-white transition-colors">Edukasi & Media</a>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-white/10 text-center md:flex md:justify-between md:items-center text-xs text-emerald-200/70 space-y-2 md:space-y-0">
                <p>&copy; 2026 Dinas Lingkungan Hidup. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="text-[#DCC8A3]">Menuju Kota Bersih, Asri, dan Berkelanjutan</p>
            </div>
        </div>
    </footer>

    <!-- ==========================================
         SCRIPT FILTER PENCARIAN REAL-TIME & MENU
         ========================================== -->
    <script>
        function filterJadwalOPBM() {
            const input = document.getElementById('opbm-search').value.toLowerCase().trim();

            const rows = document.querySelectorAll('.jadwal-row');
            const desktop = document.getElementById('jadwal-desktop');
            const mobile = document.getElementById('jadwal-mobile');
            const noMsg = document.getElementById('no-jadwal-msg');

            let found = false;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();

                if (text.includes(input)) {
                    row.style.display = '';
                    found = true;
                } else {
                    row.style.display = 'none';
                }
            });

            if (!found) {
                desktop.style.display = 'none';
                mobile.style.display = 'none';
                noMsg.classList.remove('hidden');
            } else {
                // Kembalikan pengaturan tampilan responsif Tailwind
                desktop.style.display = '';
                mobile.style.display = '';
                noMsg.classList.add('hidden');
            }
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('hamburger-icon');
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            }
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }
    </script>

    <!-- PWA Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then((registration) => {
                        console.log('JambiBersih Service Worker aktif:', registration.scope);
                    })
                    .catch((error) => {
                        console.error('Service Worker gagal:', error);
                    });
            });
        }
    </script>
</body>
</html>