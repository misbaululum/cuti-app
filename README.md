# Cuti App

Aplikasi Cuti berbasis Laravel ini dirancang untuk memudahkan pengelolaan permohonan cuti dengan sistem multi-level approval. Aplikasi ini memungkinkan pengguna untuk mengajukan cuti, dan atasan untuk menyetujui atau menolak permohonan tersebut.

## Fitur

- Pengajuan cuti oleh karyawan
- Pengajuan izin oleh karyawan
- Sistem multi-level approval
- Notifikasi untuk setiap status permohonan
- Tampilan yang responsif dan user-friendly
- Manajemen data cuti yang mudah

## Prerequisites

Sebelum memulai, pastikan Anda telah menginstal:

- PHP >= 8.2
- Composer
- Laravel >= 11.x
- Database (MySQL, PostgreSQL, dll.)

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal aplikasi:

1. **Clone Repository**

   ```bash
   git clone https://github.com/misbaululum/cuti-app.git
   cd cuti-app
2. **Instal Dependensi**
   ```bash
   composer install
   npm install
3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
4. **Konfigurasi Database**
   Edit file .env dan sesuaikan pengaturan database Anda. Berikut adalah contoh pengaturan untuk MySQL:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=

5. **Generate Kunci Aplikasi**
   ```bash
   php artisan key:generate
6. **Migrasi Database & Seed Database**
   ```bash
   php artisan migrate --seed
7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   
## Kontak

Jika Anda memiliki pertanyaan atau saran, silakan hubungi:
- Email: misbaul99@gmail.com
  
## Lisensi

The Laravel framework is open-sourced software licensed under the [MIT license](LICENSE.md)
