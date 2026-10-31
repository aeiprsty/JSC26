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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>


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
    
</head>
<body class="bg-[#DCC8A3] text-[#5A4A3A] antialiased selection:bg-[#6B7F4E] selection:text-white overflow-x-hidden min-h-screen flex flex-col">

    <!-- ==========================================
         NAVBAR / HEADER UTAMA
         ========================================== -->

    <header id="main-header" class="fixed top-0 left-0 w-full z-50 bg-[#1F3D2E] md:bg-transparent text-white transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Branding -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-[#6B7F4E] flex items-center justify-center text-white shadow-lg group-hover:bg-[#4C6A73] transition-colors duration-200">
                        <i class="fa-solid font-bold fa-leaf text-xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-lg tracking-tight leading-none text-white group-hover:text-[#DCC8A3] transition-colors">JambiBersih</span>
                        <span class="text-[10px] text-[#DCC8A3] font-medium tracking-wider uppercase">Dinas Lingkungan Hidup Kota Jambi</span>
                    </div>
                </a>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex items-center gap-8 ml-auto">
                    <a href="{{ url('/') }}" class="px-3 py-2 rounded-lg text-sm font-semibold text-white bg-white/10 transition-colors">
                        Beranda
                    </a>
                    
                    <a href="{{ url('/lapor') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors">
                        Lapor TPS
                    </a>

                    <a href="{{ url('/lacak') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors">
                        Cek Penanganan TPS
                    </a>

                    <!-- Dropdown Informasi & Edukasi -->
                    <div class="relative group" id="desktop-dropdown">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 transition-colors focus:outline-none" onclick="toggleDropdown('desktop-menu')">
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
                    <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-lg text-emerald-100 hover:text-white hover:bg-white/10 focus:outline-none" aria-label="Buka Menu Navigasi">
                        <i id="hamburger-icon" class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Navigation Panel -->
        <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-[#1F3D2E] border-t border-b border-white/10 px-4 pt-3 pb-6 space-y-2 shadow-2xl z-50">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-white bg-white/10">
                Beranda
            </a>
            <a href="{{ url('/lapor') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Lapor TPS
            </a>
            <a href="{{ url('/lacak') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Cek Penanganan TPS
            </a>
            
            <!-- Mobile Submenu Accordion -->
            <div class="pt-2 border-t border-white/10">
                <div class="px-3 py-1 text-xs font-semibold text-[#DCC8A3] uppercase tracking-wider">Informasi & Edukasi</div>
                <a href="{{ url('/jadwal') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="text-[#6B7F4E]"></i>
                    <span>Jadwal OPBM</span>
                </a>
                <a href="{{ url('/transparansi') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="ext-[#4C6A73]"></i>
                    <span>Transparansi Alokasi Dana</span>
                </a>
                <a href="{{ url('/edukasi') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="text-[#DCC8A3]"></i>
                    <span>Edukasi</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        
        <!-- ==========================================
             HERO SECTION
             ========================================== -->
        <!-- HERO SECTION (BACKGROUND FADE & KONTEN KIRI) -->
        <!-- HERO SECTION -->
        <section class="relative bg-[#FFFAE8] text-white overflow-hidden pt-24 pb-36 sm:pb-44 lg:pb-52 min-h-[680px] flex items-center">
                    
            <!-- 1. GAMBAR BACKGROUND DENGAN OVERLAY GRADIENT -->
            <div class="absolute inset-0 z-0">
                <!-- Gambar Lingkungan/Armada di Sebelah Kanan -->
                <img src="{{ asset('images/hero-lingkungan(1).jpeg') }}" 
                    alt="Lingkungan Bersih Kota Jambi" 
                    class="w-full h-full object-cover object-right">
                
                <!-- Gradient Overlay: Gelap/Penuh di Kiri, Transparan ke Kanan -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#1F3D2E] via-[#1F3D2E]/90 sm:via-[#1F3D2E]/80 to-transparent"></div>
            </div>

            <!-- 2. KONTEN UTAMA HERO (DI ATAS OVERLAY) -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-8">
                <div class="max-w-xl space-y-6 reveal opacity-0 translate-y-10 transition-all duration-700 ease-out">
                    
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
                        <a href="{{ url('/lapor') }}" class="bg-[#6B7F4E] hover:scale-105 transition-all text-white font-bold px-6 py-3.5 rounded-xl shadow-lg flex items-center gap-2 text-sm">
                            <span>Lapor TPS Liar Sekarang</span>
                        </a>

                        <a href="{{ url('/lacak') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold px-6 py-3.5 rounded-xl border border-white/20 backdrop-blur-md transition-all text-sm">
                            <span>Lacak Laporan</span>
                        </a>
                    </div>

                </div>
            </div>

            <!-- 3. SVG GELOMBANG (LENGKUNGAN MENTOK KE BAWAH) -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none z-20 pointer-events-none">
                <svg class="relative block w-full h-12 sm:h-20 lg:h-28" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,60 C320,110 420,30 720,70 C1020,110 1120,30 1440,60 L1440,120 L0,120 Z" style="fill: #FFFAE8;"></path>
                </svg>
            </div>

        </section>

        <!-- ==========================================
             SECTION: 3 LANGKAH MUDAH LAPOR
             ========================================== -->
        <!-- SECTION ALUR JALAN BERGELOMBANG (ROADMAP PROCESS) -->
        <section id="alur" class="relative py-20 bg-[#FFFAE8]">
            <!-- Isi Konten Alur Operasional -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                <!-- Judul Section -->
                <div class="text-center max-w-2xl mx-auto mb-1 space-y-2 reveal opacity-0 translate-y-10 transition-all duration-700 ease-out">
                    <span class="text-[#6B7F4E] font-bold text-xs uppercase tracking-widest bg-[#6B7F4E]/10 px-3.5 py-1.5 rounded-full">
                        Alur Operasional
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-[#1F3D2E]">
                        Proses Penanganan TPS Liar
                    </h2>
                    <p class="text-sm text-[#5A4A3A]">
                        Perjalanan laporan masyarakat dari pengaduan awal hingga penanganan bersih di lapangan.
                    </p>
                </div>

                <!-- CONTAINER JALAN SVG & TITIK ALUR -->
                <div class="relative w-full aspect-[12/4] min-h-[450px] md:min-h-[380px]">

                    <!-- 1. SVG JALAN RAYA BERGELOMBANG & ANIMASI TRUK -->
                    <div class="absolute inset-0 w-full h-full pointer-events-none hidden md:block z-0">
                        <svg viewBox="0 0 1200 350" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                            <!-- Aspal Jalan -->
                            <path d="M 50 100 C 200 100, 250 280, 400 280 C 550 280, 600 70, 750 70 C 900 70, 950 280, 1150 280" 
                                stroke="#94A3B8" stroke-width="44" stroke-linecap="round"/>
                            
                            <!-- Markah Putus-Putus -->
                            <path d="M 50 100 C 200 100, 250 280, 400 280 C 550 280, 600 70, 750 70 C 900 70, 950 280, 1150 280" 
                                stroke="#FFFFFF" stroke-width="4" stroke-dasharray="14 14" stroke-linecap="round"/>

                            <!-- ANIMASI TRUK SAMPAH (TERKUNCI DI DALAM SVG & OTOMATIS MIRING) -->
                            <g>
                                <image href="{{ asset('images/truk-hijau.png') }}" x="-120" y="-90" width="240" height="144" />
                                <animateMotion 
                                    path="M 50 100 C 200 100, 250 280, 400 280 C 550 280, 600 70, 750 70 C 900 70, 950 280, 1150 280" 
                                    dur="12s" 
                                    repeatCount="indefinite" 
                                    rotate="auto" />
                            </g>
                        </svg>
                    </div>

                    <!-- 2. TITIK-TITIK ALUR (KEMBALI KE POSISI ASLI REFA YANG RAPI) -->
                    <!-- 2. TITIK-TITIK ALUR (DENGAN ANIMASI SCROLL BERURUTAN DESKTOP) -->
                    <div class="hidden md:block absolute inset-0 z-20">
                        
                        <!-- Titik 1: Foto & Lokasi (Tanpa Delay) -->
                        <div class="absolute reveal opacity-0 translate-y-10 transition-all duration-700 ease-out" style="left: 6%; top: 45%;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#1F3D2E] text-white flex items-center justify-center text-2xl shadow-xl border-4 border-white z-10">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <div class="absolute top-[115%] w-52 text-center bg-white/90 backdrop-blur-sm p-3 rounded-2xl border border-slate-200 shadow-md">
                                    <h3 class="font-bold text-[#1F3D2E] text-sm">1. Foto & Lokasi</h3>
                                    <p class="text-[11px] text-[#5A4A3A] mt-0.5 leading-snug">Masyarakat mengambil foto tumpukan sampah & patokan titik lokasi.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Titik 2: Terbit Kode Tiket (Delay 150ms) -->
                        <div class="absolute reveal opacity-0 translate-y-10 transition-all duration-700 delay-150 ease-out" style="left: 31%; top: 45%;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#4C6A73] text-white flex items-center justify-center text-2xl shadow-xl border-4 border-white z-10">
                                    <i class="fa-solid fa-ticket"></i>
                                </div>
                                <div class="absolute bottom-[115%] w-52 text-center bg-white/90 backdrop-blur-sm p-3 rounded-2xl border border-slate-200 shadow-md">
                                    <h3 class="font-bold text-[#1F3D2E] text-sm">2. Terbit Kode Tiket</h3>
                                    <p class="text-[11px] text-[#5A4A3A] mt-0.5 leading-snug">Sistem memberikan kode lacak unik untuk memantau status.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Titik 3: Pembersihan OPBM (Delay 300ms) -->
                        <div class="absolute reveal opacity-0 translate-y-10 transition-all duration-700 delay-300 ease-out" style="left: 60%; top: 45%;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#6B7F4E] text-white flex items-center justify-center text-2xl shadow-xl border-4 border-white z-10">
                                    <i class="fa-solid fa-people-carry-box"></i>
                                </div>
                                <div class="absolute top-[115%] w-52 text-center bg-white/90 backdrop-blur-sm p-3 rounded-2xl border border-slate-200 shadow-md">
                                    <h3 class="font-bold text-[#1F3D2E] text-sm">3. Pembersihan OPBM</h3>
                                    <p class="text-[11px] text-[#5A4A3A] mt-0.5 leading-snug">Armada bentor/truk dan tim bergerak membersihkan lokasi.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Titik 4: Wilayah Bersih (Delay 500ms) -->
                        <div class="absolute reveal opacity-0 translate-y-10 transition-all duration-700 delay-500 ease-out" style="left: 88%; top: 45%;">
                            <div class="relative flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-[#5A4A3A] text-white flex items-center justify-center text-2xl shadow-xl border-4 border-white z-10">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <div class="absolute bottom-[115%] w-52 text-center bg-white/90 backdrop-blur-sm p-3 rounded-2xl border border-slate-200 shadow-md">
                                    <h3 class="font-bold text-[#1F3D2E] text-sm">4. Wilayah Bersih</h3>
                                    <p class="text-[11px] text-[#5A4A3A] mt-0.5 leading-snug">Lokasi bersih kembali dan status laporan diperbarui jadi Selesai.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- TAMPILAN RESPONSIVENESS KHUSUS MOBILE (HP) DENGAN ANIMASI SCROLL -->
                    <div class="grid grid-cols-1 gap-6 md:hidden relative z-20">
                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm reveal opacity-0 translate-y-10 transition-all duration-700 ease-out">
                            <div class="w-12 h-12 rounded-full bg-[#1F3D2E] text-white flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-camera"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">1. Foto & Lokasi</h3>
                                <p class="text-xs text-[#5A4A3A]">Masyarakat mengambil foto tumpukan sampah & patokan titik lokasi.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm reveal opacity-0 translate-y-10 transition-all duration-700 delay-150 ease-out">
                            <div class="w-12 h-12 rounded-full bg-[#4C6A73] text-white flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">2. Terbit Kode Tiket</h3>
                                <p class="text-xs text-[#5A4A3A]">Sistem memberikan kode lacak unik untuk memantau status.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm reveal opacity-0 translate-y-10 transition-all duration-700 delay-300 ease-out">
                            <div class="w-12 h-12 rounded-full bg-[#6B7F4E] text-white flex items-center justify-center text-xl shrink-0">
                                <i class="fa-solid fa-people-carry-box"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">3. Pembersihan OPBM</h3>
                                <p class="text-xs text-[#5A4A3A]">Armada bentor/truk dan tim bergerak membersihkan lokasi.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm reveal opacity-0 translate-y-10 transition-all duration-700 delay-500 ease-out">
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
        <section id="jadwal-opbm" class="relative py-20 bg-[#DCC8A3]/40">
            <!-- Overlay Gradasi Mulus dari Alur (#FFFAE8) ke Jadwal -->
            <div class="absolute top-0 inset-x-0 h-24 bg-gradient-to-b from-[#FFFAE8] to-transparent pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                <!-- HEADER SECTION -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4 reveal opacity-0 translate-y-10 transition-all duration-700 ease-out">
                    <div>
                        <span class="bg-[#6B7F4E]/20 text-[#1F3D2E] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-alt text-[#6B7F4E]"></i> Operasi Pembersihan Bersama
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F3D2E] mt-3">Jadwal Penjemputan OPBM Terdekat</h2>
                        <p class="text-sm text-[#5A4A3A] mt-1">Pantau hari dan jam keliling armada pembersihan sampah di wilayahmu.</p>
                    </div>
                    
                    <!-- Tombol Ke Halaman Jadwal Lengkap -->
                    <a href="{{ url('/jadwal') }}" class="inline-flex items-center gap-2 text-xs font-extrabold text-[#1F3D2E] hover:text-[#6B7F4E] transition-colors shrink-0">
                        <span>Lihat Jadwal Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- TABEL PREVIEW JADWAL -->
                <div class="bg-white rounded-3xl shadow-lg border border-[#5A4A3A]/15 overflow-hidden reveal opacity-0 translate-y-10 transition-all duration-700 delay-150 ease-out">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            
                            <thead>
                                <tr class="bg-[#1F3D2E] text-white text-xs uppercase tracking-wider font-semibold">
                                    <th class="py-4 px-6">Wilayah / Kelurahan</th>
                                    <th class="py-4 px-6">Cakupan Area (RT)</th>
                                    <th class="py-4 px-6">Hari Penjemputan</th>
                                    <th class="py-4 px-6">Jam Operasional</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 text-sm font-medium text-[#5A4A3A]">
                                
                                <!-- BARIS 1 -->
                                <tr class="hover:bg-[#DCC8A3]/10 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-[#1F3D2E]">Kel. Dahlan</div>
                                        <div class="text-xs text-[#5A4A3A]/70">Kec. Sukajadi</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-[#6B7F4E]/10 text-[#1F3D2E] text-xs px-2.5 py-1 rounded-md font-semibold">RT 01 s/d RT 08</span>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="font-bold text-[#1F3D2E]">Senin & Kamis</div>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="text-xs bg-amber-50 text-amber-800 border border-amber-200 px-3 py-1 rounded-lg font-bold inline-flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock"></i> 06.30 - 09.00 WIB
                                        </span>
                                    </td>
                                </tr>

                                <!-- BARIS 2 -->
                                <tr class="hover:bg-[#DCC8A3]/10 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-[#1F3D2E]">Kel. Kebun Handil</div>
                                        <div class="text-xs text-[#5A4A3A]/70">Kec. Jelutung</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-[#6B7F4E]/10 text-[#1F3D2E] text-xs px-2.5 py-1 rounded-md font-semibold">RT 01 s/d RT 15</span>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="font-bold text-[#1F3D2E]">Selasa & Jumat</div>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="text-xs bg-amber-50 text-amber-800 border border-amber-200 px-3 py-1 rounded-lg font-bold inline-flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock"></i> 07.00 - 10.00 WIB
                                        </span>
                                    </td>
                                </tr>

                                <!-- BARIS 3 -->
                                <tr class="hover:bg-[#DCC8A3]/10 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-[#1F3D2E]">Kel. Lingkar Selatan</div>
                                        <div class="text-xs text-[#5A4A3A]/70">Kec. Paal Merah</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-[#6B7F4E]/10 text-[#1F3D2E] text-xs px-2.5 py-1 rounded-md font-semibold">RT 05 s/d RT 18</span>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="font-bold text-[#1F3D2E]">Rabu & Sabtu</div>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="text-xs bg-amber-50 text-amber-800 border border-amber-200 px-3 py-1 rounded-lg font-bold inline-flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock"></i> 06.30 - 09.30 WIB
                                        </span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

        <!-- ==========================================
             SECTION: PREVIEW EDUKASI (ARTIKEL & VIDEO)
             ========================================== -->
        <section id="edukasi" class="relative py-20 bg-[#FFFAE8]">
            <!-- Overlay Gradasi Mulus dari Cokelat Jadwal (#DCC8A3) Memudar ke Krem Edukasi -->
            <div class="absolute top-0 inset-x-0 h-24 bg-gradient-to-b from-[#DCC8A3] to-transparent pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                
                <!-- HEADER SECTION -->
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 reveal opacity-0 translate-y-10 transition-all duration-700 ease-out">
                    <div>
                        <span class="bg-[#6B7F4E]/20 text-[#1F3D2E] text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-graduation-cap text-[#6B7F4E]"></i> Literasi Kebersihan
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F3D2E] mt-3">Edukasi & Media Kebersihan</h2>
                        <p class="text-sm text-[#5A4A3A] mt-1">Tingkatkan kepedulian lingkungan melalui video edukatif dan artikel panduan.</p>
                    </div>
                    <a href="{{ url('/edukasi') }}" class="inline-flex items-center gap-2 text-xs font-extrabold text-[#1F3D2E] hover:text-[#6B7F4E] transition-colors shrink-0">
                        <span>Lihat Semua Media</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- GRID 2 KOLOM -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- KOLOM KIRI: SLIDER VIDEO 3D TANPA BINGKAI KOTAK -->
                    <div class="lg:col-span-7 space-y-3 reveal opacity-0 translate-y-10 transition-all duration-700 ease-out">
                        <div class="flex items-center justify-between px-1">
                            <h3 class="text-base font-bold text-[#1F3D2E] flex items-center gap-2">
                                <i class="fa-solid fa-circle-play text-[#6B7F4E]"></i> Video Edukasi
                            </h3>
                            
                            <!-- Tombol Navigasi Panah -->
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="prevVideoStack()" class="w-8 h-8 rounded-full bg-white border border-[#5A4A3A]/20 text-[#1F3D2E] hover:bg-[#1F3D2E] hover:text-white transition-all flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                </button>
                                <button type="button" onclick="nextVideoStack()" class="w-8 h-8 rounded-full bg-white border border-[#5A4A3A]/20 text-[#1F3D2E] hover:bg-[#1F3D2E] hover:text-white transition-all flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- WADAH TRANSPARAN (OVERFLOW-VISIBLE AGAR KARTU MEKAR FULL) -->
                        <div class="relative w-full h-[280px] sm:h-[340px] flex items-center justify-center overflow-visible my-2">
                            
                            <!-- KARTU 1 -->
                            <div class="v-card absolute w-[65%] sm:w-[60%] aspect-[16/10] bg-black rounded-2xl overflow-hidden shadow-xl border border-white/30 transition-all duration-500 ease-in-out cursor-pointer group"
                                onclick="goToVideoStack(0)">
                                <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=800&auto=format&fit=crop&q=80" alt="Video 1" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                        <i class="fa-solid fa-play ml-0.5"></i>
                                    </div>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent p-4 text-white">
                                    <span class="text-[9px] bg-[#6B7F4E] font-bold px-2.5 py-0.5 rounded-full uppercase">Panduan</span>
                                    <h4 class="text-xs sm:text-sm font-bold mt-1 line-clamp-1">Tata Cara Melaporkan TPS Liar</h4>
                                </div>
                            </div>

                            <!-- KARTU 2 -->
                            <div class="v-card absolute w-[65%] sm:w-[60%] aspect-[16/10] bg-black rounded-2xl overflow-hidden shadow-xl border border-white/30 transition-all duration-500 ease-in-out cursor-pointer group"
                                onclick="goToVideoStack(1)">
                                <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?w=800&auto=format&fit=crop&q=80" alt="Video 2" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                        <i class="fa-solid fa-play ml-0.5"></i>
                                    </div>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent p-4 text-white">
                                    <span class="text-[9px] bg-[#4C6A73] font-bold px-2.5 py-0.5 rounded-full uppercase">Pemilahan</span>
                                    <h4 class="text-xs sm:text-sm font-bold mt-1 line-clamp-1">Pilah Sampah Organik & Anorganik</h4>
                                </div>
                            </div>

                            <!-- KARTU 3 -->
                            <div class="v-card absolute w-[65%] sm:w-[60%] aspect-[16/10] bg-black rounded-2xl overflow-hidden shadow-xl border border-white/30 transition-all duration-500 ease-in-out cursor-pointer group"
                                onclick="goToVideoStack(2)">
                                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800&auto=format&fit=crop&q=80" alt="Video 3" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                        <i class="fa-solid fa-play ml-0.5"></i>
                                    </div>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent p-4 text-white">
                                    <span class="text-[9px] bg-[#DCC8A3] text-[#1F3D2E] font-bold px-2.5 py-0.5 rounded-full uppercase">Operasional</span>
                                    <h4 class="text-xs sm:text-sm font-bold mt-1 line-clamp-1">Mengenal Armada Bentor Hijau</h4>
                                </div>
                            </div>

                            <!-- KARTU 4 -->
                            <div class="v-card absolute w-[65%] sm:w-[60%] aspect-[16/10] bg-black rounded-2xl overflow-hidden shadow-xl border border-white/30 transition-all duration-500 ease-in-out cursor-pointer group"
                                onclick="goToVideoStack(3)">
                                <img src="https://images.unsplash.com/photo-1530587191325-3db32d826c18?w=800&auto=format&fit=crop&q=80" alt="Video 4" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                        <i class="fa-solid fa-play ml-0.5"></i>
                                    </div>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent p-4 text-white">
                                    <span class="text-[9px] bg-red-800 font-bold px-2.5 py-0.5 rounded-full uppercase">Dampak Lingkungan</span>
                                    <h4 class="text-xs sm:text-sm font-bold mt-1 line-clamp-1">Bahaya Penumpukan TPS Liar</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- KOLOM KANAN: DAFTAR ARTIKEL TERBARU -->
                    <div class="lg:col-span-5 space-y-3 reveal opacity-0 translate-y-10 transition-all duration-700 delay-200 ease-out">
                        <h3 class="text-base font-bold text-[#1F3D2E] mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-newspaper text-[#4C6A73]"></i> Artikel Terbaru
                        </h3>

                        <div class="space-y-3">
                            <!-- ARTIKEL 1 -->
                            <a href="{{ url('/edukasi') }}" class="flex items-center gap-4 p-3 bg-white hover:bg-white rounded-2xl border border-[#5A4A3A]/10 transition-all shadow-sm group">
                                <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=200&auto=format&fit=crop&q=80" alt="Artikel 1" class="w-16 h-16 rounded-xl object-cover shrink-0 border border-gray-200">
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-xs font-bold text-[#1F3D2E] group-hover:text-[#4C6A73] transition-colors line-clamp-2 leading-snug">
                                        Sanksi & Denda Bagi Pelaku Pembuang Sampah Liar
                                    </h4>
                                    <span class="text-[10px] text-[#5A4A3A]/70 mt-1 block">25 Okt 2026 • 3 min read</span>
                                </div>
                            </a>

                            <!-- ARTIKEL 2 -->
                            <a href="{{ url('/edukasi') }}" class="flex items-center gap-4 p-3 bg-white hover:bg-white rounded-2xl border border-[#5A4A3A]/10 transition-all shadow-sm group">
                                <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?w=200&auto=format&fit=crop&q=80" alt="Artikel 2" class="w-16 h-16 rounded-xl object-cover shrink-0 border border-gray-200">
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-xs font-bold text-[#1F3D2E] group-hover:text-[#4C6A73] transition-colors line-clamp-2 leading-snug">
                                        5 Langkah Mengolah Sisa Dapur Menjadi Kompos
                                    </h4>
                                    <span class="text-[10px] text-[#5A4A3A]/70 mt-1 block">20 Okt 2026 • 5 min read</span>
                                </div>
                            </a>

                            <!-- ARTIKEL 3 -->
                            <a href="{{ url('/edukasi') }}" class="flex items-center gap-4 p-3 bg-white hover:bg-white rounded-2xl border border-[#5A4A3A]/10 transition-all shadow-sm group">
                                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=200&auto=format&fit=crop&q=80" alt="Artikel 3" class="w-16 h-16 rounded-xl object-cover shrink-0 border border-gray-200">
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-xs font-bold text-[#1F3D2E] group-hover:text-[#4C6A73] transition-colors line-clamp-2 leading-snug">
                                        Peran Bank Sampah Kelurahan Dalam Kebersihan
                                    </h4>
                                    <span class="text-[10px] text-[#5A4A3A]/70 mt-1 block">14 Okt 2026 • 4 min read</span>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </section>



        <!-- ==========================================
             BANNER TRANSPARANSI ALOKASI DANA IURAN
             (1 Card Horizontal Tanpa Nominal Uang)
             ========================================== -->

        <section id="transparansi" class="relative py-20 bg-[#DCC8A3]/30">
            <!-- Overlay Gradasi dari Edukasi (#FFFAE8) ke Transparansi -->
            <div class="absolute top-0 inset-x-0 h-16 bg-gradient-to-b from-[#FFFAE8] to-transparent pointer-events-none"></div>

            <!-- Isi Konten Transparansi Dana -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="bg-[#1F3D2E] rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
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
                        <a href="{{ url('/transparansi') }}" class="w-full sm:w-auto bg-[#DCC8A3] hover:bg-white text-[#1F3D2E] font-bold px-6 py-3.5 rounded-xl shadow-md transition-all text-center flex items-center justify-center gap-2">
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

        let vStackIndex = 0;
        const vCards = document.querySelectorAll('.v-card');
        const vTotal = vCards.length;

        function renderVideoStack() {
            vCards.forEach((card, i) => {
                let diff = i - vStackIndex;
                
                if (diff > vTotal / 2) diff -= vTotal;
                if (diff < -vTotal / 2) diff += vTotal;

                if (diff === 0) {
                    // KARTU UTAMA (TENGAH - BESAR)
                    card.style.transform = 'translateX(0%) scale(1)';
                    card.style.zIndex = '30';
                    card.style.opacity = '1';
                    card.style.filter = 'brightness(1)';
                } else if (diff === -1) {
                    // KARTU KIRI (MENGINTIP LEBIH LEBAR DENGAN ROTASI TIPIS)
                    card.style.transform = 'translateX(-45%) scale(0.85) rotate(-3deg)';
                    card.style.zIndex = '20';
                    card.style.opacity = '0.75';
                    card.style.filter = 'brightness(0.75)';
                } else if (diff === 1) {
                    // KARTU KANAN (MENGINTIP LEBIH LEBAR DENGAN ROTASI TIPIS)
                    card.style.transform = 'translateX(45%) scale(0.85) rotate(3deg)';
                    card.style.zIndex = '20';
                    card.style.opacity = '0.75';
                    card.style.filter = 'brightness(0.75)';
                } else {
                    // KARTU CADANGAN DIBELAKANG
                    card.style.transform = 'translateX(0%) scale(0.6)';
                    card.style.zIndex = '10';
                    card.style.opacity = '0';
                }
            });
        }

        function nextVideoStack() {
            vStackIndex = (vStackIndex + 1) % vTotal;
            renderVideoStack();
        }

        function prevVideoStack() {
            vStackIndex = (vStackIndex - 1 + vTotal) % vTotal;
            renderVideoStack();
        }

        function goToVideoStack(idx) {
            vStackIndex = idx;
            renderVideoStack();
        }

        document.addEventListener('DOMContentLoaded', renderVideoStack);

        document.addEventListener("DOMContentLoaded", function () {
            const observerOptions = {
                root: null,
                threshold: 0.15 // Animasi berjalan saat 15% elemen terlihat di layar
            };

            const scrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Saat elemen MASUK ke layar: Munculkan secara halus
                        entry.target.classList.remove('opacity-0', 'translate-y-10', '-translate-x-10');
                        entry.target.classList.add('opacity-100', 'translate-y-0', 'translate-x-0');
                    } else {
                        // Saat elemen KELUAR dari layar: Sembunyikan kembali
                        entry.target.classList.remove('opacity-100', 'translate-y-0', 'translate-x-0');
                        entry.target.classList.add('opacity-0', 'translate-y-10');
                    }
                });
            }, observerOptions);

            // Tempelkan pemantau ke semua elemen ber-class 'reveal'
            document.querySelectorAll('.reveal').forEach(el => scrollObserver.observe(el));
        });

        // Efek Navbar Transparan -> Berwarna saat di-scroll (Hanya Desktop)
        window.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            
            if (header && window.innerWidth >= 768) { // 768px = breakpoint desktop md: di Tailwind
                if (window.scrollY > 50) {
                    header.classList.add('md:bg-[#1F3D2E]', 'shadow-md');
                    header.classList.remove('md:bg-transparent');
                } else {
                    header.classList.remove('md:bg-[#1F3D2E]', 'shadow-md');
                    header.classList.add('md:bg-transparent');
                }
            }
        });
    </script>
</body>
</html>