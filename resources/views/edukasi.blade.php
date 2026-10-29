<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi & Media Kebersihan - JambiBersih</title>
    
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
                <div class="px-3 py-1 text-xs font-semibold text-[#DCC8A3] uppercase tracking-wider">Informasi & Edukasi</div>
                <a href="{{ url('/jadwal') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="text-[#6B7F4E]"></i>
                    <span>Jadwal OPBM</span>
                </a>
                <a href="{{ url('/transparansi') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="text-[#4C6A73]"></i>
                    <span>Transparansi Alokasi Dana</span>
                </a>
                <a href="{{ url('/edukasi') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-white bg-white/10 rounded-lg">
                    <i class="text-[#DCC8A3]"></i>
                    <span>Edukasi</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT HALAMAN EDUKASI -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto w-full space-y-16">
        
        <!-- HEADER HALAMAN -->
        <div class="text-center max-w-2xl mx-auto">
            <span class="bg-[#1F3D2E]/10 text-[#1F3D2E] text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5">
                <i class="fa-solid fa-graduation-cap text-[#6B7F4E]"></i> Pusat Literasi Lingkungan
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F3D2E] mt-3">Edukasi & Media Kebersihan</h1>
            <p class="text-sm text-[#5A4A3A] mt-2">Tingkatkan kepedulian lingkungan melalui video edukatif interaktif dan artikel panduan pemilahan sampah di Kota Jambi.</p>
        </div>

        <!-- ==========================================
             SECTION 1: VIDEO EDUKASI (SCROLL KESAMPING)
             ========================================== -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-extrabold text-[#1F3D2E] flex items-center gap-2">
                        <i class="fa-solid fa-[#6B7F4E] fa-circle-play text-[#6B7F4E]"></i> Video Pembelajaran
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
                
                <!-- CARD VIDEO 1 -->
                <div class="min-w-[280px] sm:min-w-[320px] max-w-[320px] bg-white rounded-3xl border border-[#5A4A3A]/15 shadow-md overflow-hidden snap-start shrink-0 group">
                    <div class="relative overflow-hidden aspect-video bg-black/80">
                        <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=600&auto=format&fit=crop&q=80" alt="Video 1" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90">
                        <span class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-2 py-0.5 rounded">03:45</span>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                <i class="fa-solid fa-play ml-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2.5 py-0.5 rounded-md">Tata Cara Lapor</span>
                        <h3 class="text-sm font-bold text-[#1F3D2E] mt-2 line-clamp-2">Panduan Melaporkan TPS Liar Lewat Aplikasi SIPAS</h3>
                        <p class="text-xs text-[#5A4A3A]/80 mt-1 line-clamp-2">Langkah mudah memfoto dan menandai titik GPS lokasi tumpukan sampah liar.</p>
                    </div>
                </div>

                <!-- CARD VIDEO 2 -->
                <div class="min-w-[280px] sm:min-w-[320px] max-w-[320px] bg-white rounded-3xl border border-[#5A4A3A]/15 shadow-md overflow-hidden snap-start shrink-0 group">
                    <div class="relative overflow-hidden aspect-video bg-black/80">
                        <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?w=600&auto=format&fit=crop&q=80" alt="Video 2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90">
                        <span class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-2 py-0.5 rounded">05:12</span>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                <i class="fa-solid fa-play ml-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-2.5 py-0.5 rounded-md">Pemilahan Rumah Tangga</span>
                        <h3 class="text-sm font-bold text-[#1F3D2E] mt-2 line-clamp-2">Pilah Sampah Organik & Anorganik Dapur</h3>
                        <p class="text-xs text-[#5A4A3A]/80 mt-1 line-clamp-2">Cara praktis memisahkan sisa sisa bahan makanan dengan limbah plastik kemasan.</p>
                    </div>
                </div>

                <!-- CARD VIDEO 3 -->
                <div class="min-w-[280px] sm:min-w-[320px] max-w-[320px] bg-white rounded-3xl border border-[#5A4A3A]/15 shadow-md overflow-hidden snap-start shrink-0 group">
                    <div class="relative overflow-hidden aspect-video bg-black/80">
                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=600&auto=format&fit=crop&q=80" alt="Video 3" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90">
                        <span class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-2 py-0.5 rounded">04:20</span>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                <i class="fa-solid fa-play ml-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] bg-blue-100 text-blue-800 font-bold px-2.5 py-0.5 rounded-md">Operasional OPBM</span>
                        <h3 class="text-sm font-bold text-[#1F3D2E] mt-2 line-clamp-2">Mengenal Cara Kerja Armada Motor Bentor Hijau</h3>
                        <p class="text-xs text-[#5A4A3A]/80 mt-1 line-clamp-2">Melihat langsung rute kerja petugas kebersihan menjemput sampah ke lorong Masyarakat.</p>
                    </div>
                </div>

                <!-- CARD VIDEO 4 -->
                <div class="min-w-[280px] sm:min-w-[320px] max-w-[320px] bg-white rounded-3xl border border-[#5A4A3A]/15 shadow-md overflow-hidden snap-start shrink-0 group">
                    <div class="relative overflow-hidden aspect-video bg-black/80">
                        <img src="https://images.unsplash.com/photo-1530587191325-3db32d826c18?w=600&auto=format&fit=crop&q=80" alt="Video 4" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90">
                        <span class="absolute bottom-2 right-2 bg-black/70 text-white text-[10px] font-bold px-2 py-0.5 rounded">02:50</span>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-[#1F3D2E]/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:bg-[#6B7F4E] transition-all">
                                <i class="fa-solid fa-play ml-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] bg-red-100 text-red-800 font-bold px-2.5 py-0.5 rounded-md">Bahaya TPS Liar</span>
                        <h3 class="text-sm font-bold text-[#1F3D2E] mt-2 line-clamp-2">Dampak Tumpukan Sampah Bagi Kesehatan</h3>
                        <p class="text-xs text-[#5A4A3A]/80 mt-1 line-clamp-2">Bahaya pencemaran air tanah dan risiko penyakit akibat pembuangan liar.</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- ==========================================
             SECTION 2: ARTIKEL EDUKASI (SCROLL KEBAWAH)
             ========================================== -->
        <section class="space-y-6 pt-6 border-t border-[#5A4A3A]/10">
            <div>
                <h2 class="text-xl font-extrabold text-[#1F3D2E] flex items-center gap-2">
                    <i class="fa-solid fa-newspaper text-[#4C6A73]"></i> Artikel & Panduan Lingkungan
                </h2>
                <p class="text-xs text-[#5A4A3A]/80 mt-0.5">Baca artikel informatif untuk menerapkan gaya hidup bersih dan bebas sampah liar</p>
            </div>

            <!-- LIST ARTIKEL VERTIKAL -->
            <div class="space-y-4">
                
                <!-- ARTIKEL 1 -->
                <article class="bg-white rounded-3xl p-5 sm:p-6 border border-[#5A4A3A]/15 shadow-md hover:shadow-lg transition-all flex flex-col sm:flex-row gap-5 items-start">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?w=400&auto=format&fit=crop&q=80" alt="Artikel 1" class="w-full sm:w-48 h-36 object-cover rounded-2xl shrink-0">
                    <div class="flex-grow space-y-2">
                        <div class="flex items-center gap-3 text-xs text-[#5A4A3A]/70">
                            <span class="bg-[#1F3D2E]/10 text-[#1F3D2E] font-bold px-2.5 py-0.5 rounded-md">Regulasi & Hukum</span>
                            <span><i class="fa-regular fa-calendar mr-1"></i> 25 Oktober 2026</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-[#1F3D2E] hover:text-[#4C6A73] transition-colors">
                            Sanksi & Denda Bagi Pelaku Pembuang Sampah Liar di Kota Jambi
                        </h3>
                        <p class="text-xs sm:text-sm text-[#5A4A3A] line-clamp-2">
                            Ketahui Peraturan Daerah mengenai penegakan hukum dan denda administratif bagi oknum yang kedapatan membuang sampah sembarangan di pinggir jalan utama.
                        </p>
                        <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1F3D2E] hover:text-[#6B7F4E] pt-1">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </article>

                <!-- ARTIKEL 2 -->
                <article class="bg-white rounded-3xl p-5 sm:p-6 border border-[#5A4A3A]/15 shadow-md hover:shadow-lg transition-all flex flex-col sm:flex-row gap-5 items-start">
                    <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?w=400&auto=format&fit=crop&q=80" alt="Artikel 2" class="w-full sm:w-48 h-36 object-cover rounded-2xl shrink-0">
                    <div class="flex-grow space-y-2">
                        <div class="flex items-center gap-3 text-xs text-[#5A4A3A]/70">
                            <span class="bg-[#6B7F4E]/10 text-[#1F3D2E] font-bold px-2.5 py-0.5 rounded-md">Tip Lingkungan</span>
                            <span><i class="fa-regular fa-calendar mr-1"></i> 20 Oktober 2026</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-[#1F3D2E] hover:text-[#4C6A73] transition-colors">
                            5 Langkah Mudah Mengolah Dapur Menjadi Pupuk Kompos Organik
                        </h3>
                        <p class="text-xs sm:text-sm text-[#5A4A3A] line-clamp-2">
                            Ubah sisa sayuran dan kulit buah menjadi pupuk kaya nutrisi untuk tanaman di pekarangan rumah tanpa menimbulkan bau tidak sedap.
                        </p>
                        <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1F3D2E] hover:text-[#6B7F4E] pt-1">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </article>

                <!-- ARTIKEL 3 -->
                <article class="bg-white rounded-3xl p-5 sm:p-6 border border-[#5A4A3A]/15 shadow-md hover:shadow-lg transition-all flex flex-col sm:flex-row gap-5 items-start">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=400&auto=format&fit=crop&q=80" alt="Artikel 3" class="w-full sm:w-48 h-36 object-cover rounded-2xl shrink-0">
                    <div class="flex-grow space-y-2">
                        <div class="flex items-center gap-3 text-xs text-[#5A4A3A]/70">
                            <span class="bg-[#4C6A73]/10 text-[#4C6A73] font-bold px-2.5 py-0.5 rounded-md">Komunitas</span>
                            <span><i class="fa-regular fa-calendar mr-1"></i> 14 Oktober 2026</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-[#1F3D2E] hover:text-[#4C6A73] transition-colors">
                            Peran Aktif Bank Sampah Kelurahan Dalam Menjaga Lingkungan
                        </h3>
                        <p class="text-xs sm:text-sm text-[#5A4A3A] line-clamp-2">
                            Simak cerita sukses partisipasi masyarakat di tingkat RT yang berhasil menukar limbah plastik bernilai ekonomis melalui program Bank Sampah.
                        </p>
                        <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1F3D2E] hover:text-[#6B7F4E] pt-1">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </article>

            </div>
        </section>

    </main>

    <!-- FOOTER GLOBAL -->
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
    </script>
</body>
</html>