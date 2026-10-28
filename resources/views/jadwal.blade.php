<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Penjemputan OPBM - SIPAS-LIAR</title>
    
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
                            <a href="{{ url('/#edukasi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
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
            <a href="{{ url('/lacak') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Cek Penanganan TPS
            </a>
            
            <div class="pt-2 border-t border-white/10">
                <div class="px-3 py-1 text-xs font-semibold text-[#DCC8A3] uppercase tracking-wider">Informasi & Edukasi</div>
                <a href="{{ url('/jadwal') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-white bg-white/10 rounded-lg">
                    <i class="fa-solid fa-calendar-alt text-[#6B7F4E]"></i>
                    <span>Jadwal OPBM</span>
                </a>
                <a href="{{ url('/transparansi') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-chart-pie text-[#4C6A73]"></i>
                    <span>Transparansi Alokasi Dana</span>
                </a>
                <a href="{{ url('/#edukasi') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-100 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="fa-solid fa-book-open text-[#DCC8A3]"></i>
                    <span>Edukasi</span>
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
                <i class="fa-solid fa-truck-ramp-box text-[#6B7F4E]"></i> Operasi Pembersihan Bersama
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F3D2E] mt-3">Jadwal Penjemputan Sampah OPBM</h1>
            <p class="text-sm text-[#5A4A3A] mt-2">Pantau jadwal rutin penjemputan sampah lingkungan oleh armada gerobak motor hijau di wilayah tempat tinggalmu.</p>
        </div>

        <!-- MENU PENCARIAN REAL-TIME DI ATAS TABEL -->
        <div class="bg-white p-5 rounded-3xl shadow-lg border border-[#5A4A3A]/15 mb-8 max-w-2xl mx-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-[#5A4A3A]/50 text-base"></i>
                </div>
                <input type="text" id="opbm-search" onkeyup="filterJadwalOPBM()" 
                       placeholder="Cari berdasarkan nama Kelurahan, Kecamatan, atau RT..." 
                       class="w-full pl-11 pr-4 py-3.5 bg-[#FFFAE8]/50 border border-[#5A4A3A]/20 rounded-2xl text-sm font-medium text-[#1F3D2E] focus:outline-none focus:ring-2 focus:ring-[#6B7F4E] transition-all">
            </div>
        </div>

        <!-- TABEL JADWAL PENJEMPUTAN -->
        <div class="bg-white rounded-3xl shadow-xl border border-[#5A4A3A]/15 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="tabel-jadwal">
                    
                    <!-- HEADERS TABEL -->
                    <thead>
                        <tr class="bg-[#1F3D2E] text-white text-xs uppercase tracking-wider font-semibold">
                            <th class="py-4 px-6">Wilayah / Kelurahan</th>
                            <th class="py-4 px-6">Cakupan Area (RT)</th>
                            <th class="py-4 px-6">Hari Penjemputan</th>
                            <th class="py-4 px-6">Jam Operasional</th>
                        </tr>
                    </thead>

                    <!-- DATA BARIS TABEL -->
                    <tbody class="divide-y divide-gray-100 text-sm font-medium text-[#5A4A3A]">
                        
                        <!-- BARIS 1 -->
                        <tr class="jadwal-row hover:bg-[#DCC8A3]/10 transition-colors">
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
                        <tr class="jadwal-row hover:bg-[#DCC8A3]/10 transition-colors">
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
                        <tr class="jadwal-row hover:bg-[#DCC8A3]/10 transition-colors">
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

            const noMsg = document.getElementById('no-jadwal-msg');
            if (!found) {
                noMsg.classList.remove('hidden');
            } else {
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
</body>
</html>