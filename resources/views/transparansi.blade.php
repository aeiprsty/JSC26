<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparansi Alokasi Dana Iuran - JambiBersih</title>

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
<body class="bg-[#FFFAE8] text-[#5A4A3A] antialiased selection:bg-[#6B7F4E] selection:text-white min-h-screen flex flex-col">

    <!-- NAVBAR / HEADER UTAMA -->
    <header class="sticky top-0 z-50 bg-[#1F3D2E] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo & Branding -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-[#6B7F4E] flex items-center justify-center text-white shadow-lg group-hover:bg-[#4C6A73] transition-colors">
                        <i class="fa-solid fa-leaf text-xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-lg tracking-tight leading-none text-white group-hover:text-[#DCC8A3] transition-colors">JambiBersih</span>
                        <span class="text-[10px] text-[#DCC8A3] font-medium tracking-wider uppercase">Dinas Lingkungan Hidup Kota Jambi</span>
                    </div>
                </a>

                <!-- Navigasi Desktop -->
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

                    <!-- Dropdown Informasi & Edukasi -->
                    <div class="relative group" id="desktop-dropdown">
                        <button class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-semibold text-white bg-white/10 focus:outline-none" onclick="toggleDropdown('desktop-menu')">
                            <span>Informasi & Edukasi</span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180"></i>
                        </button>

                        <div id="desktop-menu" class="hidden group-hover:block absolute right-0 mt-1 w-64 bg-white rounded-xl shadow-xl border border-[#5A4A3A]/10 py-2 text-[#5A4A3A] z-50">
                            <a href="{{ url('/jadwal') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#4C6A73]/10 flex items-center justify-center text-[#4C6A73]">
                                    <i class="fa-solid fa-calendar-alt text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Jadwal OPBM</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Operasi Pembersihan Bersama</div>
                                </div>
                            </a>
                            <a href="{{ url('/transparansi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold bg-[#DCC8A3]/30 text-[#1F3D2E]">
                                <div class="w-8 h-8 rounded-lg bg-[#1F3D2E] flex items-center justify-center text-white">
                                    <i class="fa-solid fa-chart-pie text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-bold">Transparansi Dana</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Rincian Komponen Alokasi</div>
                                </div>
                            </a>
                            <a href="{{ url('/edukasi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium hover:bg-[#DCC8A3]/30 hover:text-[#1F3D2E] transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-[#4C6A73]/10 flex items-center justify-center text-[#4C6A73]">
                                    <i class="fa-solid fa-book-open text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Edukasi & Media</div>
                                    <div class="text-[11px] text-[#5A4A3A]/70">Artikel & Video Edukasi</div>
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

        <!-- Mobile Nav Panel -->
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
                <a href="{{ url('/transparansi') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-white bg-white/10 rounded-lg">
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

    <main class="flex-grow">

        <!-- HERO BANNER -->
        <section class="bg-[#1F3D2E] text-white py-14 lg:py-18 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-[#6B7F4E]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl">
                <span class="inline-flex items-center gap-2 bg-[#6B7F4E]/30 text-[#DCC8A3] border border-[#6B7F4E]/50 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-shield-halved text-[#6B7F4E]"></i> Akuntabilitas Publik
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
                    Transparansi Alokasi Dana Iuran
                </h1>
                <p class="text-sm sm:text-base text-emerald-100/90 mt-3 leading-relaxed">
                    Setiap kontribusi iuran kebersihan masyarakat didistribusikan secara terencana untuk mendukung kelancaran operasional dan pemeliharaan lingkungan Kota Jambi.
                </p>
            </div>
        </section>

        <!-- SECTION 1: PRINSIP PENGELOLAAN DANA -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="p-6 bg-[#FFFAE8]/60 rounded-2xl border border-[#5A4A3A]/10 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#1F3D2E] text-white flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#1F3D2E] text-base">Tepat Sasaran</h3>
                            <p class="text-xs text-[#5A4A3A] mt-1 leading-relaxed">Dana difokuskan penuh pada kebutuhan riil lapangan tanpa alokasi yang tidak relevan.</p>
                        </div>
                    </div>

                    <div class="p-6 bg-[#FFFAE8]/60 rounded-2xl border border-[#5A4A3A]/10 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#6B7F4E] text-white flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#1F3D2E] text-base">Terencana & Teratur</h3>
                            <p class="text-xs text-[#5A4A3A] mt-1 leading-relaxed">Penyaluran dana dijadwalkan secara sistematis sesuai skala prioritas operasional harian.</p>
                        </div>
                    </div>

                    <div class="p-6 bg-[#FFFAE8]/60 rounded-2xl border border-[#5A4A3A]/10 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#4C6A73] text-white flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#1F3D2E] text-base">Terbuka Bagi Masyarakat</h3>
                            <p class="text-xs text-[#5A4A3A] mt-1 leading-relaxed">Rincian penggunaan disampaikan transparan demi menjaga kepercayaan masyarakat.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- SECTION 2: DAFTAR KOMPONEN PENGGUNAAN IURAN OPBM -->
        <section class="relative py-16 bg-[#FFFAE8]">

            <!-- OVERLAY GRADASI PERBATASAN ATAS (Menyerap warna putih dari section 1) -->
            <div class="absolute top-0 inset-x-0 h-24 bg-gradient-to-b from-white to-transparent pointer-events-none z-0"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span class="bg-[#6B7F4E]/20 text-[#1F3D2E] text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider">
                        Operasional OPBM RT/RW
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F3D2E] mt-3">
                        Daftar Peruntukan Iuran OPBM
                    </h2>
                    <p class="text-sm text-[#5A4A3A] mt-2">
                        Rincian kualitatif alokasi iuran swakelola warga untuk kelancaran penjemputan sampah harian di lingkungan tempat tinggal.
                    </p>
                </div>


                <!-- GRID KARTU KOMPONEN IURAN OPBM -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    @forelse ($informasis as $informasi)
                        <div class="bg-white p-6 rounded-3xl border border-[#5A4A3A]/10 shadow-sm hover:shadow-md transition-shadow space-y-4">

                            <div class="w-14 h-14 rounded-2xl bg-[#1F3D2E]/10 text-[#1F3D2E] flex items-center justify-center text-2xl">
                                <i class="{{ $informasi->ikon ?: 'fa-solid fa-circle-info' }}"></i>
                            </div>

                            <div>
                                <h3 class="font-extrabold text-[#1F3D2E] text-lg">
                                    {{ $informasi->judul }}
                                </h3>

                                <p class="text-xs text-[#5A4A3A] mt-2 leading-relaxed">
                                    {{ $informasi->deskripsi }}
                                </p>
                            </div>

                            @if (!empty($informasi->rincian))
                                <ul class="text-xs text-[#5A4A3A]/80 space-y-1.5 pt-2 border-t border-gray-100">
                                    @foreach ($informasi->rincian as $rincian)
                                        <li class="flex items-center gap-2">
                                            <i class="fa-solid fa-check text-[#6B7F4E]"></i>
                                            {{ $rincian }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    @empty
                        <div class="col-span-full text-center py-10 text-sm text-[#5A4A3A]/70">
                            Belum ada informasi alokasi iuran yang tersedia.
                        </div>
                    @endforelse

                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER UTAMA -->
    <footer class="bg-[#1F3D2E] text-white border-t border-white/10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#6B7F4E] flex items-center justify-center text-white font-bold text-sm">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <div>
                        <span class="font-bold text-base text-white">Sistem Pelaporan TPS Liar</span>
                        <p class="text-xs text-[#DCC8A3]">Layanan Resmi Pengaduan & Informasi Kebersihan Lingkungan</p>
                    </div>
                </div>

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

    <!-- SCRIPT NAVBAR -->
    <script>
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


        document.addEventListener("DOMContentLoaded", function () {
            const observerOptions = {
                root: null,
                threshold: 0.15 // Animasi aktif saat 15% elemen masuk layar
            };

            const scrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Masuk layar: Munculkan
                        entry.target.classList.remove('opacity-0', 'translate-y-10', '-translate-x-10');
                        entry.target.classList.add('opacity-100', 'translate-y-0', 'translate-x-0');
                    } else {
                        // Keluar layar: Sembunyikan kembali agar bisa teranimasi saat di-scroll ulang
                        entry.target.classList.remove('opacity-100', 'translate-y-0', 'translate-x-0');
                        entry.target.classList.add('opacity-0', 'translate-y-10');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach(el => scrollObserver.observe(el));
        });

    </script>
</body>
</html>