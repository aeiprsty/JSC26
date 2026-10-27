<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparansi Iuran OPBM - SIPAS-LIAR</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#DCC8A3]/20 text-[#5A4A3A] antialiased min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <header class="bg-[#1F3D2E] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-[#6B7F4E] flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-leaf text-xl"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-lg tracking-tight text-white">SIPAS-LIAR</span>
                        <span class="text-[10px] text-[#DCC8A3] uppercase">Dinas Lingkungan Hidup</span>
                    </div>
                </a>

                <a href="{{ url('/') }}" class="text-xs sm:text-sm font-semibold text-emerald-100 hover:text-white flex items-center gap-2 bg-white/10 px-4 py-2 rounded-xl transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </header>

    <!-- KONTEN UTAMA TRANSPARANSI OPBM -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto w-full space-y-10">
        
        <!-- HEADER KONTEN -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <span class="bg-[#6B7F4E]/20 text-[#1F3D2E] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                <i class="fa-solid fa-hand-holding-hand mr-1"></i> Pengelolaan Iuran Swadaya Warga
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-[#1F3D2E]">Transparansi Alokasi Iuran OPBM</h1>
            <p class="text-sm sm:text-base text-[#5A4A3A] leading-relaxed">
                Laporan terbuka penggunaan dana iuran warga untuk mendukung kelancaran armada dan petugas operasional penjemputan sampah rutin di pemukiman.
            </p>
        </div>

        <!-- VISUAL ALOKASI UTAMA OPBM -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-[#5A4A3A]/15 space-y-8">
            <div class="border-b border-gray-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-xl font-bold text-[#1F3D2E]">Distribusi Alokasi Operasional</h2>
                    <p class="text-xs text-[#5A4A3A]/70">Porsi penggunaan iuran warga untuk kegiatan rutin OPBM</p>
                </div>
                <span class="text-xs font-semibold text-[#6B7F4E] bg-[#6B7F4E]/10 px-3 py-1.5 rounded-xl self-start sm:self-auto">
                    <i class="fa-solid fa-user-gear mr-1"></i> Dikelola Operator OPBM
                </span>
            </div>

            <!-- GRID 4 ALOKASI DANA OPBM -->
            <div class="grid md:grid-cols-2 gap-6">

                <!-- 1. BBM & Perawatan Bento/Armada -->
                <div class="p-5 rounded-2xl bg-[#DCC8A3]/15 border border-[#5A4A3A]/10 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#1F3D2E] text-[#DCC8A3] flex items-center justify-center font-bold">
                                <i class="fa-solid fa-gas-pump"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">BBM & Servis Armada OPBM</h3>
                                <p class="text-[11px] text-[#5A4A3A]/70">Motor Roda 3 / Bentor Penjemput</p>
                            </div>
                        </div>
                        <span class="text-2xl font-extrabold text-[#1F3D2E]">40%</span>
                    </div>
                    <div class="w-full bg-gray-200 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-[#1F3D2E] h-full rounded-full" style="width: 40%"></div>
                    </div>
                    <p class="text-xs text-[#5A4A3A] leading-relaxed pt-1">
                        Bahan bakar harian armada penjemput sampah dari rumah warga, oli mesin, serta pemeliharaan rutin roda dan rantai kendaraan OPBM.
                    </p>
                </div>

                <!-- 2. Honor & APD Petugas OPBM -->
                <div class="p-5 rounded-2xl bg-[#6B7F4E]/10 border border-[#6B7F4E]/20 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#6B7F4E] text-white flex items-center justify-center font-bold">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">Honor & APD Petugas OPBM</h3>
                                <p class="text-[11px] text-[#5A4A3A]/70">Kesejahteraan & Lapangan</p>
                            </div>
                        </div>
                        <span class="text-2xl font-extrabold text-[#6B7F4E]">35%</span>
                    </div>
                    <div class="w-full bg-gray-200 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-[#6B7F4E] h-full rounded-full" style="width: 35%"></div>
                    </div>
                    <p class="text-xs text-[#5A4A3A] leading-relaxed pt-1">
                        Insentif petugas penjemput rutin, penyediaan sarung tangan tebal, sepatu boots, rompi keselamatan, dan masker pelindung kerja.
                    </p>
                </div>

                <!-- 3. Peralatan Kebersihan & Terpal -->
                <div class="p-5 rounded-2xl bg-[#4C6A73]/10 border border-[#4C6A73]/20 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#4C6A73] text-white flex items-center justify-center font-bold">
                                <i class="fa-solid fa-broom"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">Peralatan Operasional</h3>
                                <p class="text-[11px] text-[#5A4A3A]/70">Perlengkapan Angkut</p>
                            </div>
                        </div>
                        <span class="text-2xl font-extrabold text-[#4C6A73]">15%</span>
                    </div>
                    <div class="w-full bg-gray-200 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-[#4C6A73] h-full rounded-full" style="width: 15%"></div>
                    </div>
                    <p class="text-xs text-[#5A4A3A] leading-relaxed pt-1">
                        Pengadaan terpal penutup bak armada, karung muatan besar, penggaruk sampah, sekop, serta penggantian keranjang angkut yang rusak.
                    </p>
                </div>

                <!-- 4. Kas Darurat Perbaikan Armada -->
                <div class="p-5 rounded-2xl bg-[#5A4A3A]/10 border border-[#5A4A3A]/20 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-[#5A4A3A] text-[#DCC8A3] flex items-center justify-center font-bold">
                                <i class="fa-solid fa-vault"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-[#1F3D2E] text-sm">Kas & Dana Darurat OPBM</h3>
                                <p class="text-[11px] text-[#5A4A3A]/70">Cadangan Perbaikan</p>
                            </div>
                        </div>
                        <span class="text-2xl font-extrabold text-[#5A4A3A]">10%</span>
                    </div>
                    <div class="w-full bg-gray-200 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-[#5A4A3A] h-full rounded-full" style="width: 10%"></div>
                    </div>
                    <p class="text-xs text-[#5A4A3A] leading-relaxed pt-1">
                        Dana simpanan operasional untuk mengantisipasi kerusakan mendadak pada armada atau kondisi darurat di lapangan.
                    </p>
                </div>

            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-[#1F3D2E] text-white py-6 text-center text-xs border-t border-white/10">
        <p>&copy; 2026 Operasi Pembersihan Bersama Masyarakat. Hak Cipta Dilindungi Undang-Undang.</p>
    </footer>

</body>
</html>