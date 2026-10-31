<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pelaporan TPS Liar - JambiBersih</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Inter & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        #map { z-index: 10; }
    </style>
</head>
<body class="bg-[#DCC8A3]/30 text-[#5A4A3A] antialiased min-h-screen flex flex-col">

    <!-- NAVBAR UTAMA (KONSISTEN DI SEMUA HALAMAN) -->
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

                    <a href="{{ url('/lapor') }}" class="px-3 py-2 rounded-lg text-sm font-semibold text-white bg-white/10 transition-colors">
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

        <!-- Mobile Menu Navigation Panel (Ikon Sudah Diperbaiki) -->
        <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-[#1F3D2E] border-t border-b border-white/10 px-4 pt-3 pb-6 space-y-2 shadow-2xl z-50">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-100 hover:text-white hover:bg-white/10">
                Beranda
            </a>
            <a href="{{ url('/lapor') }}" class="block px-3 py-2 rounded-lg text-base font-semibold text-white bg-white/10">
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

    <!-- FORM SECTION -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto w-full">

        <div class="mb-8 text-center md:text-left">
            <span class="bg-[#6B7F4E]/20 text-[#1F3D2E] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Layanan Pengaduan Masyarakat</span>
            <h1 class="text-3xl font-extrabold text-[#1F3D2E] mt-2">Buat Laporan TPS Liar</h1>
            <p class="text-sm text-[#5A4A3A] mt-1">Isi formulir di bawah ini dengan lengkap untuk mempercepat proses penanganan oleh tim kebersihan.</p>
        </div>

        <form id="form-lapor" onsubmit="submitLaporan(event)" action="#" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-[#5A4A3A]/15 space-y-8 relative z-10">
            @csrf

            <!-- 1. UNGGAH FOTO BUKTI -->
            <div>
                <label class="block text-sm font-bold text-[#1F3D2E] mb-2">
                    Foto Bukti Sampah Liar <span class="text-red-500">*</span>
                </label>

                <!-- Area Klik untuk Membuka Modal Pilihan -->
                <div id="drop-area" onclick="openFotoModal()" class="border-2 border-dashed border-[#5A4A3A]/30 rounded-2xl p-6 text-center hover:border-[#6B7F4E] transition-colors bg-[#DCC8A3]/10 cursor-pointer block relative overflow-hidden h-48 flex flex-col justify-center items-center">
                    <div id="preview-container" class="absolute inset-0 hidden">
                        <img id="image-preview" src="" alt="Preview Bukti" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <i class="fa-solid fa-camera-rotate text-white text-2xl mb-2"></i>
                            <span class="text-white text-xs font-bold">Ganti Foto</span>
                        </div>
                    </div>

                    <div id="default-content">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#6B7F4E] mb-3"></i>
                        <p class="text-sm font-semibold text-[#1F3D2E]">Klik di sini untuk unggah foto</p>
                        <p class="text-xs text-[#5A4A3A]/70 mt-1">Format: JPG, PNG, JPEG (Maksimal 5MB)</p>
                    </div>
                </div>

                <!-- 2 Input File Tersembunyi (Satu untuk Kamera, Satu untuk Galeri) -->
                <input type="file" id="input-kamera" accept="image/*" capture="environment" class="hidden" onchange="handleFotoSelected(event)">
                <input type="file" id="input-galeri" name="foto" accept="image/*" class="hidden" onchange="handleFotoSelected(event)" required>
            </div>

            <!-- 2. TITIK LOKASI PETA & PATOKAN -->
            <div class="space-y-4">
                <label class="block text-sm font-bold text-[#1F3D2E]">
                    Titik Lokasi Kejadian (Peta) <span class="text-red-500">*</span>
                </label>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button id="btn-gps" type="button" class="bg-[#4C6A73] hover:bg-[#1F3D2E] text-white text-xs font-bold px-4 py-3 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm shrink-0">
                        <i class="fa-solid fa-location-crosshairs text-sm"></i>
                        <span>Deteksi GPS Saya</span>
                    </button>
                    <input type="text" id="input-koordinat" name="koordinat" wire:model.defer="koordinat" placeholder="Geser pin peta atau klik Deteksi GPS..." class="w-full bg-[#DCC8A3]/20 border border-[#5A4A3A]/20 rounded-xl px-4 py-2.5 text-xs text-[#5A4A3A] font-semibold focus:outline-none focus:border-[#1F3D2E]" readonly required>
                </div>

                <!-- WADAH PETA LEAFLET DENGAN wire:ignore -->
                <div wire:ignore id="map" class="w-full h-[300px] rounded-xl border border-slate-300 shadow-inner"></div>
                <p class="text-[11px] text-[#5A4A3A]/70 italic mt-1">*Geser pin warna biru pada peta ke titik lokasi tumpukan sampah yang tepat.</p>

                <div class="pt-2">
                    <input type="text" name="alamat_detail" wire:model="alamat_detail" placeholder="Alamat / Patokan Lokasi (Misal: Samping pos ronda RT 03)" class="w-full border border-[#5A4A3A]/20 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#6B7F4E]" required>
                </div>
            </div>

            <!-- 3. CATATAN TAMBAHAN -->
            <div>
                <label class="block text-sm font-bold text-[#1F3D2E] mb-2">
                    Keterangan Tambahan (Opsional)
                </label>
                <textarea name="deskripsi" wire:model="deskripsi" rows="3" placeholder="Tambahkan rincian jenis sampah (plastik/puing/bau menyengat)..." class="w-full border border-[#5A4A3A]/20 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#6B7F4E]"></textarea>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="pt-4 border-t border-slate-100">
                <button type="submit" class="w-full bg-[#6B7F4E] hover:bg-[#1F3D2E] text-white font-bold text-base py-4 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 active:scale-95">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                    <span>Kirim Laporan TPS Liar</span>
                </button>
            </div>

        </form>
    </main>

    <!-- MODAL POPUP SUKSES (KODE TIKET OTOMATIS) -->
    <div id="modal-sukses" class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4 animate-fadeIn">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 text-center shadow-2xl border border-gray-100 relative">

            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-circle-check text-3xl"></i>
            </div>

            <h3 class="text-2xl font-extrabold text-[#1F3D2E]">Laporan Berhasil Terkirim!</h3>
            <p class="text-xs text-[#5A4A3A] mt-2">Terima kasih atas laporan Anda. Gunakan kode tiket di bawah ini untuk memantau status pembersihan:</p>

            <!-- TIKET BOX -->
            <div class="bg-[#FFFAE8] border-2 border-dashed border-[#6B7F4E] rounded-2xl p-4 my-6 flex items-center justify-between gap-3">
                <span id="output-kode-tiket" class="text-lg font-black text-[#1F3D2E] tracking-wider">TPS-20261028-XYZ</span>
                <button type="button" onclick="copyTicketCode()" class="text-xs bg-[#1F3D2E] text-white hover:bg-[#4C6A73] font-bold px-3 py-2 rounded-xl transition-colors shrink-0 flex items-center gap-1.5">
                    <i class="fa-regular fa-copy"></i>
                    <span id="copy-text">Salin Tiket</span>
                </button>
            </div>

            <div class="flex flex-col gap-3">
                <a href="{{ url('/lacak#cari-tiket') }}" class="w-full bg-[#1F3D2E] hover:bg-[#4C6A73] text-white font-bold py-3.5 rounded-2xl text-xs transition-colors shadow-md">
                    Lacak Status Penanganan
                </a>
                <button type="button" onclick="closeSuccessModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-[#5A4A3A] font-bold py-3.5 rounded-2xl text-xs transition-colors">
                    Buat Laporan Baru
                </button>
            </div>

        </div>
    </div>

    <!-- MODAL PILIHAN KAMERA / GALERI -->
    <div id="modal-pilihan-foto" class="fixed inset-0 z-[110] bg-black/60 backdrop-blur-sm hidden flex items-end sm:items-center justify-center p-4 animate-fadeIn">
        <div class="bg-white rounded-t-3xl sm:rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-gray-100 space-y-4">
            <h4 class="text-base font-bold text-[#1F3D2E]">Pilih Sumber Foto</h4>
            <p class="text-xs text-[#5A4A3A]">Ambil foto langsung dari lokasi atau pilih dari memori HP:</p>

            <div class="grid grid-cols-2 gap-3 pt-2">
                <!-- Tombol Kamera -->
                <button type="button" onclick="pilihKamera()" class="p-4 bg-[#6B7F4E]/10 hover:bg-[#6B7F4E] text-[#1F3D2E] hover:text-white rounded-2xl flex flex-col items-center gap-2 font-bold text-xs transition-colors group">
                    <i class="fa-solid fa-camera text-2xl text-[#6B7F4E] group-hover:text-white transition-colors"></i>
                    <span>Kamera</span>
                </button>
                <!-- Tombol Galeri -->
                <button type="button" onclick="pilihGaleri()" class="p-4 bg-[#4C6A73]/10 hover:bg-[#4C6A73] text-[#1F3D2E] hover:text-white rounded-2xl flex flex-col items-center gap-2 font-bold text-xs transition-colors group">
                    <i class="fa-solid fa-images text-2xl text-[#4C6A73] group-hover:text-white transition-colors"></i>
                    <span>Galeri / File</span>
                </button>
            </div>

            <button type="button" onclick="closeFotoModal()" class="w-full text-xs text-gray-400 font-semibold py-2 hover:text-gray-600">
                Batal
            </button>
        </div>
    </div>

    <!-- FOOTER SEDERHANA -->
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

    <!-- SCRIPT INTERAKSI LEAFLET & MODAL -->
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

        async function submitLaporan(e) {
            e.preventDefault();

            const form = document.getElementById('form-lapor');
            const submitButton = form.querySelector('button[type="submit"]');
            const submitText = submitButton.querySelector('span');
            const koordinat = document.getElementById('input-koordinat').value.trim();

            if (!koordinat) {
                alert('Tentukan lokasi TPS liar terlebih dahulu melalui peta atau GPS.');
                return;
            }

            const parts = koordinat.split(',').map(value => value.trim());
            const lat = Number(parts[0]);
            const lng = Number(parts[1]);

            if (
                parts.length !== 2 ||
                parts.some(value => value === '') ||
                !Number.isFinite(lat) ||
                !Number.isFinite(lng) ||
                lat < -90 || lat > 90 ||
                lng < -180 || lng > 180
            ) {
                alert('Koordinat lokasi tidak valid. Silakan tentukan ulang lokasi pada peta.');
                return;
            }

            const formData = new FormData(form);
            formData.delete('koordinat');
            formData.delete('alamat_detail');
            formData.set('lat', String(lat));
            formData.set('lng', String(lng));

            submitButton.disabled = true;
            submitText.textContent = 'Mengirim laporan...';

            try {
                const response = await fetch('/laporan', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const result = await response.json();

                if (!response.ok) {
                    const errors = result.errors
                        ? Object.values(result.errors).flat().join('\n')
                        : result.message || 'Laporan gagal dikirim.';

                    throw new Error(errors);
                }

                document.getElementById('output-kode-tiket').innerText =
                    result.data.kode_tiket;

                document.getElementById('modal-sukses').classList.remove('hidden');
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.');
            } finally {
                submitButton.disabled = false;
                submitText.textContent = 'Kirim Laporan TPS Liar';
            }
        }

        function copyTicketCode() {
            const code = document.getElementById('output-kode-tiket').innerText;
            navigator.clipboard.writeText(code);
            document.getElementById('copy-text').innerText = 'Tersalin!';
            setTimeout(() => {
                document.getElementById('copy-text').innerText = 'Salin Tiket';
            }, 2000);
        }

        function closeSuccessModal() {
            document.getElementById('modal-sukses').classList.add('hidden');
            document.getElementById('form-lapor').reset();
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('default-content').classList.remove('hidden');
        }

        document.addEventListener("DOMContentLoaded", function () {
            // --- INISIALISASI PETA LEAFLET ---
            let defaultLat = -1.6101;
            let defaultLng = 103.6131;

            const map = L.map('map').setView([defaultLat, defaultLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);
            const inputKoordinat = document.getElementById('input-koordinat');

            function updateInputLocation(lat, lng) {
                inputKoordinat.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                inputKoordinat.dispatchEvent(new Event('input'));
            }

            updateInputLocation(defaultLat, defaultLng);

            marker.on('dragend', function (e) {
                const position = marker.getLatLng();
                updateInputLocation(position.lat, position.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateInputLocation(e.latlng.lat, e.latlng.lng);
            });

            // --- DETEKSI GPS ---
            const btnGps = document.getElementById('btn-gps');
            btnGps.addEventListener('click', function() {
                const originalText = btnGps.innerHTML;
                btnGps.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-sm"></i><span>Mencari Lokasi...</span>';
                btnGps.disabled = true;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const userLat = position.coords.latitude;
                            const userLng = position.coords.longitude;
                            map.setView([userLat, userLng], 16);
                            marker.setLatLng([userLat, userLng]);
                            updateInputLocation(userLat, userLng);

                            btnGps.innerHTML = '<i class="fa-solid fa-check text-sm text-green-300"></i><span>GPS Ditemukan</span>';
                            btnGps.classList.replace('bg-[#4C6A73]', 'bg-[#1F3D2E]');
                            btnGps.disabled = false;
                        },
                        function(error) {
                            alert("Gagal mengakses GPS. Pastikan izin lokasi diaktifkan.");
                            btnGps.innerHTML = originalText;
                            btnGps.disabled = false;
                        },
                        { enableHighAccuracy: true }
                    );
                } else {
                    alert("Browser tidak mendukung Geolokasi.");
                    btnGps.innerHTML = originalText;
                    btnGps.disabled = false;
                }
            });
        });

        // --- FUNGSI KONTROL MODAL FOTO ---
        function openFotoModal() {
            document.getElementById('modal-pilihan-foto').classList.remove('hidden');
        }

        function closeFotoModal() {
            document.getElementById('modal-pilihan-foto').classList.add('hidden');
        }

        function pilihKamera() {
            closeFotoModal();
            document.getElementById('input-kamera').click();
        }

        function pilihGaleri() {
            closeFotoModal();
            document.getElementById('input-galeri').click();
        }

        // --- HANDLER PREVIEW FOTO ---
        function handleFotoSelected(event) {
            const file = event.target.files[0];
            if (file) {
                if (event.target.id === 'input-kamera') {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('input-galeri').files = dataTransfer.files;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('default-content').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>