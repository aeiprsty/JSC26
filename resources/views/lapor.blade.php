<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pelaporan TPS Liar - SIPAS-LIAR</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Inter & Font Awesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <!-- Wajib Ada: Leaflet CSS & JS untuk Peta -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Memastikan peta Leaflet tidak menutupi elemen lain (seperti navbar sticky) */
        #map { z-index: 10; } 
    </style>
</head>
<body class="bg-[#DCC8A3]/30 text-[#5A4A3A] antialiased min-h-screen flex flex-col">

    <!-- NAVBAR SEDERHANA -->
    <header class="bg-[#1F3D2E] text-white shadow-md relative z-50">
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
                    <span class="hidden sm:inline">Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </header>

    <!-- FORM SECTION -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto w-full">
        
        <div class="mb-8 text-center md:text-left">
            <span class="bg-[#6B7F4E]/20 text-[#1F3D2E] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Layanan Pengaduan Warga</span>
            <h1 class="text-3xl font-extrabold text-[#1F3D2E] mt-2">Buat Laporan TPS Liar</h1>
            <p class="text-sm text-[#5A4A3A] mt-1">Isi formulir di bawah ini dengan lengkap untuk mempercepat proses penanganan oleh tim kebersihan.</p>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-[#5A4A3A]/15 space-y-8 relative z-10">
            @csrf

            <!-- 1. UNGGAH FOTO BUKTI -->
            <div>
                <label class="block text-sm font-bold text-[#1F3D2E] mb-2">
                    Foto Bukti Sampah Liar <span class="text-red-500">*</span>
                </label>
                <!-- Area Preview Foto ditambahkan id="drop-area" -->
                <label for="foto-input" id="drop-area" class="border-2 border-dashed border-[#5A4A3A]/30 rounded-2xl p-6 text-center hover:border-[#6B7F4E] transition-colors bg-[#DCC8A3]/10 cursor-pointer block relative overflow-hidden h-48 flex flex-col justify-center items-center">
                    
                    <!-- Tempat Tampilan Gambar -->
                    <div id="preview-container" class="absolute inset-0 hidden">
                        <img id="image-preview" src="" alt="Preview Bukti" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <i class="fa-solid fa-camera-rotate text-white text-2xl mb-2"></i>
                            <span class="text-white text-xs font-bold">Ganti Foto</span>
                        </div>
                    </div>

                    <!-- Tampilan Awal (Ikon Awan) -->
                    <div id="default-content">
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-[#6B7F4E] mb-3"></i>
                        <p class="text-sm font-semibold text-[#1F3D2E]">Klik atau tarik foto ke area ini</p>
                        <p class="text-xs text-[#5A4A3A]/70 mt-1">Format: JPG, PNG, JPEG (Maksimal 5MB)</p>
                    </div>

                    <input type="file" name="foto" class="hidden" id="foto-input" accept="image/*" required>
                </label>
            </div>

            <!-- 2. TITIK LOKASI PETA & PATOKAN -->
            <div class="space-y-4">
                <label class="block text-sm font-bold text-[#1F3D2E]">
                    Titik Lokasi Kejadian (Peta) <span class="text-red-500">*</span>
                </label>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Tombol GPS ditambahkan id="btn-gps" -->
                    <button id="btn-gps" type="button" class="bg-[#4C6A73] hover:bg-[#1F3D2E] text-white text-xs font-bold px-4 py-3 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm shrink-0">
                        <i class="fa-solid fa-location-crosshairs text-sm"></i>
                        <span>Deteksi GPS Saya</span>
                    </button>
                    <!-- Input Koordinat ditambahkan id="input-koordinat" -->
                    <input type="text" id="input-koordinat" name="koordinat" placeholder="Geser pin peta atau klik Deteksi GPS..." class="w-full bg-[#DCC8A3]/20 border border-[#5A4A3A]/20 rounded-xl px-4 py-2.5 text-xs text-[#5A4A3A] font-semibold focus:outline-none focus:border-[#1F3D2E]" readonly required>
                </div>

                <!-- WADAH PETA LEAFLET (Tinggi 300px agar responsif) -->
                <div id="map" class="w-full h-[300px] rounded-xl border border-slate-300 shadow-inner"></div>
                <p class="text-[11px] text-[#5A4A3A]/70 italic mt-1">*Geser pin warna biru pada peta ke titik lokasi tumpukan sampah yang tepat.</p>

                <div class="pt-2">
                    <input type="text" name="alamat_detail" placeholder="Alamat / Patokan Lokasi (Misal: Samping pos ronda RT 03)" class="w-full border border-[#5A4A3A]/20 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#6B7F4E]" required>
                </div>
            </div>

            <!-- 3. CATATAN TAMBAHAN -->
            <div>
                <label class="block text-sm font-bold text-[#1F3D2E] mb-2">
                    Keterangan Tambahan (Opsional)
                </label>
                <textarea name="deskripsi" rows="3" placeholder="Tambahkan rincian jenis sampah (plastik/puing/bau menyengat)..." class="w-full border border-[#5A4A3A]/20 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#6B7F4E]"></textarea>
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

    <!-- FOOTER SIMPLE -->
    <footer class="bg-[#1F3D2E] text-white py-6 text-center text-xs mt-auto relative z-50">
        <p>&copy; 2026 Dinas Lingkungan Hidup. Hak Cipta Dilindungi Undang-Undang.</p>
    </footer>

    <!-- ============================================== -->
    <!-- SCRIPT JAVASCRIPT UNTUK INTERAKSI FORM & PETA  -->
    <!-- ============================================== -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // -----------------------------------------------------
            // 1. LOGIC PREVIEW GAMBAR (UPLOAD FOTO)
            // -----------------------------------------------------
            const fotoInput = document.getElementById('foto-input');
            const previewContainer = document.getElementById('preview-container');
            const defaultContent = document.getElementById('default-content');
            const imagePreview = document.getElementById('image-preview');

            fotoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                        defaultContent.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // -----------------------------------------------------
            // 2. LOGIC PETA (LEAFLET.JS)
            // -----------------------------------------------------
            // Titik awal peta default di tengah Kota Jambi
            let defaultLat = -1.6101;
            let defaultLng = 103.6131;
            
            // Inisialisasi Peta
            const map = L.map('map').setView([defaultLat, defaultLng], 13);
            
            // Pasang Tile / Gambar Peta dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Pasang Pin (Marker) yang bisa ditarik/digeser (draggable)
            const marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);
            
            // Hubungkan input text dengan Peta
            const inputKoordinat = document.getElementById('input-koordinat');
            
            // Fungsi untuk update input text saat posisi pin berubah
            function updateInputLocation(lat, lng) {
                // Tampilkan format Latitude, Longitude ke input text
                inputKoordinat.value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            }

            // Set nilai awal koordinat ke input saat halaman pertama kali load
            updateInputLocation(defaultLat, defaultLng);

            // Aksi saat Pin (Marker) ditarik/digeser
            marker.on('dragend', function (e) {
                const position = marker.getLatLng();
                updateInputLocation(position.lat, position.lng);
            });

            // Aksi saat peta diklik (Pin langsung pindah ke titik klik)
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateInputLocation(e.latlng.lat, e.latlng.lng);
            });

            // -----------------------------------------------------
            // 3. LOGIC TOMBOL DETEKSI GPS BROWSER
            // -----------------------------------------------------
            const btnGps = document.getElementById('btn-gps');
            
            btnGps.addEventListener('click', function() {
                // Ganti teks tombol saat memproses
                const originalText = btnGps.innerHTML;
                btnGps.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-sm"></i><span>Mencari Lokasi...</span>';
                btnGps.disabled = true;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        // Jika Berhasil Menemukan Lokasi Pengguna
                        function(position) {
                            const userLat = position.coords.latitude;
                            const userLng = position.coords.longitude;
                            
                            // Geser Peta dan Pin ke lokasi pengguna
                            map.setView([userLat, userLng], 16); // Zoom lebih dekat (level 16)
                            marker.setLatLng([userLat, userLng]);
                            updateInputLocation(userLat, userLng);

                            // Kembalikan status tombol
                            btnGps.innerHTML = '<i class="fa-solid fa-check text-sm text-green-300"></i><span>GPS Ditemukan</span>';
                            btnGps.classList.replace('bg-[#4C6A73]', 'bg-[#1F3D2E]'); // Ubah warna jadi gelap (sukses)
                            btnGps.disabled = false;
                        },
                        // Jika Gagal / Ditolak Akses Lokasinya
                        function(error) {
                            alert("Gagal mengakses GPS. Pastikan izin lokasi (location) pada browser/HP diaktifkan.");
                            btnGps.innerHTML = originalText;
                            btnGps.disabled = false;
                        },
                        { enableHighAccuracy: true } // Minta akurasi tinggi
                    );
                } else {
                    alert("Browser kamu tidak mendukung fitur Geolokasi.");
                    btnGps.innerHTML = originalText;
                    btnGps.disabled = false;
                }
            });

        });
    </script>

</body>
</html>