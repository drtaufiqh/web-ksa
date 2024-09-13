# PAK TANI Website Documentation

## Table of Contents
1. [Perkenalan Website](#Perkenalan)
2. [Framework dan Teknologi](#Framework-Teknologi)
3. [Instalasi](#installation)
4. [Set Up and Running](#running-the-application)
5. [Struktur Project](#project-structure)
6. [Troubleshooting](#troubleshooting)
7. [License](#license)

---

## Perkenalan
PAK TANI merupakan aplikasi berbasis website yang dikembangkan dengan tujuan untuk dapat mendeteksi inkonsistensi data jagung dan padi, serta melakukan monitoring sample ubinan yang tersedia. PAK TANI juga menyediakan dashboard interaktif yang dapat membantu monitoring data. PAK TANI merupakan aplikasi berbasis website yang dikembangkan menggunakan framework bootstrap dan laravel, serta menggunakan database berbasis mySQL.

---

## Framework dan Teknologi

### Laravel
Laravel adalah framework PHP yang diciptakan oleh Taylor Otwell pada tahun 2011, Laravel dirancang untuk memudahkan pengembangan aplikasi web dengan menyediakan kerangka kerja yang elegan dan bersih. Framework ini mengutamakan developer experience dan menawarkan berbagai fitur canggih untuk membangun aplikasi web modern dengan cepat dan mudah.

Mengapa Laravel?

1. Ekspresif dan Bersih (Expressive & Clean Syntax): Laravel memberikan sintaks yang mudah dibaca dan dipahami. Bagi pengembang, ini berarti menulis kode yang bersih dan mudah untuk dipelihara dalam jangka panjang.

2. Arsitektur MVC (Model-View-Controller): Laravel menggunakan arsitektur MVC, yang membantu memisahkan logika aplikasi (model), antarmuka pengguna (view), dan kontrol (controller). Ini memudahkan pengelolaan proyek yang kompleks karena setiap bagian dapat diatur secara terpisah.

3. Built-in Tools dan Libraries: Laravel dilengkapi dengan berbagai alat dan pustaka yang mendukung pengembangan fitur umum seperti otentikasi, pengelolaan sesi, validasi data, caching, dan banyak lagi.

4. Ekosistem yang Kuat: Laravel memiliki ekosistem yang besar dan berkembang. Ada berbagai alat pendukung seperti:
 - Laravel Forge: Untuk manajemen server.
 - Laravel Vapor: Untuk deployment serverless. 
 - Laravel Mix: Untuk manajemen aset front-end. 
 - Laravel Nova: Untuk pembuatan panel admin yang cepat dan elegan.
 - Eloquent ORM: Laravel menyediakan Eloquent, ORM (Object Relational Mapping) yang kuat, untuk memudahkan manipulasi database. Eloquent memungkinkan developer bekerja dengan basis data menggunakan model yang berbasis objek, sehingga meminimalkan penulisan SQL mentah.

Laravel yang digunakan dalam pengembangan website ini adalah Laravel 9.

### Bootstrap
Bootstrap adalah framework front-end untuk pengembangan situs web responsif dan aplikasi berbasis web. Bootstrap menyediakan kumpulan alat berbasis HTML, CSS, dan JavaScript yang memudahkan pembuatan desain web yang menarik, responsif, dan mobile-first dengan cepat.

Bootsrtap yang digunakan dalam project ini adalah Bootsrtap 4.1.3

### MySQL
MySQL adalah sistem manajemen basis data relasional (RDBMS) yang sangat populer dan banyak digunakan di seluruh dunia. Dikembangkan oleh MySQL AB (kemudian diakuisisi oleh Sun Microsystems dan akhirnya oleh Oracle Corporation), MySQL adalah salah satu pilihan utama untuk aplikasi web dan aplikasi lain yang membutuhkan penyimpanan data terstruktur. MySQL mendukung penyimpanan data dalam tabel yang saling berhubungan dan memungkinkan untuk menjalankan query SQL untuk mengelola dan mengambil data.

Fitur Utama MySQL
1. Sistem Manajemen Basis Data Relasional (RDBMS)
2. SQL (Structured Query Language)
3. Kinerja Tinggi
4. Dukungan Transaksi
5. Keamanan terotentikasi
6. Replikasi
7. Cadangan dan Pemulihan

---

## Instalasi

### Persyaratan
Untuk menjalankan project ini, pastikan sistem sudah memenuhi persyarakatan berikut :

PHP: >= 8.0
Composer: Installed (Dependency Manager for PHP)
MySQL: >= 5.7 or MariaDB
Node.js: >= 12.x (for front-end assets management)
NPM/Yarn: (Node Package Manager)

### Running

1. Clone the repository:

```bash
   git clone https://github.com/your-repo/laravel-project.git
   cd laravel-project
```

2. Install dependencies: Using Composer for PHP dependencies:
```bash
   composer install
```

3. Set up environment file: Copy .env.example to .env and configure your environment settings, such as database credentials:
```bash
   cp .env.example .env
```
4. Generate application key: Laravel requires an application key for encryption purposes. Run this command to generate the key:
```bash
 php artisan key:generate
```
5. Buat Databse web ksa

6. Set up database: Run the following commands to create tables and seed the database:
```bash
php artisan migrate
php artisan db:seed
```

To start the Laravel development server, run:
```bash
php artisan serve
```

## Struktur Project

Seluruh file pada project PAK TANI mengikuti framework Laravel. Dalam melakukan editing dalam program, silahkan project dibagi menjadi 2 kelompok file

### Dapat Diedit
1. Routes (Rute)

Terletak di folder routes/. File ini digunakan untuk mendefinisikan rute aplikasi.
File yang dapat diedit:
- web.php: Rute untuk aplikasi berbasis web (HTML).
- api.php: Rute untuk API berbasis JSON.
- console.php: Rute untuk command-line interface.
- channels.php: Digunakan untuk channel broadcasting.

2. Views (Tampilan)

Terletak di folder resources/views/. Semua file di sini merupakan template tampilan yang bisa diedit menggunakan Blade (template engine Laravel). Untuk mengganti assets, css dll. lakukan penggantian di public/assets
Biasanya file di sini berekstensi .blade.php dan berisi HTML yang dinamis.

3. Controllers (Pengontrol)

Terletak di folder app/Http/Controllers/. File ini bertanggung jawab mengontrol logika aplikasi.
File controller biasanya berekstensi .php dan dapat diedit untuk memanipulasi data yang dikirim ke tampilan atau diambil dari model.

4. Models

Terletak di folder app/Models/. File model berisi logika untuk berinteraksi dengan basis data, termasuk query, relasi antar tabel, dan validasi data. Anda bisa menyesuaikan atau membuat model baru di sini.

5. Migrations

Terletak di folder database/migrations/. Migrations memungkinkan Anda untuk memodifikasi struktur basis data (seperti membuat tabel atau mengubah kolom). File migration bisa diedit sebelum dijalankan.

6. Seeders

Terletak di folder database/seeders/. Seeder digunakan untuk mengisi basis data akun user. Anda bisa membuat dan mengedit file seeder ini sesuai dengan kebutuhan.

7. Middleware

Terletak di folder app/Http/Middleware/. Middleware digunakan untuk memproses request sebelum mencapai controller dan autentifikasi akun user. Anda bisa membuat dan mengedit middleware.

8. Config

Terletak di folder config/. File ini berisi konfigurasi untuk berbagai komponen Laravel seperti database.php, mail.php, app.php, dan lain-lain. Anda dapat mengedit file konfigurasi ini sesuai kebutuhan, tetapi lakukan dengan hati-hati.

9. Service Providers

Terletak di folder app/Providers/. Ini berfungsi untuk mengatur tanggal dan waktu lokal. Biasanya Anda akan menyesuaikan file AppServiceProvider.php untuk melakukan binding atau penyesuaian layanan.

### Jangan Diedit
1. Core Laravel Framework Files

Terletak di folder vendor/laravel/. Folder ini berisi semua dependensi dan komponen Laravel serta third-party libraries. Anda tidak boleh mengedit file di dalam folder vendor/, karena ini merupakan bagian dari framework Laravel yang diinstal melalui Composer. Semua perubahan di sini bisa hilang saat framework diperbarui.

2. Autoload Files

File seperti bootstrap/autoload.php dan file di dalam folder bootstrap/cache/. Ini adalah file autoload dan cache yang dihasilkan secara otomatis dan tidak seharusnya diedit secara manual.

3. Composer Files

File composer.lock dan composer.json digunakan untuk mengelola dependensi menggunakan Composer. Meskipun Anda bisa mengedit composer.json untuk menambahkan dependensi baru, Anda tidak harus mengedit file composer.lock secara manual.

4. Environment File (Sebagian Besar)

File .env digunakan untuk menyimpan konfigurasi lingkungan aplikasi seperti database credentials, API keys, dan konfigurasi server. Meskipun Anda bisa mengedit file ini untuk menyesuaikan pengaturan aplikasi, sebaiknya tidak mengedit file .env langsung di production tanpa melakukan backup atau pengujian sebelumnya.

### Struktur Project Laravel

```bash
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/        # Tempat file Controller
│   │   ├── Middleware/         # Tempat file Middleware
│   └── Models/                 # Tempat file Model
├── bootstrap/                  # File autoload & bootstrap aplikasi
├── config/                     # Konfigurasi aplikasi
├── database/                   
│   ├── migrations/             # Tempat file migration
│   ├── seeders/                # Tempat file seeder
│   └── factories/              # Tempat file factory
├── public/                     # Akses file public (CSS, JS, dll.)
├── resources/                  
│   └── views/                  # Tempat file tampilan (Blade)
├── routes/                     # Tempat file route (web.php, api.php)
├── storage/                    # Tempat penyimpanan file (logs, cache, dll.)
├── tests/                      # Tempat file untuk pengujian
└── vendor/                     # Tempat file library (vendor Laravel dan lainnya)
```
## Truobleshooting
### Masalah Umum
1. Missing Application Key: Jika Anda melihat pesan error terkait key yang hilang, pastikan Anda menjalankan perintah 
   php artisan key:generate.
2. Database Connection Errors:  Periksa kembali file .env Anda untuk memastikan kredensial database sudah benar.
3. CSS/JS Not Loading: Pastikan Anda telah menjalankan perintah npm run dev untuk mengompilasi aset Anda.

### Useful Commands

Clear cache:
```bash
php artisan cache:clear
```
Restart the queue:
```bash
php artisan queue:restart
```

## Lisence
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).