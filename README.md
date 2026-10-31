# JambiBersih

## Tentang JambiBersih

**JambiBersih** adalah aplikasi berbasis web yang dikembangkan untuk mendukung pelaporan, pemantauan, dan penanganan tempat pembuangan sampah (TPS) liar di Kota Jambi.

Aplikasi ini mengintegrasikan pelaporan masyarakat berbasis lokasi dengan sistem pengelolaan laporan oleh petugas. Melalui pemetaan geografis dan pengelompokan laporan berdasarkan kedekatan lokasi, JambiBersih membantu proses identifikasi dan koordinasi penanganan TPS liar secara lebih terstruktur.

Beberapa fitur utama JambiBersih meliputi:

- **Pelaporan TPS Liar** – Masyarakat dapat mengirim laporan disertai deskripsi, foto, dan titik koordinat lokasi.
- **Pemetaan Lokasi** – Menampilkan persebaran laporan dan klaster TPS liar menggunakan peta interaktif.
- **Pengelompokan Laporan** – Mengelompokkan laporan berdasarkan kedekatan geografis untuk mengurangi duplikasi.
- **Manajemen Penanganan** – Mendukung proses verifikasi, disposisi, penugasan, hingga penyelesaian klaster.
- **Monitoring Dashboard** – Menyajikan ringkasan laporan dan progres penanganan berdasarkan hak akses pengguna.
- **Informasi dan Edukasi** – Menyediakan informasi pengelolaan sampah, edukasi lingkungan, serta jadwal penjemputan.

## Hak Akses Pengguna

JambiBersih memiliki beberapa jenis pengguna dengan kewenangan yang berbeda:

- **Masyarakat** – Mengirim laporan TPS liar dan mengakses informasi publik.
- **Operator** – Memverifikasi laporan dan mengelola pengelompokan laporan.
- **Kabid** – Melakukan disposisi klaster.
- **Subkoordinator** – Mengelola penugasan petugas lapangan.
- **Komando Lapangan** – Melaksanakan penanganan dan memperbarui progres pekerjaan.

## Alur Penanganan

Alur penanganan TPS liar dalam JambiBersih:

1. Masyarakat mengirim laporan TPS liar.
2. Operator memeriksa dan memverifikasi laporan.
3. Laporan dikelompokkan menjadi klaster berdasarkan kedekatan lokasi.
4. Kabid melakukan disposisi klaster.
5. Subkoordinator menetapkan petugas lapangan.
6. Komando Lapangan memperbarui progres penanganan.
7. Petugas menyelesaikan penanganan dengan mengunggah dokumentasi foto.

## Teknologi yang Digunakan

Teknologi yang digunakan dalam pengembangan JambiBersih:

- [Laravel](https://laravel.com/) – Backend framework.
- [Filament](https://filamentphp.com/) – Admin panel.
- [PHP](https://www.php.net/) – Backend programming language.
- [Blade](https://laravel.com/docs/blade) – Templating engine.
- [Tailwind CSS](https://tailwindcss.com/) – CSS framework.
- [Alpine.js](https://alpinejs.dev/) – JavaScript framework.
- [Leaflet](https://leafletjs.com/) – Interactive maps.
- [OpenStreetMap](https://www.openstreetmap.org/) – Map tile provider.
- [SQLite](https://www.sqlite.org/) – Database.

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-Framework-red?logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/Filament-Admin%20Panel-F59E0B?logo=filament" alt="Filament">
  <img src="https://img.shields.io/badge/Leaflet-Interactive%20Map-199900?logo=leaflet" alt="Leaflet">
  <img src="https://img.shields.io/badge/Database-SQLite-003B57?logo=sqlite" alt="SQLite">
</p>

## Instalasi dan Menjalankan Proyek

Ikuti langkah berikut untuk menjalankan JambiBersih secara lokal.

### Persyaratan Sistem

- PHP
- Composer
- Node.js dan npm

### Langkah Instalasi

1. Kloning repositori:

   ```bash
   git clone <REPOSITORY_URL>
   cd tps-liar
   ```

2. Instal dependensi:

   ```bash
   composer install
   npm install
   ```

3. Salin file konfigurasi environment::

   ```bash
   cp .env.example .env
   ```

4. Buat application key:

   ```bash
   php artisan key:generate
   ```

5. Konfigurasi database pada file .env, kemudian jalankan migrasi database:

   ```bash
   php artisan migrate
   ```

6. Isi data awal aplikasi:
   ```bash
   php artisan db:seed
   ```

7. Build aset frontend:

   ```bash
   npm run build
   ```

8. Jalankan server aplikasi:

   ```bash
   php artisan serve
   ```

9. Buka aplikasi melalui:

   ```text
   http://127.0.0.1:8000
   ```

## Status Pengembangan

JambiBersih merupakan proyek pengembangan sistem informasi untuk mendukung digitalisasi pelaporan dan penanganan TPS liar di Kota Jambi.