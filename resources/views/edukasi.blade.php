<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi & Media - JambiBersih</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-angsa.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Inter & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Style kustom scrollbar halus untuk video horizontal */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#DCC8A3]/30 text-[#5A4A3A] antialiased min-h-screen flex flex-col">

    <!-- NAVBAR UTAMA GLOBAL -->
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
                            <a href="{{ url('/jadwal') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#6B7F4E]/10 flex items-center justify-center text-[#6B7F4E]">
                                    <i class="fa-solid fa-calendar-alt text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Jadwal OPBM</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Operasi Pembersihan Bersama</div>
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
                            <a href="{{ url('/edukasi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold bg-[#DCC8A3]/30 text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#1F3D2E] text-white flex items-center justify-center">
                                    <i class="fa-solid fa-book-open text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-bold">Edukasi & Media</div>
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

                <!-- Jadwal OPBM (Tidak Aktif) -->
                <a href="{{ url('/jadwal') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-calendar-alt text-xs"></i>
                    <span>Jadwal OPBM</span>
                </a>

                <!-- Transparansi (Tidak Aktif) -->
                <a href="{{ url('/transparansi') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-chart-pie text-xs"></i>
                    <span>Transparansi Dana</span>
                </a>

                <!-- Edukasi (Aktif) -->
                <a href="{{ url('/edukasi') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-white bg-white/10 rounded-lg">
                    <i class="fa-solid fa-book-open text-xs text-[#DCC8A3]"></i>
                    <span>Edukasi & Media</span>
                </a>
            </div>
        </div>

        
    </header>

    <!-- MAIN CONTENT HALAMAN EDUKASI -->
    <main
        id="edukasi-page"
        class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto w-full space-y-8"
    >
        
        <!-- HEADER HALAMAN -->
        <div class="text-center max-w-2xl mx-auto">
            <span class="bg-[#1F3D2E]/10 text-[#1F3D2E] text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5">
                <i class="fa-solid fa-graduation-cap text-[#6B7F4E]"></i> Pusat Literasi Lingkungan
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F3D2E] mt-3">Edukasi & Media Kebersihan</h1>
            <p class="text-sm text-[#5A4A3A] mt-2">Tingkatkan kepedulian lingkungan melalui video edukatif interaktif dan artikel panduan pemilahan sampah di Kota Jambi.</p>
        </div>

        @php
            $kategoriEdukasi = [
                'Lingkungan Hidup & Pengelolaan Sampah',
                'Kesehatan & Sanitasi',
                'Kebijakan & Layanan Publik',
                'Aksi Sosial & Komunitas',
                'Tips & Gaya Hidup',
            ];
        @endphp

        <!-- PENCARIAN DAN FILTER -->
        <div class="flex flex-col sm:flex-row items-center justify-end gap-2.5">

            <!-- Pencarian -->
            <div class="relative flex-1 w-full sm:max-w-sm">
                <div class="flex items-center bg-white border border-[#5A4A3A]/20 rounded-xl px-4 focus-within:ring-2 focus-within:ring-[#6B7F4E]/30 focus-within:border-[#6B7F4E] transition-all">

                    <i class="fa-solid fa-magnifying-glass text-[#5A4A3A]/50 text-sm shrink-0"></i>

                    <input
                        id="edukasi-search"
                        type="text"
                        placeholder="Cari judul, artikel, atau video..."
                        class="w-full min-w-0 px-4 py-3 bg-transparent text-sm text-[#5A4A3A] placeholder:text-[#5A4A3A]/50 focus:outline-none"
                    >

                    <button
                        id="clear-search"
                        type="button"
                        class="hidden text-[#5A4A3A]/50 hover:text-[#1F3D2E] shrink-0 cursor-pointer"
                        title="Hapus pencarian"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                </div>
            </div>

            <!-- Dropdown Filter -->
            <div class="relative w-full sm:w-auto" id="filter-wrapper">

                <button
                    id="filter-toggle"
                    type="button"
                    class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-[#6B7F4E] bg-white text-[#1F3D2E] text-sm font-semibold hover:bg-[#1F3D2E]/5 transition"
                >
                    <i class="fa-solid fa-sliders"></i>
                    Filter
                    <i class="fa-solid fa-chevron-down text-xs transition-transform" id="filter-chevron"></i>
                </button>

                <div
                    id="filter-panel"
                    class="hidden absolute right-0 top-full mt-2 w-72 max-w-[calc(100vw-2rem)] bg-white rounded-xl shadow-xl border border-[#5A4A3A]/10 p-4 z-50"
                >
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-bold text-sm text-[#1F3D2E]">Filter Konten</h3>
                        <button id="filter-close" type="button" class="text-[#5A4A3A]/50 hover:text-[#1F3D2E]">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Jenis -->
                    <div class="mb-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#5A4A3A]/60 mb-2">
                            Jenis Konten
                        </p>

                        <div class="space-y-1" id="type-options">
                            <button type="button" data-type="semua" class="filter-option active">Semua Konten</button>
                            <button type="button" data-type="artikel" class="filter-option">Artikel</button>
                            <button type="button" data-type="video" class="filter-option">Video</button>
                        </div>
                    </div>

                    <div class="border-t border-[#5A4A3A]/10 my-3"></div>

                    <!-- Kategori -->
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#5A4A3A]/60 mb-2">
                            Kategori
                        </p>

                        <div class="space-y-1 max-h-48 overflow-y-auto" id="category-options">
                            <button type="button" data-category="semua" class="filter-option active">
                                Semua Kategori
                            </button>

                            @foreach ($kategoriEdukasi as $kategori)
                                <button
                                    type="button"
                                    data-category="{{ $kategori }}"
                                    class="filter-option"
                                >
                                    {{ $kategori }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="border-t border-[#5A4A3A]/10 mt-4 pt-3">
                        <button
                            id="reset-filter"
                            type="button"
                            class="w-full py-2 rounded-lg border border-[#5A4A3A]/20 text-sm font-semibold text-[#1F3D2E] hover:bg-[#DCC8A3]/30 transition"
                        >
                            <i class="fa-solid fa-rotate-left mr-1"></i>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .filter-option {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 9px 11px;
                border-radius: 8px;
                text-align: left;
                font-size: 13px;
                color: #5A4A3A;
                transition: background .2s;
            }

            .filter-option:hover {
                background: rgba(220, 200, 163, .3);
            }

            .filter-option.active {
                background: rgba(31, 61, 46, .09);
                color: #1F3D2E;
                font-weight: 600;
            }

            .filter-option.active::after {
                content: '\f00c';
                font-family: 'Font Awesome 6 Free';
                font-weight: 900;
                color: #6B7F4E;
                font-size: 11px;
            }
        </style>

        <!-- ==========================================
             SECTION 1: VIDEO EDUKASI (SCROLL KESAMPING)
             ========================================== -->
        <section id="video-section" class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-extrabold text-[#1F3D2E] flex items-center gap-2">
                        <i class="fa-solid fa-circle-play text-[#6B7F4E]"></i> Video Pembelajaran
                    </h2>
                    <p class="text-xs text-[#5A4A3A]/80 mt-0.5">Geser ke samping untuk melihat koleksi video edukasi</p>
                </div>
                <!-- Navigasi Tombol Geser -->
                <div class="flex items-center gap-2">
                    <button onclick="scrollVideo('left')" class="w-9 h-9 rounded-full bg-white border border-[#5A4A3A]/20 text-[#1F3D2E] hover:bg-[#1F3D2E] hover:text-white transition-all flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button onclick="scrollVideo('right')" class="w-9 h-9 rounded-full bg-white border border-[#5A4A3A]/20 text-[#1F3D2E] hover:bg-[#1F3D2E] hover:text-white transition-all flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>


            <!-- CONTAINER SCROLL HORIZONTAL -->
            <div id="video-container" class="flex gap-5 overflow-x-auto pb-4 scroll-smooth no-scrollbar snap-x snap-mandatory">

                @forelse ($videos as $video)
                    <div
                        data-filter-card
                        data-type="video"
                        data-category="{{ $video->kategori }}"
                        data-search="{{ $video->judul }} {{ $video->ringkasan }} {{ $video->kategori }}"
                        class="min-w-[280px] sm:min-w-[320px] max-w-[320px] bg-white rounded-3xl border border-[#5A4A3A]/15 shadow-md overflow-hidden snap-start shrink-0 group"
                    >

                        <div class="relative overflow-hidden aspect-video bg-black/80 group">
                            <a href="{{ route('edukasi.show', $video->slug) }}"
                                class="block relative overflow-hidden aspect-video">

                                <img
                                    src="{{ $video->thumbnail_url }}"
                                    alt="{{ $video->judul }}"
                                    class="w-full h-full object-cover"
                                >

                                @if ($video->durasi)
                                    <span class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-2 py-0.5 rounded">
                                        {{ $video->durasi }}
                                    </span>
                                @endif

                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                        <i class="fa-solid fa-play ml-1"></i>
                                    </div>
                                </div>

                            </a>
                        </div>

                        <div class="p-5">
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2.5 py-0.5 rounded-md">
                                {{ $video->kategori }}
                            </span>

                            <h3 class="text-sm font-bold text-[#1F3D2E] mt-2 line-clamp-2">
                                {{ $video->judul }}
                            </h3>

                            <p class="text-xs text-[#5A4A3A]/80 mt-1 line-clamp-2">
                                {{ $video->ringkasan }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-10 text-sm text-[#5A4A3A]/70">
                        Belum ada video edukasi yang tersedia.
                    </div>
                @endforelse

            </div>
            </section>

        <!-- ==========================================
             SECTION 2: ARTIKEL EDUKASI (SCROLL KEBAWAH)
             ========================================== -->
        <section id="article-section" class="space-y-6 pt-6 border-t border-[#5A4A3A]/10">
            <div>
                <h2 class="text-xl font-extrabold text-[#1F3D2E] flex items-center gap-2">
                    <i class="fa-solid fa-newspaper text-[#4C6A73]"></i> Artikel & Panduan Lingkungan
                </h2>
                <p class="text-xs text-[#5A4A3A]/80 mt-0.5">Baca artikel informatif untuk menerapkan gaya hidup bersih dan bebas sampah liar</p>
            </div>

            <!-- LIST ARTIKEL VERTIKAL -->
            <div class="space-y-4">

                @forelse ($artikels as $artikel)
                    <article
                        data-filter-card
                        data-type="artikel"
                        data-category="{{ $artikel->kategori }}"
                        data-search="{{ $artikel->judul }} {{ $artikel->ringkasan }} {{ $artikel->kategori }}"
                        class="bg-white rounded-3xl p-5 sm:p-6 border border-[#5A4A3A]/15 shadow-md hover:shadow-lg transition-all flex flex-col sm:flex-row gap-5 items-start"
                    >

                        <img
                            src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=400&auto=format&fit=crop&q=80' }}"
                            alt="{{ $artikel->judul }}"
                            class="w-full sm:w-48 h-36 object-cover rounded-2xl shrink-0"
                        >

                        <div class="flex-grow space-y-2">

                            <div class="flex items-center gap-3 text-xs text-[#5A4A3A]/70">
                                <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2.5 py-0.5 rounded-md">
                                    {{ $artikel->kategori }}
                                </span>

                            <span class="text-xs text-[#5A4A3A]/70">
                                <i class="fa-regular fa-calendar mr-1"></i>
                                {{ ($artikel->published_at ?? $artikel->created_at)->translatedFormat('d F Y, H:i') }}
                            </span>
                            </div>

                            <h3 class="text-base sm:text-lg font-bold text-[#1F3D2E] hover:text-[#4C6A73] transition-colors">
                                {{ $artikel->judul }}
                            </h3>

                            <p class="text-xs sm:text-sm text-[#5A4A3A] line-clamp-2">
                                {{ $artikel->ringkasan }}
                            </p>

                            <a href="{{ route('edukasi.show', $artikel->slug) }}"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1F3D2E] hover:text-[#6B7F4E] pt-1">
                                <span>Baca Selengkapnya</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>

                        </div>
                    </article>
                @empty
                    <div class="text-center py-10 text-sm text-[#5A4A3A]/70">
                        Belum ada artikel edukasi yang tersedia.
                    </div>
                @endforelse

            </div>
            </section>

    </main>

    <!-- FOOTER GLOBAL -->
    <footer class="bg-[#1F3D2E] text-white border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Branding Left -->
                <div class="flex items-center gap-1">
                    <img
                        src="{{ asset('images/logo-jambibersih.png') }}"
                        alt="Logo JambiBersih"
                        class="w-14 h-14 object-contain"
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

    <!-- SCRIPT KONTROL SCROLL HORIZONTAL & MENU -->
    <script>
        function scrollVideo(direction) {
            const container = document.getElementById('video-container');
            const scrollAmount = 340; // Jarak geser satu kartu video
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
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

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('edukasi-search');
        const clearButton = document.getElementById('clear-search');
        const filterToggle = document.getElementById('filter-toggle');
        const filterPanel = document.getElementById('filter-panel');
        const filterChevron = document.getElementById('filter-chevron');
        const filterClose = document.getElementById('filter-close');
        const resetButton = document.getElementById('reset-filter');

        const cards = document.querySelectorAll('[data-filter-card]');
        const typeButtons = document.querySelectorAll('#type-options [data-type]');
        const categoryButtons = document.querySelectorAll('#category-options [data-category]');

        let selectedType = 'semua';
        let selectedCategory = 'semua';

        function updateFilter() {
            const keyword = searchInput.value.toLowerCase().trim();

            let visibleVideo = 0;
            let visibleArticle = 0;

            cards.forEach(card => {
                const content = (card.dataset.search || '').toLowerCase();
                const type = card.dataset.type;
                const category = card.dataset.category;

                const matchSearch = !keyword || content.includes(keyword);
                const matchType = selectedType === 'semua' || selectedType === type;
                const matchCategory = selectedCategory === 'semua' || selectedCategory === category;

                const visible = matchSearch && matchType && matchCategory;

                card.hidden = !visible;

                if (visible && type === 'video') visibleVideo++;
                if (visible && type === 'artikel') visibleArticle++;
            });

            // Tampilkan atau sembunyikan section video
            document.getElementById('video-section').hidden = visibleVideo === 0;

            // Tampilkan atau sembunyikan section artikel
            document.getElementById('article-section').hidden = visibleArticle === 0;

            // Tampilkan tombol X jika kolom pencarian terisi
            clearButton.classList.toggle('hidden', keyword.length === 0);

            // Pesan ketika tidak ada hasil
            const noResults = document.getElementById('no-filter-results');

            if (noResults) {
                noResults.classList.toggle(
                    'hidden',
                    visibleVideo + visibleArticle > 0
                );
            }
        }

        function updateActiveButtons(buttons, attribute, value) {
            buttons.forEach(button => {
                button.classList.toggle('active', button.dataset[attribute] === value);
            });
        }

        searchInput.addEventListener('input', updateFilter);

        clearButton.addEventListener('click', function () {
            searchInput.value = '';
            updateFilter();
            searchInput.focus();
        });

        filterToggle.addEventListener('click', () => {
            filterPanel.classList.toggle('hidden');
            filterChevron.classList.toggle('rotate-180');
        });

        filterClose.addEventListener('click', () => {
            filterPanel.classList.add('hidden');
            filterChevron.classList.remove('rotate-180');
        });

        document.addEventListener('click', event => {
            if (!document.getElementById('filter-wrapper').contains(event.target)) {
                filterPanel.classList.add('hidden');
                filterChevron.classList.remove('rotate-180');
            }
        });

        typeButtons.forEach(button => {
            button.addEventListener('click', () => {
                selectedType = button.dataset.type;
                updateActiveButtons(typeButtons, 'type', selectedType);
                updateFilter();
            });
        });

        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                selectedCategory = button.dataset.category;
                updateActiveButtons(categoryButtons, 'category', selectedCategory);
                updateFilter();
            });
        });

        resetButton.addEventListener('click', () => {
            searchInput.value = '';
            selectedType = 'semua';
            selectedCategory = 'semua';

            updateActiveButtons(typeButtons, 'type', selectedType);
            updateActiveButtons(categoryButtons, 'category', selectedCategory);

            updateFilter();
        });

        clearButton.classList.toggle(
            'hidden',
            searchInput.value.trim().length === 0
        );
        
        updateFilter();
    });
    </script>
</body>
</html>