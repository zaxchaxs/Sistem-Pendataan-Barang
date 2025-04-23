# Sistem CRUD Pendataan Barang

Aplikasi web sederhana untuk manajemen data barang dengan fitur login/register dan operasi CRUD (Create, Read, Update, Delete) menggunakan PHP, MySQL, dan Tailwind CSS.

## Fitur

- Autentikasi (Login/Register)
- CRUD Barang:
  - Kode Barang (otomatis generate)
  - Nama Barang
  - Jenis Barang
  - Pesan/Catatan
- Validasi input form
- Tampilan responsive dengan Tailwind CSS

## Instalasi

1. Clone atau download repository ini
2. Simpan di folder htdocs (XAMPP) atau www (WAMP/LAMP)
3. Buat database MySQL dengan nama `db_pendataan_barang`
4. Import struktur database dari file `database-schema.sql`
5. Konfigurasi koneksi database di `config/database.php` jika diperlukan
6. Akses aplikasi melalui browser: `http://localhost/sistem_pendataan_barang`

## Struktur Database

### Tabel `users`
- `id` - ID pengguna (Auto Increment)
- `username` - Username untuk login
- `password` - Password (hashed)
- `email` - Email pengguna
- `created_at` - Waktu pendaftaran

### Tabel `barang`
- `id` - ID barang (Auto Increment)
- `kode_barang` - Kode unik barang
- `nama_barang` - Nama barang
- `jenis_barang` - Jenis barang
- `pesan` - Pesan/catatan tambahan
- `created_at` - Waktu pembuatan
- `updated_at` - Waktu terakhir diupdate

## Penggunaan

1. Register akun baru
2. Login menggunakan akun yang telah dibuat
3. Kelola data barang (lihat, tambah, edit, hapus)
4. Logout setelah selesai

## Keamanan

- Password dienkripsi menggunakan `password_hash()` PHP
- Validasi input untuk mencegah SQL Injection
- Penggunaan prepared statement untuk query database
- Sanitasi output HTML untuk mencegah XSS

## Teknologi yang Digunakan

- PHP 7.4+
- MySQL 5.7+
- Tailwind CSS (via CDN)
- HTML5