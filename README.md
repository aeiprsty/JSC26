# JambiBersih

**JambiBersih** adalah aplikasi berbasis web untuk pelaporan, pemantauan, dan penanganan titik pembuangan sampah liar di Kota Jambi. Aplikasi ini dikembangkan sebagai solusi digital untuk membantu masyarakat melaporkan permasalahan sampah serta mendukung koordinasi petugas dalam proses penanganannya.

## Fitur Utama

- **Pelaporan Sampah:** Masyarakat dapat mengirim laporan dengan foto, deskripsi, dan lokasi.
- **Pemetaan Laporan:** Menampilkan lokasi laporan melalui peta interaktif.
- **Smart Priority Clustering:** Mengelompokkan laporan berdasarkan kedekatan lokasi dengan radius 50 meter untuk membantu menentukan prioritas penanganan.
- **Manajemen Laporan:** Memfasilitasi proses verifikasi, penolakan, dan pemantauan status laporan.
- **Manajemen Klaster:** Mendukung proses disposisi dan penugasan klaster kepada petugas lapangan.
- **Pemantauan Penanganan:** Petugas dapat memperbarui progres penanganan dan mengunggah foto bukti penyelesaian.
- **Edukasi Lingkungan:** Menyediakan artikel dan video edukasi mengenai pengelolaan sampah.
- **Jadwal Penjemputan:** Menampilkan informasi jadwal penjemputan sampah.
- **Transparansi Informasi:** Menyediakan informasi terkait pengelolaan sampah.
- **Dashboard Berdasarkan Peran:** Menampilkan informasi dan fitur pengelolaan sesuai hak akses pengguna.
- **Progressive Web App (PWA):** Mendukung instalasi aplikasi melalui browser pada perangkat yang kompatibel.

## Peran Pengguna

JambiBersih memiliki beberapa jenis pengguna dengan hak akses yang berbeda:

| Peran | Tanggung Jawab |
|---|---|
| Masyarakat | Mengirim laporan dan memantau status laporan. |
| Operator | Memverifikasi dan mengelola laporan masyarakat. |
| Kabid | Memeriksa dan memberikan disposisi terhadap klaster. |
| Subkoordinator | Mengatur penugasan klaster kepada petugas lapangan. |
| Komando Lapangan | Menangani klaster dan memperbarui progres penanganan. |

## Alur Penanganan Laporan

1. Masyarakat mengirim laporan sampah melalui aplikasi.
2. Operator memeriksa dan memverifikasi laporan.
3. Laporan yang memenuhi kriteria dikelompokkan menjadi klaster berdasarkan kedekatan lokasi.
4. Kabid memeriksa klaster dan memberikan disposisi.
5. Subkoordinator menetapkan petugas lapangan.
6. Komando Lapangan melakukan penanganan dan memperbarui status pekerjaan.
7. Petugas mengunggah foto bukti setelah penanganan selesai.

## Teknologi yang Digunakan

Teknologi yang digunakan dalam pengembangan JambiBersih:

- [Laravel](https://laravel.com/) – Backend framework.
- [Filament](https://filamentphp.com/) – Admin panel.
- [PHP](https://www.php.net/) – Backend programming language.
- [Blade](https://laravel.com/docs/blade) – Templating engine.
- [Livewire](https://livewire.laravel.com/) – Full-stack framework untuk interaksi dinamis.
- [Tailwind CSS](https://tailwindcss.com/) – CSS framework.
- [Alpine.js](https://alpinejs.dev/) – JavaScript framework.
- [Vite](https://vite.dev/) – Frontend build tool.
- [Leaflet](https://leafletjs.com/) – Interactive maps.
- [OpenStreetMap](https://www.openstreetmap.org/) – Map tile provider.
- [MySQL](https://www.mysql.com/) – Database.
- [Supabase](https://supabase.com/) – Cloud file storage.

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-Framework-red?logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/Filament-Admin%20Panel-F59E0B?logo=filament" alt="Filament">
  <img src="https://img.shields.io/badge/Livewire-Full--Stack%20Framework-FB70A9?logo=livewire" alt="Livewire">
  <img src="https://img.shields.io/badge/Tailwind%20CSS-Framework-06B6D4?logo=tailwindcss" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Leaflet-Interactive%20Map-199900?logo=leaflet" alt="Leaflet">
  <img src="https://img.shields.io/badge/Database-MySQL-003B57?logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/Storage-Supabase-3ECF8E?logo=supabase" alt="Supabase">
</p>

## Persyaratan Sistem

Pastikan perangkat telah memiliki:

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- Database MySQL
- Ekstensi PHP yang dibutuhkan Laravel dan Filament

## Instalasi dan Menjalankan Aplikasi

### 1. Clone Repository

```bash
git clone https://github.com/aeiprsty/JSC26.git
cd JSC26
```

### 2. Instal Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Salin file konfigurasi:

```bash
cp .env.example .env
```

Pada Windows PowerShell, dapat menggunakan:

```powershell
Copy-Item .env.example .env
```

Buat application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Untuk pengembangan lokal, konfigurasi default menggunakan MySQL.

Sesuaikan konfigurasi database pada file .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jambibersih
DB_USERNAME=root
DB_PASSWORD=

Sesuaikan nilai konfigurasi dengan pengaturan MySQL di perangkat masing-masing. Pastikan database jambibersih sudah dibuat sebelum menjalankan migrasi.

### 5. Migrasi dan Seeder

Jalankan migrasi database beserta seeder:

```bash
php artisan migrate --seed
```

Seeder menyediakan akun pengujian untuk masing-masing peran. Akun tersebut ditujukan untuk kebutuhan pengembangan dan pengujian lokal.

### 6. Konfigurasi Supabase Storage

JambiBersih menggunakan Supabase Storage untuk menyimpan file gambar dan foto yang diunggah melalui aplikasi.

Untuk mengaktifkan penyimpanan tersebut, siapkan project Supabase dan bucket penyimpanan, kemudian sesuaikan konfigurasi berikut pada `.env`:

```env
FILESYSTEM_DISK=supabase

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
AWS_ENDPOINT=
AWS_URL=
AWS_USE_PATH_STYLE_ENDPOINT=true
```

Isi nilai konfigurasi berdasarkan kredensial dan pengaturan Supabase Storage masing-masing. Jangan membagikan atau mengunggah kredensial ke repository publik.

### 7. Build Frontend

```bash
npm run build
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi melalui:

```text
http://127.0.0.1:8000
```

## Struktur Aplikasi

Beberapa direktori utama dalam proyek:

```text
app/
├── Filament/
│   ├── Pages/
│   ├── Resources/
│   └── Widgets/
├── Http/
│   └── Controllers/
├── Models/
└── Providers/

database/
├── migrations/
└── seeders/

public/
├── icons/
├── images/
├── manifest.json
└── service-worker.js

resources/
└── views/

routes/
└── web.php

tests/
```

## Status Pengembangan

JambiBersih dikembangkan sebagai aplikasi web untuk mendukung pelaporan dan pengelolaan sampah liar di Kota Jambi. Pengembangan mencakup fitur pelaporan masyarakat, pengelolaan laporan dan klaster, dashboard berdasarkan peran, edukasi lingkungan, informasi jadwal penjemputan, serta penyimpanan file menggunakan Supabase Storage.

## Tim Pengembang

| Nama | Peran |
|---|---|
| Putri Prayesti | Ketua |
| Reffa Azzahra | Anggota |
| Arsilia Zuhruf | Anggota |

## Akses Aplikasi

[**JambiBersih – Aplikasi Web**](https://jambibersih.ethiodeploy.app/)