<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Penanganan TPS - SIPAS-LIAR</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Inter & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
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
                        <span class="font-extrabold text-lg tracking-tight leading-none text-white group-hover:text-[#DCC8A3] transition-colors">SIPAS</span>
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

                    <a href="{{ url('/lacak') }}" class="px-3 py-2 rounded-lg text-sm font-semibold text-white bg-white/10 transition-colors">
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
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ url('/edukasi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
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
                    <button type="button" onclick="toggleMobileMenu()" class="p-2 rounded-lg text-emerald-100 hover:text-white hover:bg-white/10 focus:outline-none">
                        <i id="hamburger-icon" class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Navigation Panel -->
        <div id="mobile-menu" class="hidden md:hidden bg-[#1F3D2E] border-t border-white/10 px-4 pt-3 pb-6 space-y-2">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Beranda
            </a>
            <a href="{{ url('/lapor') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Lapor TPS
            </a>
            <a href="{{ url('/lacak') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-white bg-white/10">
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
                <a href="{{ url('/edukasi') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="text-[#DCC8A3]"></i>
                    <span>Edukasi</span>
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT HALAMAN LACAK -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto w-full">
        
        <!-- HEADER HALAMAN -->
        <div class="text-center mb-8">
            <span class="bg-[#4C6A73]/20 text-[#1F3D2E] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Pemantauan Laporan Warga</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F3D2E] mt-3">Cek Penanganan TPS Liar</h1>
            <p class="text-sm text-[#5A4A3A] mt-2 max-w-lg mx-auto">Cari kode tiket pelaporan Anda atau klik tanda panah pada tabel untuk melihat riwayat penanganan lokasi secara detail.</p>
        </div>

        <!-- FORM PENCARIAN TIKET -->
        <div class="bg-white rounded-3xl p-6 shadow-lg border border-[#5A4A3A]/15 relative z-10 mb-8">
            <form id="search-form" onsubmit="searchTicket(event)" class="flex flex-col sm:flex-row gap-4">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-[#5A4A3A]/50"></i>
                    </div>
                    <input type="text" id="ticket-search-input" placeholder="Masukkan Kode Tiket (Contoh: TPS-20261028-XYZ)" 
                        class="w-full pl-11 pr-4 py-3.5 bg-[#FFFAE8]/50 border border-[#5A4A3A]/20 rounded-2xl text-sm font-medium text-[#1F3D2E] focus:outline-none focus:ring-2 focus:ring-[#6B7F4E] transition-all" required>
                </div>
                <button type="submit" class="bg-[#1F3D2E] hover:bg-[#4C6A73] text-white font-bold px-8 py-3.5 rounded-2xl shadow-md transition-colors flex items-center justify-center gap-2 shrink-0">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Cari Tiket</span>
                </button>
            </form>
        </div>

        <!-- TABEL DAFTAR PELAPORAN (ACCORDION STYLED) -->
        <div class="bg-white rounded-3xl shadow-xl border border-[#5A4A3A]/15 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    
                    <thead>
                        <tr class="bg-[#1F3D2E] text-white text-xs uppercase tracking-wider font-semibold">
                            <th class="py-4 px-6">Tanggal Lapor</th>
                            <th class="py-4 px-6">Lokasi Kejadian</th>
                            <th class="py-4 px-6">Status Terakhir</th>
                            <th class="py-4 px-6 text-center">Detail Penanganan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm font-medium text-[#5A4A3A]">

                        <!-- CONTOH 1: STATUS DALAM PROSES -->
                        <tr class="report-row hover:bg-[#DCC8A3]/10 cursor-pointer transition-colors" data-ticket="TPS-20261028-XYZ" onclick="toggleAccordion('detail-1', 'arrow-1')">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-bold text-[#1F3D2E]">28 Okt 2026</div>
                                <div class="text-[11px] text-[#5A4A3A]/70">08:30 WIB</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-[#1F3D2E]">Samping Pos Ronda RT 03</div>
                                <div class="text-xs text-[#5A4A3A]/70">Kel. Dahlan, Kec. Sukajadi</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="bg-blue-100 text-blue-800 border border-blue-200 text-xs font-bold px-3 py-1 rounded-full inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-spinner fa-spin text-[10px]"></i> Dalam Proses
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button type="button" class="w-8 h-8 rounded-full bg-[#DCC8A3]/30 text-[#1F3D2E] inline-flex items-center justify-center hover:bg-[#6B7F4E] hover:text-white transition-all">
                                    <i id="arrow-1" class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- DETAIL ACCORDION CONTOH 1 -->
                        <tr id="detail-1" class="hidden bg-[#FFFAE8]/40 border-b border-gray-200">
                            <td colspan="4" class="p-6">
                                <div class="bg-white p-6 rounded-2xl border border-[#5A4A3A]/10 shadow-inner">
                                    <h4 class="text-xs font-extrabold text-[#1F3D2E] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                                        <i class="fa-solid fa-route text-[#6B7F4E] mr-1.5"></i> Riwayat Penanganan Laporan
                                    </h4>

                                    <div class="relative border-l-2 border-[#6B7F4E]/30 ml-3 space-y-6">
                                        <!-- 1. Laporan Masuk -->
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-[#6B7F4E]"></div>
                                            <p class="text-[11px] text-[#5A4A3A]/70 font-semibold">28 Okt 2026, 08:30 WIB</p>
                                            <h5 class="text-xs font-bold text-[#1F3D2E]">Laporan Masuk</h5>
                                            <p class="text-xs text-[#5A4A3A] mt-0.5">Laporan berhasil dikirim oleh warga dan tercatat di sistem.</p>
                                        </div>

                                        <!-- 2. Menunggu -->
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-[#6B7F4E]"></div>
                                            <p class="text-[11px] text-[#5A4A3A]/70 font-semibold">28 Okt 2026, 09:00 WIB</p>
                                            <h5 class="text-xs font-bold text-[#1F3D2E]">Menunggu</h5>
                                            <p class="text-xs text-[#5A4A3A] mt-0.5">Menunggu verifikasi berkas dan keabsahan titik lokasi oleh admin DLH.</p>
                                        </div>

                                        <!-- 3. Dalam Proses (Aktif) -->
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[10px] top-0.5 w-5 h-5 rounded-full bg-[#4C6A73] ring-4 ring-[#4C6A73]/20 flex items-center justify-center">
                                                <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
                                            </div>
                                            <p class="text-[11px] text-[#4C6A73] font-bold">28 Okt 2026, 10:15 WIB</p>
                                            <h5 class="text-xs font-bold text-[#4C6A73]">Dalam Proses</h5>
                                            <p class="text-xs text-[#5A4A3A] mt-0.5">Tim armada kebersihan sedang melakukan pengangkutan sampah di lokasi.</p>
                                        </div>

                                        <!-- 4. Selesai (Belum) -->
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-gray-300"></div>
                                            <h5 class="text-xs font-semibold text-gray-400">Selesai</h5>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- CONTOH 2: STATUS SELESAI -->
                        <tr class="report-row hover:bg-[#DCC8A3]/10 cursor-pointer transition-colors" data-ticket="TPS-20261027-ABC" onclick="toggleAccordion('detail-2', 'arrow-2')">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-bold text-[#1F3D2E]">27 Okt 2026</div>
                                <div class="text-[11px] text-[#5A4A3A]/70">14:15 WIB</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-[#1F3D2E]">Lahan Kosong Depan Pasar Minggu</div>
                                <div class="text-xs text-[#5A4A3A]/70">Kel. Senapelan, Kec. Senapelan</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-bold px-3 py-1 rounded-full inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Selesai
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button type="button" class="w-8 h-8 rounded-full bg-[#DCC8A3]/30 text-[#1F3D2E] inline-flex items-center justify-center hover:bg-[#6B7F4E] hover:text-white transition-all">
                                    <i id="arrow-2" class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- DETAIL ACCORDION CONTOH 2 -->
                        <tr id="detail-2" class="hidden bg-[#FFFAE8]/40 border-b border-gray-200">
                            <td colspan="4" class="p-6">
                                <div class="bg-white p-6 rounded-2xl border border-[#5A4A3A]/10 shadow-inner">
                                    
                                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                                        <h4 class="text-xs font-extrabold text-[#1F3D2E] uppercase tracking-wider flex items-center gap-2">
                                            <i class="fa-solid fa-route text-[#6B7F4E]"></i> Riwayat Penanganan Laporan
                                        </h4>
                                        <span class="text-[11px] bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded-full font-bold">
                                            <i class="fa-solid fa-[#6B7F4E] fa-[#6B7F4E]"></i> Penanganan Tuntas
                                        </span>
                                    </div>

                                    <!-- TIMELINE STATUS -->
                                    <div class="relative border-l-2 border-[#6B7F4E] ml-3 space-y-6 mb-6">
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-[#6B7F4E]"></div>
                                            <p class="text-[11px] text-[#5A4A3A]/70 font-semibold">27 Okt 2026, 14:15 WIB</p>
                                            <h5 class="text-xs font-bold text-[#1F3D2E]">Laporan Masuk</h5>
                                        </div>
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-[#6B7F4E]"></div>
                                            <p class="text-[11px] text-[#5A4A3A]/70 font-semibold">27 Okt 2026, 14:45 WIB</p>
                                            <h5 class="text-xs font-bold text-[#1F3D2E]">Menunggu Verifikasi</h5>
                                        </div>
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-[#6B7F4E]"></div>
                                            <p class="text-[11px] text-[#5A4A3A]/70 font-semibold">27 Okt 2026, 15:30 WIB</p>
                                            <h5 class="text-xs font-bold text-[#1F3D2E]">Dalam Proses Pembersihan</h5>
                                        </div>
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-emerald-600 ring-4 ring-emerald-100"></div>
                                            <p class="text-[11px] text-emerald-700 font-extrabold">27 Okt 2026, 17:00 WIB</p>
                                            <h5 class="text-xs font-bold text-emerald-800">Selesai Dibersihkan</h5>
                                            <p class="text-xs text-[#5A4A3A] mt-0.5">Lokasi telah dibersihkan sepenuhnya oleh Tim Regu 2 DLH Jambi dan diangkut ke TPA.</p>
                                        </div>
                                    </div>

                                    <!-- SECTION BUKTI FOTO HASIL LAPANGAN (MARKETPLACE STYLE) -->
                                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <h5 class="text-xs font-bold text-[#1F3D2E] uppercase tracking-wider flex items-center gap-2">
                                                <i class="fa-solid fa-camera text-[#6B7F4E]"></i> Foto Bukti Lapangan Petugas
                                            </h5>
                                            <span class="text-[10px] text-gray-500 font-medium">*Klik gambar untuk memperbesar</span>
                                        </div>

                                        <!-- GALLERY THUMBNAIL -->
                                        <div class="flex gap-3 overflow-x-auto pb-1">         
                                
                                            <!-- FOTO 1: LOKASI SESUDAH (BERSIH) -->
                                            <div class="relative group shrink-0 cursor-pointer overflow-hidden rounded-xl border-2 border-emerald-300 shadow-sm hover:shadow-md transition-all"
                                                onclick="openPhotoModal('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=800&auto=format&fit=crop&q=80', 'Foto Kanan: Lokasi Telah Bersih Rapi Tuntas (Sesudah Pembersihan)')">
                                                <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?w=300&auto=format&fit=crop&q=80" alt="Sesudah" class="w-24 h-24 sm:w-28 sm:h-28 object-cover group-hover:scale-105 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white text-xs font-semibold gap-1">
                                                    <i class="fa-solid fa-magnifying-glass-plus text-base"></i>
                                                    <span class="text-[10px]">Lihat Foto</span>
                                                </div>
                                                <span class="absolute top-1.5 left-1.5 bg-emerald-700/90 text-white text-[9px] font-bold px-2 py-0.5 rounded-md shadow">
                                                    Sesudah (Bersih)
                                                </span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>

                        <!-- CONTOH 3: STATUS DITOLAK (DENGAN ALASAN) -->
                        <tr class="report-row hover:bg-[#DCC8A3]/10 cursor-pointer transition-colors" data-ticket="TPS-20261026-REJ" onclick="toggleAccordion('detail-3', 'arrow-3')">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-bold text-[#1F3D2E]">26 Okt 2026</div>
                                <div class="text-[11px] text-[#5A4A3A]/70">11:00 WIB</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-[#1F3D2E]">Jalan Lintas Lorong 5</div>
                                <div class="text-xs text-[#5A4A3A]/70">Kel. Telanaipura, Kec. Telanaipura</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="bg-red-100 text-red-800 border border-red-200 text-xs font-bold px-3 py-1 rounded-full inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-xmark text-[10px]"></i> Ditolak
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button type="button" class="w-8 h-8 rounded-full bg-[#DCC8A3]/30 text-[#1F3D2E] inline-flex items-center justify-center hover:bg-[#6B7F4E] hover:text-white transition-all">
                                    <i id="arrow-3" class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- DETAIL ACCORDION CONTOH 3 (DITOLAK) -->
                        <tr id="detail-3" class="hidden bg-[#FFFAE8]/40 border-b border-gray-200">
                            <td colspan="4" class="p-6">
                                <div class="bg-white p-6 rounded-2xl border border-[#5A4A3A]/10 shadow-inner">
                                    <h4 class="text-xs font-extrabold text-[#1F3D2E] uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">
                                        <i class="fa-solid fa-route text-red-600 mr-1.5"></i> Riwayat Penanganan Laporan
                                    </h4>

                                    <div class="relative border-l-2 border-red-300 ml-3 space-y-6 mb-6">
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-[#6B7F4E]"></div>
                                            <p class="text-[11px] text-[#5A4A3A]/70 font-semibold">26 Okt 2026, 11:00 WIB</p>
                                            <h5 class="text-xs font-bold text-[#1F3D2E]">Laporan Masuk</h5>
                                        </div>
                                        <div class="relative pl-6">
                                            <div class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-red-600"></div>
                                            <p class="text-[11px] text-red-600 font-semibold">26 Okt 2026, 13:20 WIB</p>
                                            <h5 class="text-xs font-bold text-red-700">Laporan Ditolak</h5>
                                        </div>
                                    </div>

                                    <!-- BOX ALASAN PENOLAKAN -->
                                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg mt-0.5"></i>
                                        <div>
                                            <h5 class="text-xs font-bold text-red-800 uppercase tracking-wider">Alasan Penolakan:</h5>
                                            <p class="text-xs text-red-700 mt-1">
                                                Foto bukti tumpukan sampah tidak jelas / titik koordinat berada di luar wilayah kewenangan operasional Dinas Lingkungan Hidup Kota Jambi. Silakan buat laporan ulang dengan foto lokasi yang lebih akurat.
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- MODAL POPUP PREVIEW FOTO -->
    <div id="photo-modal" class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4 animate-fadeIn">
        <div class="relative max-w-3xl w-full bg-white rounded-3xl overflow-hidden shadow-2xl">
            <!-- Header Modal -->
            <div class="flex items-center justify-between p-4 bg-[#1F3D2E] text-white">
                <span id="modal-caption" class="text-xs font-bold tracking-wide">Bukti Foto Penanganan</span>
                <button onclick="closePhotoModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <!-- Gambar Besar -->
            <div class="p-2 bg-black flex justify-center max-h-[75vh]">
                <img id="modal-img" src="" alt="Preview Full" class="max-h-[70vh] w-auto object-contain rounded-xl">
            </div>
        </div>
    </div>

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
                    <a href="{{ url('/lacak') }}" class="hover:text-white transition-colors">Lacak Status</a>
                    <a href="{{ url('/jadwal-opbm') }}" class="hover:text-white transition-colors">Jadwal OPBM</a>
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

    <!-- SCRIPT AKSI INTERAKSI ACCORDION EXCLUSIVE & SEARCH -->
    <script>

        // Fungsi Buka Modal Foto Bukti
        function openPhotoModal(imgSrc, caption) {
            document.getElementById('modal-img').src = imgSrc;
            document.getElementById('modal-caption').innerText = caption;
            document.getElementById('photo-modal').classList.remove('hidden');
        }

        // Fungsi Tutup Modal Foto Bukti
        function closePhotoModal() {
            document.getElementById('photo-modal').classList.add('hidden');
        }
        // Toggle Buka/Tutup Baris Detail Accordion (Hanya 1 Terbuka dalam Satu Waktu)
        function toggleAccordion(detailId, arrowId) {
            const targetDetail = document.getElementById(detailId);
            const targetArrow = document.getElementById(arrowId);
            const isHidden = targetDetail.classList.contains('hidden');

            // 1. Tutup semua detail row lain dan reset semua ikon panah
            document.querySelectorAll('[id^="detail-"]').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('[id^="arrow-"]').forEach(arrow => arrow.classList.remove('rotate-180'));

            // 2. Jika baris yang diklik tadi statusnya tertutup, buka baris tersebut
            if (isHidden) {
                targetDetail.classList.remove('hidden');
                targetArrow.classList.add('rotate-180');
            }
        }

        // Cari Tiket Berdasarkan Kode Tiket Tersembunyi di Attribute data-ticket
        function searchTicket(e) {
            e.preventDefault();
            const query = document.getElementById('ticket-search-input').value.trim().toLowerCase();
            const rows = document.querySelectorAll('.report-row');

            // Reset & tutup semua accordion saat pencarian baru
            document.querySelectorAll('[id^="detail-"]').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('[id^="arrow-"]').forEach(arrow => arrow.classList.remove('rotate-180'));

            rows.forEach(row => {
                const ticketCode = row.getAttribute('data-ticket').toLowerCase();
                const matches = row.getAttribute('onclick').match(/'([^']+)',\s*'([^']+)'/);
                const detailId = matches[1];
                const arrowId = matches[2];
                
                const detailRow = document.getElementById(detailId);
                const arrowIcon = document.getElementById(arrowId);

                if (ticketCode.includes(query)) {
                    row.style.display = '';
                    // Otomatis buka accordion jika kode tiket pas/cocok persis
                    if (query !== '' && ticketCode === query) {
                        detailRow.classList.remove('hidden');
                        arrowIcon.classList.add('rotate-180');
                    }
                } else {
                    row.style.display = 'none';
                }
            });
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