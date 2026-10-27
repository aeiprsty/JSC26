<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pelaporan TPS Liar & Kebersihan Lingkungan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #DCC8A3;
        }
        ::-webkit-scrollbar-thumb {
            background: #6B7F4E;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #1F3D2E;
        }
    </style>

    <!-- CDN FontAwesome (Memastikan Ikon Muncul) -->
    <style>
        .truck-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 25;
        }

        /* Tanpa lingkaran putih, murni gambar truk yang berjalan */
        .truck-moving {
            position: absolute;
            top: 0;
            left: 0;
            width: 200px; /* Sesuaikan ukuran truk */
            height: auto;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3)); /* Efek bayangan tipis agar terlihat hidup */
            offset-path: path('M 50 100 C 200 100, 250 280, 400 280 C 550 280, 600 70, 750 70 C 900 70, 950 280, 1150 280');
            animation: jalanJalur 12s infinite linear;
        }

        @keyframes jalanJalur {
            0% { offset-distance: 0%; }
            100% { offset-distance: 100%; }
        }
    </style>

</head>
<body class="bg-[#DCC8A3] text-[#5A4A3A] antialiased selection:bg-[#6B7F4E] selection:text-white overflow-x-hidden min-h-screen flex flex-col">

    <!-- ==========================================
         NAVBAR / HEADER UTAMA
         ========================================== -->
    <header class="sticky top-0 z-50 bg-[#1F3D2E] text-white shadow-md transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Branding -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-[#6B7F4E] flex items-center justify-center text-white shadow-lg group-hover:bg-[#4C6A73] transition-colors duration-200">
                        <i class="fa-solid font-bold fa-leaf text-xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-lg tracking-tight leading-none text-white group-hover:text-[#DCC8A3] transition-colors">SIPAS</span>
                        <span class="text-[10px] text-[#DCC8A3] font-medium tracking-wider uppercase">Dinas Lingkungan Hidup Kota Jambi</span>
                    </div>
                </a>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex items-center gap-8 ml-auto">
                    <a href="#" class="px-3 py-2 rounded-lg text-sm font-semibold text-white bg-white/10 transition-colors">
                        Beranda
                    </a>
                    
                    <a href="{{ route('lapor.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors">
                        Lapor TPS
                    </a>

                    <a href="{{ route('lacak.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors">
                        Cek Penanganan TPS
                    </a>

                    <!-- Dropdown Informasi & Edukasi -->
                    <div class="relative group" id="desktop-dropdown">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors focus:outline-none" onclick="toggleDropdown('desktop-menu')">
                            <span>Informasi & Edukasi</span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                        </button>
                        
                        <!-- Submenu Dropdown -->
                        <div id="desktop-menu" class="hidden group-hover:block absolute right-0 mt-1 w-64 bg-white rounded-xl shadow-xl border border-[#5A4A3A]/10 py-2 text-[#5A4A3A] z-50 animate-fadeIn">
                            <a href="{{ route('jadwal.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#6B7F4E]/10 flex items-center justify-center text-[#6B7F4E]">
                                    <i class="fa-solid fa-calendar-alt text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Jadwal OPBM</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Operasi Pembersihan Bersama</div>
                                </div>
                            </a>
                            <a href="{{ route('transparansi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#4C6A73]/10 flex items-center justify-center text-[#4C6A73]">
                                    <i class="fa-solid fa-chart-pie text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Transparansi Dana</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Rincian Komponen Alokasi</div>
                                </div>
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('edukasi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#1F3D2E]/10 flex items-center justify-center text-[#1F3D2E]">
                                    <i class="fa-solid fa-book-open text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Edukasi & Media</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Artikel, Tip & Video Pembelajaran</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </nav>

                <!-- Mobile Hamburger Button -->
                <div class="md:hidden flex items-center">
                    <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-lg text-emerald-100 hover:text-white hover:bg-white/10 focus:outline-none" aria-label="Buka Menu Navigasi">
                        <i id="hamburger-icon" class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Navigation Panel -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#1F3D2E] border-t border-white/10 px-4 pt-3 pb-6 space-y-2">
            <a href="#" class="block px-3 py-2 rounded-lg text-base font-semibold text-white bg-white/10">
                Beranda
            </a>
            <a href="#lapor" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Lapor TPS
            </a>
            <a href="#lacak" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Cek Penanganan TPS
            </a>
            
            <!-- Mobile Submenu Accordion -->
            <div class="pt-2 border-t border-white/10">
                <div class="px-3 py-1 text-xs font-semibold text-[#DCC8A3] uppercase tracking-wider">Informasi & Edukasi</div>
                <a href="#jadwal-opbm" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-calendar-alt text-[#6B7F4E]"></i>
                    <span>Jadwal OPBM</span>
                </a>
                <a href="#transparansi" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-chart-pie text-[#4C6A73]"></i>
                    <span>Transparansi Alokasi Dana</span>
                </a>
                <a href="#edukasi" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-book-open text-[#DCC8A3]"></i>
                    <span>Edukasi</span>
                </a>
            </div>

            <div class="pt-4">
                <a href="#lapor-form" class="w-full bg-[#6B7F4E] hover:bg-[#4C6A73] text-white font-bold text-center py-3 rounded-xl shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Lapor TPS Liar Sekarang</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        
        <!-- ==========================================
             HERO SECTION
             ========================================== -->
        <!-- HERO SECTION (BACKGROUND FADE & KONTEN KIRI) -->
        <section class="relative bg-[#1F3D2E] text-white overflow-hidden py-20 lg:py-28 min-h-[500px] flex items-center">
            
            <!-- 1. GAMBAR BACKGROUND DENGAN OVERLAY GRADIENT -->
            <div class="absolute inset-0 z-0">
                <!-- Gambar Lingkungan/Armada di Sebelah Kanan -->
                <img src="{{ asset('images/hero-lingkungan.jpeg') }}" 
                    alt="Lingkungan Bersih Kota Jambi" 
                    class="w-full h-full object-cover object-right">
                
                <!-- Gradient Overlay: Gelap/Penuh di Kiri, Transparan ke Kanan -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#1F3D2E] via-[#1F3D2E]/90 sm:via-[#1F3D2E]/80 to-transparent"></div>
            </div>

            <!-- 2. KONTEN UTAMA (DI ATAS OVERLAY) -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="max-w-xl space-y-6">
                    
                    <span class="inline-flex items-center gap-2 bg-[#6B7F4E]/30 text-[#DCC8A3] border border-[#6B7F4E]/50 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm">
                        <i class="fa-solid fa-leaf text-[#6B7F4E]"></i>
                        <span>Sistem Pelaporan TPS Liar</span>
                    </span>

                    <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight tracking-tight">
                        Jaga Lingkungan Bersih 
                        <span class="text-[#DCC8A3] underline decoration-[#6B7F4E] decoration-4 underline-offset-8">Bebas Sampah</span>
                    </h1>

                    <p class="text-sm sm:text-base text-emerald-100/90 leading-relaxed">
                        Wujudkan lingkungan pemukiman yang sehat. Laporkan titik sampah liar di sekitar wilayah kamu dan pantau penanganannya secara langsung oleh tim penanganan.
                    </p>

                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="{{ route('lapor.index') }}" class="bg-[#6B7F4E] hover:scale-105 transition-all text-white font-bold px-6 py-3.5 rounded-xl shadow-lg transition-all flex items-center gap-2 text-sm">
                            <i class="fa-solid fa-bullhorn"></i>
                            <span>Lapor TPS Liar Sekarang</span>
                        </a>

                        <a href="#lacak" class="bg-white/10 hover:bg-white/20 text-white font-bold px-6 py-3.5 rounded-xl border border-white/20 backdrop-blur-md transition-all text-sm">
                            <span>Lacak Laporan</span>
                        </a>
                    </div>

                </div>
            </div>

        </section>

        <!-- ==========================================
             SECTION: 3 LANGKAH MUDAH LAPOR
             ========================================== -->

        <!-- SECTION ALUR JALAN BERGELOMBANG (ROADMAP PROCESS) -->
        <section class="py-20 bg-[#FFFAE8] relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Judul Section -->
                <div class="text-center max-w-2xl mx-auto mb-1 space-y-2">
                    <span class="text-[#6B7F4E] font-bold text-xs uppercase tracking-widest bg-[#6B7F4E]/10 px-3.5 py-1.5 rounded-full">
                        Alur Operasional
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#1F3D2E]">
                        Proses Penanganan TPS Liar
                    </h2>
                    <p class="text-sm text-[#5A4A3A]">
                        Perjalanan laporan warga dari pengaduan awal hingga penanganan bersih di lapangan.
                    </p>
                </div>

                <!-- CONTAINER JALAN SVG & TITIK ALUR -->
                <div class="relative w-full aspect-[12/4] min-h-[450px] md:min-h-[380px]">

                    <!-- 1. SVG JALAN RAYA BERGELOMBANG -->
                    <div class="absolute inset-0 w-full h-full pointer-events-none hidden md:block z-0">
                        <svg viewBox="0 0 1200 350" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <!-- Aspal Jalan -->
                            <path d="M 50 100 C 200 100, 250 280, 400 280 C 550 280, 600 70, 750 70 C 900 70, 950 280, 1150 280" 
                                stroke="#94A3B8" stroke-width="44" stroke-linecap="round"/>
                            
                            <!-- Markah Putus-Putus -->
                            <path d="M 50 100 C 200 100, 250 280, 400 280 C 550 280, 600 70, 750 70 C 900 70, 950 280, 1150 280" 
                                stroke="#FFFFFF" stroke-width="4" stroke-dasharray="14 14" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <!-- 2. ANIMASI MOBIL SAMPAH BERJALAN -->
                    <div class="truck-container hidden md:block">
                        <img src="{{ asset('images/truk-hijau.png') }}" 
                            alt="Truk Sampah Berjalan" 
                            class="truck-moving object-contain">
                    </div>

                    <!-- 3. TITIK-TITIK ALUR (DESKTOP ABSOLUTE POSITIONING) -->
                    <div class="hidden md:block absolute inset-0 z-20">
                        
                        <!-- Titik 1: Foto & Lokasi (Teks di Atas Jalan) -->
                        <div class="absolute" style="left: 6%; top: 45%;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#1F3D2E] text-white flex items-center justify-center text-2xl shadow-xl border-4 border-white z-10">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <!-- Box Teks di Atas Lingkaran -->
                                <div class="absolute top-[115%] w-52 text-center bg-white/90 backdrop-blur-sm p-3 rounded-2xl border border-slate-200 shadow-md">
                                    <h3 class="font-bold text-[#1F3D2E] text-sm">1. Foto & Lokasi</h3>
                                    <p class="text-[11px] text-[#5A4A3A] mt-0.5 leading-snug">Warga mengambil foto tumpukan sampah & patokan titik lokasi.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Titik 2: Terbit Kode Tiket (Teks di Bawah Jalan) -->
                        <div class="absolute" style="left: 31%; top: 45%;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#4C6A73] text-white flex items-center justify-center text-2xl shadow-xl border-4 border-white z-10">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>
                                <!-- Box Teks di Bawah Lingkaran -->
                                <div class="absolute bottom-[115%] w-52 text-center bg-white/90 backdrop-blur-sm p-3 rounded-2xl border border-slate-200 shadow-md">
                                    <h3 class="font-bold text-[#1F3D2E] text-sm">2. Terbit Kode Tiket</h3>
                                    <p class="text-[11px] text-[#5A4A3A] mt-0.5 leading-snug">Sistem memberikan kode lacak unik untuk memantau status.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Titik 3: Pembersihan OPBM (Teks di Atas Jalan) -->
                        <div class="absolute" style="left: 60%; top: 45%;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#6B7F4E] text-white flex items-center justify-center text-2xl shadow-xl border-4 border-white z-10">
                                    <i class="fa-solid fa-people-carry-box"></i>
                                </div>
                                <!-- Box Teks di Atas Lingkaran -->
                                <div class="absolute top-[115%] w-52 text-center bg-white/90 backdrop-blur-sm p-3 rounded-2xl border border-slate-200 shadow-md">
                                    <h3 class="font-bold text-[#1F3D2E] text-sm">3. Pembersihan OPBM</h3>
                                    <p class="text-[11px] text-[#5A4A3A] mt-0.5 leading-snug">Armada bentor/truk dan tim bergerak membersihkan lokasi.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Titik 4: Wilayah Bersih (Teks di Bawah Jalan) -->
                        <div class="absolute" style="left: 88%; top: 45%;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#5A4A3A] text-white flex items-center justify-center text-2xl shadow-xl border-4 border-white z-10">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <!-- Box Teks di Bawah Lingkaran -->
                                <div class="absolute bottom-[115%] w-52 text-center bg-white/90 backdrop-blur-sm p-3 rounded-2xl border border-slate-200 shadow-md">
                                    <h3 class="font-bold text-[#1F3D2E] text-sm">4. Wilayah Bersih</h3>
                                    <p class="text-[11px] text-[#5A4A3A] mt-0.5 leading-snug">Lokasi bersih kembali dan status laporan diperbarui jadi Selesai.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- TAMPILAN RESPONSIVENESS KHUSUS MOBILE (HP) -->
                    <div class="grid grid-cols-1 gap-6 md:hidden relative z-20">
                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-[#1F3D2E] text-white flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">1. Foto & Lokasi</h3>
                                <p class="text-xs text-[#5A4A3A]">Warga mengambil foto tumpukan sampah & patokan titik lokasi.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-[#4C6A73] text-white flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">2. Terbit Kode Tiket</h3>
                                <p class="text-xs text-[#5A4A3A]">Sistem memberikan kode lacak unik untuk memantau status.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-[#6B7F4E] text-white flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-people-carry-box"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">3. Pembersihan OPBM</h3>
                                <p class="text-xs text-[#5A4A3A]">Armada bentor/truk dan tim bergerak membersihkan lokasi.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-[#5A4A3A] text-white flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">4. Wilayah Bersih</h3>
                                <p class="text-xs text-[#5A4A3A]">Lokasi bersih kembali dan status laporan diperbarui jadi Selesai.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- ==========================================
             SECTION: PREVIEW JADWAL OPBM TERDEKAT
             ========================================== -->
        <section id="jadwal-opbm" class="py-16 bg-[#1F3D2E]/5 border-y border-[#5A4A3A]/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                    <div>
                        <div class="flex items-center gap-2 text-[#6B7F4E] font-bold text-xs uppercase tracking-wider mb-1">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Kegiatan Gotong Royong</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-[#1F3D2E]">Jadwal OPBM Terdekat</h3>
                        <p class="text-sm text-[#5A4A3A] mt-1">Operasi Pembersihan Bersama Masyarakat di wilayah kecamatan minggu ini.</p>
                    </div>

                    <a href="#jadwal-lengkap" class="inline-flex items-center gap-2 text-[#1F3D2E] hover:text-[#4C6A73] font-bold text-sm bg-white border border-[#5A4A3A]/20 hover:border-[#4C6A73] px-5 py-2.5 rounded-xl transition-all shadow-sm self-start md:self-auto">
                        <span>Lihat Jadwal Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- 3 Card Grid OPBM -->
                <div class="grid md:grid-cols-3 gap-6">
                    
                    <!-- OPBM Card 1 -->
                    <div class="bg-white rounded-2xl p-6 border border-[#5A4A3A]/15 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-[#6B7F4E]/15 text-[#6B7F4E] font-bold text-xs px-3 py-1 rounded-full uppercase">
                                    Kec. Sukajadi
                                </span>
                                <span class="text-xs text-[#5A4A3A]/70 font-medium">Sabtu Ini</span>
                            </div>
                            <h4 class="text-lg font-bold text-[#1F3D2E] mb-3">OPBM Titik Rawan Sungai Kelurahan Dahlan</h4>
                            <div class="space-y-2 text-xs text-[#5A4A3A] mb-6">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-[#4C6A73] w-4"></i>
                                    <span>07.00 - 10.30 WIB</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-[#4C6A73] w-4"></i>
                                    <span>Bantaran Sungai Melati RW 04</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-users text-[#4C6A73] w-4"></i>
                                    <span>Target: 50 Relawan & Petugas</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-[#5A4A3A]/80 font-medium">Status: Open Relawan</span>
                            <span class="text-[#6B7F4E] font-bold">Terjadwal &rarr;</span>
                        </div>
                    </div>

                    <!-- OPBM Card 2 -->
                    <div class="bg-white rounded-2xl p-6 border border-[#5A4A3A]/15 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-[#4C6A73]/15 text-[#4C6A73] font-bold text-xs px-3 py-1 rounded-full uppercase">
                                    Kec. Senapelan
                                </span>
                                <span class="text-xs text-[#5A4A3A]/70 font-medium">Minggu Ini</span>
                            </div>
                            <h4 class="text-lg font-bold text-[#1F3D2E] mb-3">Pembersihan TPS Liar Lahan Kosong</h4>
                            <div class="space-y-2 text-xs text-[#5A4A3A] mb-6">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-[#4C6A73] w-4"></i>
                                    <span>06.30 - 09.30 WIB</span>
                                </div>
                                <div class="flex items-center gap-[#4C6A73] gap-2">
                                    <i class="fa-solid fa-location-dot text-[#4C6A73] w-4"></i>
                                    <span>Area Pasar Minggu Lama</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-users text-[#4C6A73] w-4"></i>
                                    <span>Armada: 2 Alat Berat & Truk</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-[#5A4A3A]/80 font-medium">Status: Persiapan Peralatan</span>
                            <span class="text-[#6B7F4E] font-bold">Terjadwal &rarr;</span>
                        </div>
                    </div>

                    <!-- OPBM Card 3 -->
                    <div class="bg-white rounded-2xl p-6 border border-[#5A4A3A]/15 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-[#5A4A3A]/15 text-[#5A4A3A] font-bold text-xs px-3 py-1 rounded-full uppercase">
                                    Kec. Tampan
                                </span>
                                <span class="text-xs text-[#5A4A3A]/70 font-medium">Pekan Depan</span>
                            </div>
                            <h4 class="text-lg font-bold text-[#1F3D2E] mb-3">Aksi Bersih Kanal & Penghijauan Pohon</h4>
                            <div class="space-y-2 text-xs text-[#5A4A3A] mb-6">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-[#4C6A73] w-4"></i>
                                    <span>07.30 - 11.00 WIB</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-[#4C6A73] w-4"></i>
                                    <span>Kanal Utama Perumahan Asri</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-users text-[#4C6A73] w-4"></i>
                                    <span>Target: Warga RT 01-05</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-[#5A4A3A]/80 font-medium">Status: Koordinasi RT</span>
                            <span class="text-[#6B7F4E] font-bold">Terjadwal &rarr;</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ==========================================
             SECTION: PREVIEW EDUKASI (ARTIKEL & VIDEO)
             ========================================== -->
        <section id="edukasi" class="py-16 bg-[#FFFAE8] max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <div class="flex items-center gap-2 text-[#4C6A73] font-bold text-xs uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Pusat Pengetahuan</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-[#1F3D2E]">Edukasi Kebersihan & Sampah</h3>
                    <p class="text-sm text-[#5A4A3A] mt-1">Artikel ringkas dan video panduan pengelolaan sampah mandiri dari rumah.</p>
                </div>

                <a href="#edukasi-lainnya" class="inline-flex items-center gap-2 text-[#1F3D2E] hover:text-[#4C6A73] font-bold text-sm bg-white border border-[#5A4A3A]/20 hover:border-[#4C6A73] px-5 py-2.5 rounded-xl transition-all shadow-sm self-start md:self-auto">
                    <span>Lihat Edukasi Lainnya</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- 3 Card Grid Edukasi -->
            <div class="grid md:grid-cols-3 gap-8">
                
                <!-- Card Edukasi 1 (Artikel) -->
                <article class="bg-white rounded-2xl overflow-hidden border border-[#5A4A3A]/15 shadow-sm hover:shadow-md transition-all flex flex-col">
                    <div class="relative h-48 bg-[#1F3D2E]/20 flex items-center justify-center">
                        <!-- Icon Placeholder Image -->
                        <div class="text-[#1F3D2E]/40 text-5xl">
                            <i class="fa-solid fa-recycle"></i>
                        </div>
                        <span class="absolute top-4 left-4 bg-[#6B7F4E] text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            Artikel
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-[#5A4A3A]/60 font-medium">5 Menit Baca • Kebersihan</span>
                            <h4 class="text-lg font-bold text-[#1F3D2E] mt-2 mb-3 hover:text-[#4C6A73] transition-colors">
                                Memilah Sampah Organic & Anorganik dari Dapur
                            </h4>
                            <p class="text-sm text-[#5A4A3A]/80 line-clamp-2 leading-relaxed">
                                Panduan sederhana mengolah sisa makanan menjadi kompos skala rumah tangga tanpa menimbulkan bau menyengat.
                            </p>
                        </div>
                        <div class="pt-6">
                            <a href="#" class="text-xs font-bold text-[#1F3D2E] hover:text-[#6B7F4E] inline-flex items-center gap-1">
                                Baca Selengkapnya <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Card Edukasi 2 (Video) -->
                <article class="bg-white rounded-2xl overflow-hidden border border-[#5A4A3A]/15 shadow-sm hover:shadow-md transition-all flex flex-col">
                    <div class="relative h-48 bg-[#4C6A73]/20 flex items-center justify-center group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-[#1F3D2E] text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-play text-sm ml-0.5"></i>
                        </div>
                        <span class="absolute top-4 left-4 bg-[#4C6A73] text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            Video Tutorial
                        </span>
                        <span class="absolute bottom-3 right-3 bg-black/70 text-white text-[10px] font-medium px-2 py-0.5 rounded">
                            03:45
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-[#5A4A3A]/60 font-medium">Video Panduan • Hukum & Sanksi</span>
                            <h4 class="text-lg font-bold text-[#1F3D2E] mt-2 mb-3 hover:text-[#4C6A73] transition-colors">
                                Sanksi Pidana & Denda Bagi Pembuang Sampah Liar
                            </h4>
                            <p class="text-sm text-[#5A4A3A]/80 line-clamp-2 leading-relaxed">
                                Penjelasan Peraturan Daerah (Perda) tentang larangan membuang sampah sembarangan dan tata cara pelaporan.
                            </p>
                        </div>
                        <div class="pt-6">
                            <a href="#" class="text-xs font-bold text-[#1F3D2E] hover:text-[#4C6A73] inline-flex items-center gap-1">
                                Tonton Video <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Card Edukasi 3 (Artikel) -->
                <article class="bg-white rounded-2xl overflow-hidden border border-[#5A4A3A]/15 shadow-sm hover:shadow-md transition-all flex flex-col">
                    <div class="relative h-48 bg-[#6B7F4E]/20 flex items-center justify-center">
                        <div class="text-[#6B7F4E]/40 text-5xl">
                            <i class="fa-solid fa-box-archive"></i>
                        </div>
                        <span class="absolute top-4 left-4 bg-[#6B7F4E] text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            Artikel
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-xs text-[#5A4A3A]/60 font-medium">4 Menit Baca • Bank Sampah</span>
                            <h4 class="text-lg font-bold text-[#1F3D2E] mt-2 mb-3 hover:text-[#4C6A73] transition-colors">
                                Mengubah Sampah Plastik Menjadi Nilai Ekonomis
                            </h4>
                            <p class="text-sm text-[#5A4A3A]/80 line-clamp-2 leading-relaxed">
                                Langkah menyetor botol dan plastik bekas ke Bank Sampah terdekat untuk ditukar dengan saldo bernilai.
                            </p>
                        </div>
                        <div class="pt-6">
                            <a href="#" class="text-xs font-bold text-[#1F3D2E] hover:text-[#6B7F4E] inline-flex items-center gap-1">
                                Baca Selengkapnya <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </article>

            </div>
        </section>

        <!-- ==========================================
             BANNER TRANSPARANSI ALOKASI DANA IURAN
             (1 Card Horizontal Tanpa Nominal Uang)
             ========================================== -->
        <section id="transparansi" class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="bg-gradient-to-r from-[#1F3D2E] to-[#4C6A73] rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
                <!-- Background Accent Circle -->
                <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-[#6B7F4E]/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="grid md:grid-cols-12 gap-8 items-center relative z-10">
                    
                    <!-- Text Info Left -->
                    <div class="md:col-span-8 space-y-4">
                        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-[#DCC8A3] px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                            <span>Akuntabilitas & Kepercayaan Publik</span>
                        </div>
                        
                        <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                            Transparansi Alokasi Dana Iuran Kebersihan
                        </h3>

                        <p class="text-emerald-100 text-sm sm:text-base leading-relaxed max-w-2xl">
                            Setiap kontribusi iuran kebersihan masyarakat didistribusikan secara terencana untuk operasional armada pengangkut, penyediaan fasilitas sarpras pendukung, serta program pengelolaan lingkungan berkelanjutan.
                        </p>

                        <!-- Komponen Alokasi (Visual Badges Ringkas) -->
                        <div class="pt-2 flex flex-wrap gap-2 text-xs font-semibold text-[#DCC8A3]">
                            <span class="bg-white/10 px-3 py-1.5 rounded-lg border border-white/10 flex items-center gap-1.5">
                                <i class="fa-solid fa-truck-fuel text-[#6B7F4E]"></i> Operasional Armada & Bahan Bakar
                            </span>
                            <span class="bg-white/10 px-3 py-1.5 rounded-lg border border-white/10 flex items-center gap-1.5">
                                <i class="fa-solid fa-user-shield text-[#6B7F4E]"></i> APD & Kesejahteraan Petugas
                            </span>
                            <span class="bg-[#6B7F4E]/30 px-3 py-1.5 rounded-lg border border-white/10 flex items-center gap-1.5">
                                <i class="fa-solid fa-[#DCC8A3] fa-dumpster text-[#DCC8A3]"></i> Pemeliharaan Container Sampah
                            </span>
                        </div>
                    </div>

                    <!-- CTA Right -->
                    <div class="md:col-span-4 flex flex-col items-center md:items-end justify-center pt-4 md:pt-0 border-t md:border-t-0 border-white/10">
                        <a href="#transparansi-detail" class="w-full sm:w-auto bg-[#DCC8A3] hover:bg-white text-[#1F3D2E] font-bold px-6 py-3.5 rounded-xl shadow-md transition-all text-center flex items-center justify-center gap-2">
                            <span>Lihat Komponen Alokasi</span>
                            <i class="fa-solid fa-arrow-right-long text-sm"></i>
                        </a>
                        <span class="text-[11px] text-emerald-200/80 mt-2 text-center md:text-right">
                            *Laporan publik diperbarui secara berkala
                        </span>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <!-- ==========================================
         FOOTER SEDERHANA
         ========================================== -->
    <footer class="bg-[#1F3D2E] text-white border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                
                <!-- Branding Left -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#6B7F4E] flex items-center justify-center text-white font-bold text-sm">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <div>
                        <span class="font-bold text-base text-white">Sistem Pelaporan TPS Liar</span>
                        <p class="text-xs text-[#DCC8A3]">Layanan Resmi Pengaduan & Informasi Kebersihan Lingkungan</p>
                    </div>
                </div>

                <!-- Footer Quick Links -->
                <div class="flex flex-wrap justify-center gap-6 text-xs text-emerald-200 font-medium">
                    <a href="#" class="hover:text-white transition-colors">Beranda</a>
                    <a href="#lapor" class="hover:text-white transition-colors">Lapor TPS</a>
                    <a href="#lacak" class="hover:text-white transition-colors">Lacak Status</a>
                    <a href="#jadwal-opbm" class="hover:text-white transition-colors">Jadwal OPBM</a>
                    <a href="#transparansi" class="hover:text-white transition-colors">Transparansi Dana</a>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-white/10 text-center md:flex md:justify-between md:items-center text-xs text-emerald-200/70 space-y-2 md:space-y-0">
                <p>&copy; 2026 Dinas Lingkungan Hidup. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="text-[#DCC8A3]">Menuju Kota Bersih, Asri, dan Berkelanjutan</p>
            </div>
        </div>
    </footer>

    <!-- ==========================================
         JAVASCRIPT RINGKAS UNTUK TOGGLE DROPDOWN & MOBILE MENU
         ========================================== -->
    <script>
        // Toggle Mobile Navigation Menu
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

        // Toggle Desktop Dropdown Menu on Click (Optional fallback)
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('#desktop-dropdown *')) {
                const dropdowns = document.getElementsByClassName("group-hover:block");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('block')) {
                        openDropdown.classList.remove('block');
                    }
                }
            }
        }
    </script>
</body>
</html>