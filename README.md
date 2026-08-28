# 🏘️ RW 012 - Portal Informasi Lingkungan Digital

Selamat datang di repositori sistem web **RW 012 Digital Portal**. Aplikasi ini dibangun untuk mempermudah manajemen informasi, dokumentasi kegiatan, kepengurusan, dan komunikasi warga di wilayah RW 012, Kelurahan Bugel, Kecamatan Karawaci, Kota Tangerang.

---

## 🛠️ 1. Kebutuhan Server (Requirements)
Pastikan server atau lokal mesin Anda memenuhi spesifikasi berikut:
- **PHP** >= 8.2
- **Composer** (versi terbaru)
- **MySQL** / MariaDB
- **Web Server** (Apache via XAMPP / Nginx)
- PHP Extensions: `BCMath`, `Ctype`, `cURL`, `DOM`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PCRE`, `PDO`, `Tokenizer`, `XML`.

---

## 🚀 2. Instalasi Proyek
Ikuti langkah-langkah berikut untuk meng-clone dan menyiapkan aplikasi di lokal Anda:

1. **Clone Repositori (jika pakai git):**
   ```bash
   git clone <repo-url> rw012
   cd rw012
   ```

2. **Install Dependensi Composer:**
   ```bash
   composer install
   ```

---

## ⚙️ 3. Konfigurasi Lingkungan (`.env`)
1. Duplikat file konfigurasi *environment*:
   ```bash
   cp .env.example .env
   ```
2. Hasilkan kunci keamanan Laravel (App Key):
   ```bash
   php artisan key:generate
   ```
3. Buka file `.env` dan atur koneksi basis data Anda menjadi seperti ini:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=rw012
   DB_USERNAME=root
   DB_PASSWORD=
   ```
*(Ubah `DB_USERNAME` dan `DB_PASSWORD` sesuai dengan konfigurasi XAMPP/MySQL Anda).*

---

## 🗄️ 4. Pembuatan Database MySQL
Sebelum menjalankan sistem, Anda wajib membuat database di MySQL:
1. Buka **phpMyAdmin** (biasanya di `http://localhost/phpmyadmin`).
2. Klik tombol **New** / **Baru**.
3. Buat database dengan nama **`rw012`**.

---

## 🏗️ 5. Menjalankan Migration
Migration berfungsi untuk membangun struktur tabel di database Anda secara otomatis. Jalankan perintah:
```bash
php artisan migrate
```
*Tunggu hingga seluruh tabel berhasil dibuat.*

---

## 🌱 6. Menjalankan Seeder (Data Awal)
Sistem membutuhkan *Seeder* untuk menghasilkan data awal seperti profil RW, data RT 001-003, pengaturan kontak utama, serta **Akun Admin**.
Jalankan perintah ini:
```bash
php artisan db:seed
```

---

## 📁 7. Konfigurasi Storage Link
Sistem ini menggunakan fitur unggah gambar yang aman via Laravel Storage (untuk Galeri, Foto Pengurus, dan Aspirasi). 
Agar gambar bisa diakses dari folder publik, **Anda wajib** menjalankan perintah ini:
```bash
php artisan storage:link
```
*Ini akan membuat shortcut (symlink) dari `storage/app/public` ke `public/storage`.*

---

## 🔑 8. Login Administrator
Setelah semua siap, jalankan *development server*:
```bash
php artisan serve
```
Akses halaman website di browser: `http://localhost:8000`

Untuk masuk ke **Admin Dashboard**, pergi ke: `http://localhost:8000/login`
Gunakan kredensial default dari seeder (lihat file `DatabaseSeeder.php` jika Anda perlu memastikannya), yang secara standar adalah:
- **Email**: `admin@rw012.com`
- **Password**: `password`

---

## 🌐 9. Deployment via XAMPP (Local/LAN)
Jika ingin diakses tanpa `php artisan serve` (melalui URL `http://localhost/rw012`):
1. Letakkan folder proyek `rw012` ini ke dalam folder `C:\xampp\htdocs\`.
2. Pastikan file `.env` pada baris `APP_URL` diatur ke URL yang sesuai.
3. Namun untuk kemudahan, yang paling direkomendasikan adalah membuat *Virtual Host* di XAMPP, yang menunjuk *DocumentRoot* langsung ke direktori `C:/xampp/htdocs/rw012/public`.

---

## ☁️ 10. Deployment Hosting / cPanel (Production)
Jika Anda ingin meng-online-kan website ini:
1. **Compress** seluruh proyek menjadi file `.zip`.
2. Di cPanel, buat **MySQL Database**, **User**, dan hubungkan keduanya.
3. Buka **File Manager**, *upload* dan *extract* zip ke direktori root Anda (bisa `/public_html` atau direktori *subdomain*).
4. Edit file `.env` di cPanel, sesuaikan nama database, user, dan password dengan yang baru saja dibuat.
5. Sesuaikan `APP_ENV=production` dan `APP_DEBUG=false`.
6. Jika cPanel tidak memiliki akses terminal (SSH) untuk menjalankan `php artisan storage:link`, Anda bisa membuat sebuah *cron job* khusus atau file PHP *symlink.php* sementara yang isinya:
   ```php
   <?php
   symlink('/home/user_cpanel/public_html/storage/app/public', '/home/user_cpanel/public_html/public/storage');
   echo "Symlink Success!";
   ?>
   ```

---
*Proyek ini telah menerapkan Best Practices keamanan dasar (Validasi anti-spam, proteksi XSS via Blade, sanitasi File Upload) serta standar UI/UX modern responsif menggunakan Bootstrap 5 dan Leaflet.js.*
