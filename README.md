# 🌾 PAK TANI — Pengawalan Konsistensi Data Jagung dan Padi

> **Aplikasi web berbasis Laravel untuk pengawalan konsistensi, validasi, dan monitoring data komoditas padi, jagung, dan ubinan dalam mendukung Survei KSA BPS.**

![Laravel](https://img.shields.io/badge/Laravel-9.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-4.1.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 📸 Preview

![Halaman Login PAK TANI](Pak%20Tani.png)

> *Tampilan halaman login PAK TANI dengan desain dua panel — identitas sistem di kiri, form login di kanan.*

---

## 📋 Daftar Isi

1. [Tentang Proyek](#-tentang-proyek)
2. [Fitur Utama](#-fitur-utama)
3. [Arsitektur Sistem](#-arsitektur-sistem)
4. [Tech Stack](#-tech-stack)
5. [Persyaratan Sistem](#-persyaratan-sistem)
6. [Instalasi & Konfigurasi](#-instalasi--konfigurasi)
7. [Struktur Proyek](#-struktur-proyek)
8. [Panduan Penggunaan](#-panduan-penggunaan)
9. [Peran Pengguna (Role)](#-peran-pengguna-role)
10. [Troubleshooting](#-troubleshooting)
11. [Lisensi](#-lisensi)

---

## 🌟 Tentang Proyek

**PAK TANI** (*Pengawalan Konsistensi Data Jagung dan Padi*) adalah aplikasi web yang dikembangkan untuk mendukung kegiatan pengumpulan dan monitoring data statistik pertanian, khususnya dalam konteks **Survei Kerangka Sampel Area (KSA)**.

Aplikasi ini dirancang untuk membantu petugas lapangan dan supervisor BPS dalam:
- Mengunggah dan memvalidasi data amatan **padi** dan **jagung**
- Melacak progres pengisian kuesioner per petugas dan wilayah
- Memonitoring dan mengelola sample **ubinan** (pengukuran hasil panen)
- Mendeteksi inkonsistensi data secara otomatis melalui aturan validasi yang terprogram

> Proyek ini dikembangkan sebagai bagian dari **program magang** di **Badan Pusat Statistik (BPS) Provinsi Jawa Tengah**, mengintegrasikan kebutuhan nyata di lapangan ke dalam sebuah sistem informasi berbasis web.

---

## ✨ Fitur Utama

### 🌾 Modul Padi
| Fitur | Deskripsi |
|---|---|
| **Dashboard Interaktif** | Visualisasi peta sebaran, capaian survei, dan progres pengisian per kabupaten/kota |
| **Unggah Data** | Import data amatan padi dari file Excel menggunakan Maatwebsite/Excel |
| **Validasi Data** | Pengecekan inkonsistensi fase tumbuh (a1–c3) dengan aturan logika pertanian |
| **Monitoring Petugas** | Pantau target vs. realisasi per petugas cacah (PCS) |
| **Riwayat Upload** | Rekam jejak seluruh aktivitas unggah data per periode |
| **Kondisi Definisi** | Halaman panduan klasifikasi fase tumbuh padi |

### 🌽 Modul Jagung
| Fitur | Deskripsi |
|---|---|
| **Dashboard Interaktif** | Visualisasi dan analisis data amatan jagung per wilayah |
| **Unggah Data** | Import data amatan jagung dari file Excel dengan feedback validasi |
| **Validasi Data** | Deteksi inkonsistensi data fase tumbuh jagung (a1–b2) |
| **Monitoring Petugas** | Progres realisasi per petugas cacah (PCS) dengan persentase capaian |
| **Riwayat Upload** | Histori upload data jagung per tahun dan bulan |
| **Kondisi Definisi** | Panduan klasifikasi fase tumbuh jagung |

### 📏 Modul Ubinan
| Fitur | Deskripsi |
|---|---|
| **Lacak Sample** | Pencarian dan penelusuran sample ubinan berdasarkan indeks dan subsegmen |
| **Sample Potensial** | Identifikasi segmen yang berpotensi panen untuk prioritas ubinan |
| **Kelola Petani** | Manajemen data petani yang terpilih sebagai responden ubinan |
| **Unggah Data** | Import data ubinan dari file Excel |
| **Riwayat** | Histori data ubinan per periode survei |

### 🔐 Fitur Sistem
- **Autentikasi Multi-Level**: Login berbasis role (Pusat/Provinsi vs. Kabupaten/Kota)
- **Akses Berbasis Wilayah**: Data otomatis difilter sesuai kode wilayah pengguna
- **Export Data**: Unduh template dan dokumen dalam format yang terstandar
- **Responsive Design**: Antarmuka yang dapat diakses dari berbagai perangkat

---

## 🏗 Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────┐
│                    CLIENT (Browser)                     │
│          Bootstrap 4 + JavaScript + Chart.js            │
└─────────────────────┬───────────────────────────────────┘
                      │ HTTP/HTTPS
┌─────────────────────▼───────────────────────────────────┐
│                 LARAVEL 9 APPLICATION                   │
│                                                         │
│  ┌──────────┐   ┌────────────┐   ┌──────────────────┐  │
│  │  Routes  │──▶│Controllers │──▶│     Models       │  │
│  │ web.php  │   │ (8 files)  │   │ (Eloquent ORM)   │  │
│  └──────────┘   └────────────┘   └────────┬─────────┘  │
│                       │                   │             │
│              ┌────────▼────────┐          │             │
│              │  Blade Views    │          │             │
│              │ (20+ templates) │          │             │
│              └─────────────────┘          │             │
└───────────────────────────────────────────┼─────────────┘
                                            │
┌───────────────────────────────────────────▼─────────────┐
│                   DATABASE (MySQL)                      │
│   padi_amatans │ jagung_amatans │ ubinans │ users        │
└─────────────────────────────────────────────────────────┘
```

**Pola Arsitektur:** MVC (Model-View-Controller) mengikuti konvensi Laravel

---

## 🛠 Tech Stack

### Backend
| Teknologi | Versi | Kegunaan |
|---|---|---|
| **PHP** | >= 8.0.2 | Bahasa pemrograman utama |
| **Laravel** | 9.x | Framework MVC backend |
| **Laravel Sanctum** | 3.x | API token authentication |
| **Maatwebsite/Excel** | 3.1 | Import/Export file Excel |
| **PHPSpreadsheet** | 1.x | Pemrosesan spreadsheet |

### Frontend
| Teknologi | Versi | Kegunaan |
|---|---|---|
| **Bootstrap** | 4.1.3 | CSS framework & komponen UI |
| **JavaScript** | ES6+ | Logika interaktivitas frontend |
| **Blade** | - | Template engine Laravel |

### Database & Infrastruktur
| Teknologi | Versi | Kegunaan |
|---|---|---|
| **MySQL** | >= 5.7 | Database relasional utama |
| **Composer** | 2.x | PHP dependency manager |
| **NPM** | - | Node package manager (frontend assets) |
| **Vite** | - | Build tool frontend |

---

## 💻 Persyaratan Sistem

Sebelum instalasi, pastikan sistem sudah memenuhi persyaratan berikut:

| Persyaratan | Versi Minimum |
|---|---|
| **PHP** | >= 8.0.2 |
| **Composer** | >= 2.0 |
| **Node.js** | >= 12.x |
| **NPM/Yarn** | Terbaru |
| **MySQL** | >= 5.7 atau MariaDB |
| **Git** | Terbaru |

> **Rekomendasi:** Gunakan [XAMPP](https://www.apachefriends.org/), [Laragon](https://laragon.org/), atau [Laravel Sail (Docker)](https://laravel.com/docs/9.x/sail) untuk kemudahan setup environment lokal.

---

## 🚀 Instalasi & Konfigurasi

### Langkah 1 — Clone Repository

```bash
git clone https://github.com/your-username/web-ksa.git
cd web-ksa
```

### Langkah 2 — Install PHP Dependencies

```bash
composer install
```

### Langkah 3 — Konfigurasi Environment

Salin file `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi database:

```bash
cp .env.example .env
```

Edit file `.env` dan isi bagian database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_ksa      # Ganti dengan nama database kamu
DB_USERNAME=root         # Ganti dengan username MySQL kamu
DB_PASSWORD=             # Ganti dengan password MySQL kamu
```

### Langkah 4 — Generate Application Key

```bash
php artisan key:generate
```

### Langkah 5 — Setup Database

Buat database baru di MySQL dengan nama yang sesuai dengan `DB_DATABASE` di `.env`, kemudian jalankan migrasi dan seeder:

```bash
# Membuat tabel dari migration
php artisan migrate

# Mengisi data awal (akun user, dll.)
php artisan db:seed
```

### Langkah 6 — Install Frontend Assets

```bash
npm install
npm run dev
```

### Langkah 7 — Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser dan akses: **http://localhost:8000**

---

## 📁 Struktur Proyek

```
web-ksa/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── JagungAmatanController.php    # Logika modul jagung
│   │   │   ├── JagungValidasiController.php  # Validasi data jagung
│   │   │   ├── PadiAmatanController.php      # Logika modul padi
│   │   │   ├── PadiValidasiController.php    # Validasi data padi
│   │   │   ├── UbinanController.php          # Logika modul ubinan
│   │   │   ├── PetaniController.php          # Manajemen data petani
│   │   │   └── GambarController.php          # Unduh dokumen/gambar
│   │   └── Middleware/                       # Autentikasi & filter request
│   ├── Imports/
│   │   └── PadiAmatanImport.php              # Kelas import Excel padi
│   └── Models/
│       ├── JagungAmatan.php                  # Model data amatan jagung
│       ├── PadiAmatan.php                    # Model data amatan padi
│       ├── Ubinan.php                        # Model data ubinan
│       ├── JagungValidasi.php                # Model validasi jagung
│       ├── PadiValidasi.php                  # Model validasi padi
│       ├── Petani.php                        # Model data petani
│       ├── TahunBulan.php                    # Model periode tahun/bulan
│       └── User.php                          # Model pengguna sistem
│
├── database/
│   ├── migrations/                           # Skema tabel database
│   └── seeders/                              # Data awal (user, dll.)
│
├── resources/
│   └── views/
│       ├── auth/                             # Halaman login
│       ├── components/                       # Komponen Blade reusable
│       ├── jagung/                           # Views modul jagung
│       │   ├── dashboard.blade.php
│       │   ├── unggah.blade.php
│       │   ├── validasi.blade.php
│       │   ├── petugas.blade.php
│       │   ├── riwayat.blade.php
│       │   └── kondef.blade.php
│       ├── padi/                             # Views modul padi
│       │   ├── dashboard.blade.php
│       │   ├── unggah.blade.php
│       │   ├── validasi.blade.php
│       │   ├── petugas.blade.php
│       │   ├── riwayat.blade.php
│       │   └── kondef.blade.php
│       └── ubinan/                           # Views modul ubinan
│           ├── lacak.blade.php
│           ├── potensial.blade.php
│           ├── kelola.blade.php
│           ├── unggah.blade.php
│           └── riwayat.blade.php
│
├── routes/
│   └── web.php                               # Definisi seluruh route aplikasi
│
├── public/                                   # Asset publik (CSS, JS, gambar)
├── config/                                   # Konfigurasi framework
├── storage/                                  # Log, cache, file upload
└── vendor/                                   # Library PHP (dikelola Composer)
```

### File yang Dapat Diedit

| Folder | Deskripsi |
|---|---|
| `routes/web.php` | Definisi URL dan mapping ke controller |
| `resources/views/` | Template tampilan (Blade) |
| `app/Http/Controllers/` | Logika bisnis aplikasi |
| `app/Models/` | Interaksi dengan database |
| `database/migrations/` | Skema tabel database |
| `database/seeders/` | Data awal aplikasi |
| `config/` | Konfigurasi framework (hati-hati) |
| `public/assets/` | Asset CSS, JS, dan gambar custom |

### File yang **Tidak** Boleh Diedit

| Folder/File | Alasan |
|---|---|
| `vendor/` | Library pihak ketiga, dikelola Composer |
| `bootstrap/cache/` | Cache otomatis Laravel |
| `composer.lock` | Snapshot versi dependency |

---

## 📖 Panduan Penggunaan

### Login

Akses halaman login di `/login`. Masukkan email dan password yang terdaftar di sistem.

### Navigasi Utama

Setelah login, sidebar menyediakan navigasi ke:
- **Dashboard Padi / Jagung** — Ringkasan dan visualisasi data
- **Unggah Data** — Import data baru dari file Excel
- **Validasi** — Tinjau data yang terdeteksi inkonsisten
- **Monitoring Petugas** — Progres realisasi per PCS
- **Lacak Ubinan** — Penelusuran sample ubinan
- **Riwayat** — Histori upload per periode

### Alur Kerja Unggah Data

```
Unduh Template Excel (Kondef)
        ↓
Isi Data di Excel sesuai format
        ↓
Upload melalui halaman Unggah
        ↓
Sistem memvalidasi format & aturan logika
        ↓
Data tersimpan → Cek Halaman Validasi jika ada inkonsistensi
```

---

## 👥 Peran Pengguna (Role)

| Role | Kode | Akses Data |
|---|---|---|
| **Provinsi / Supervisor** | `3300` | Seluruh data semua kabupaten/kota |
| **Kabupaten/Kota** | Kode Kabkota | Hanya data wilayah sendiri |

Akses data otomatis difilter berdasarkan `kode` pada akun pengguna yang tersimpan di database.

---

## 🔧 Troubleshooting

### Masalah Umum

**1. Application Key Error**
```
No application encryption key has been specified.
```
**Solusi:** Jalankan `php artisan key:generate`

---

**2. Database Connection Error**
```
SQLSTATE[HY000] [1045] Access denied for user
```
**Solusi:** Periksa konfigurasi `DB_*` di file `.env`

---

**3. CSS/JS Tidak Termuat**
```
Mixed Content / 404 on assets
```
**Solusi:** Jalankan ulang `npm run dev` atau pastikan `APP_URL` di `.env` sudah benar

---

**4. Error setelah `composer install`**
```
Your requirements could not be resolved
```
**Solusi:** Pastikan versi PHP >= 8.0.2 dengan `php -v`

---

**5. Permission Error pada Storage**
```
The stream or file storage/logs/laravel.log could not be opened
```
**Solusi (Linux/Mac):**
```bash
chmod -R 775 storage bootstrap/cache
```

### Perintah Berguna

```bash
# Bersihkan semua cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Re-generate autoload
composer dump-autoload

# Lihat semua route terdaftar
php artisan route:list

# Jalankan ulang queue
php artisan queue:restart

# Rollback & migrate ulang (HATI-HATI: data akan hilang)
php artisan migrate:fresh --seed
```

---

## 📜 Lisensi

Proyek ini menggunakan lisensi **MIT** — Framework Laravel adalah perangkat lunak open-source yang dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

<div align="center">

**Dikembangkan dengan ❤️ selama program magang di BPS Provinsi Jawa Tengah**

*PAK TANI — Membantu petugas BPS dalam monitoring data komoditas pertanian*

</div>
