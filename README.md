# HypeKas - UMKM Financial Management System

HypeKas adalah sistem manajemen keuangan dan pelaporan yang dirancang khusus untuk UMKM (Usaha Mikro, Kecil, dan Menengah). Aplikasi ini membantu pemilik bisnis mengelola produk, supplier, pelanggan, penjualan, pengeluaran, dan menghasilkan laporan keuangan yang komprehensif.

## 🚀 Fitur Utama

### 📊 Dashboard UMKM

-   Dashboard interaktif dengan grafik dan statistik
-   Ringkasan penjualan, pengeluaran, dan profit
-   Analisis tren bisnis

### 🛍️ Manajemen Produk

-   CRUD operasi untuk produk
-   Kategori produk
-   Manajemen stok
-   Harga dan informasi produk

### 👥 Manajemen Relasi Bisnis

-   **Supplier**: Data pemasok dan informasi kontak
-   **Customer**: Data pelanggan dan riwayat transaksi

### 💰 Manajemen Transaksi

-   **Sales**: Pencatatan penjualan dengan detail produk
-   **Expenses**: Pencatatan pengeluaran operasional

### 📈 Laporan Keuangan

-   Laporan Profit & Loss
-   Laporan Cash Flow
-   Laporan Returns & Cancellations
-   Analisis ROAS (Return on Ad Spend)

### 🔐 Sistem Keamanan

-   Autentikasi pengguna
-   Proteksi CSRF
-   Validasi input
-   Middleware keamanan

## 🛠️ Teknologi yang Digunakan

-   **Backend**: Laravel 9 (PHP Framework)
-   **Frontend**: Bootstrap 5, Blade Templates
-   **Database**: MySQL
-   **Charts**: Chart.js
-   **Authentication**: Laravel Built-in Auth

## 📋 Persyaratan Sistem

-   PHP >= 8.0
-   Composer
-   MySQL >= 5.7
-   Web Server (Apache/Nginx) atau XAMPP

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/hypekas.git
cd hypekas
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hypekas
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration

```bash
php artisan migrate
```

### 6. Jalankan Seeder (Opsional)

```bash
php artisan db:seed
```

### 7. Serve Application

```bash
php artisan serve
```

Aplikasi akan tersedia di `http://127.0.0.1:8000`

## 📁 Struktur Project

```
HypeKas/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
├── resources/
│   └── views/              # Blade Templates
│       ├── auth/           # Authentication Views
│       └── umkm/           # UMKM Views
├── routes/
│   └── web.php            # Web Routes
└── public/                # Public Assets
```

## 🔐 Keamanan

Aplikasi ini dilengkapi dengan berbagai lapisan keamanan:

-   **CSRF Protection**: Middleware CSRF untuk mencegah Cross-Site Request Forgery
-   **XSS Protection**: Blade template escaping untuk mencegah Cross-Site Scripting
-   **SQL Injection Protection**: Eloquent ORM untuk mencegah SQL Injection
-   **Input Validation**: Validasi input di semua form
-   **Authentication**: Sistem login/logout yang aman

## 📊 Database Schema

### Tabel Utama:

-   `users` - Data pengguna sistem
-   `products` - Data produk UMKM
-   `suppliers` - Data pemasok
-   `customers` - Data pelanggan
-   `sales` - Data penjualan
-   `expenses` - Data pengeluaran

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

## 👨‍💻 Developer

Dikembangkan untuk keperluan akademis dan pembelajaran sistem manajemen keuangan UMKM.

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository GitHub ini.

---

**HypeKas** - Solusi Keuangan UMKM yang Terpercaya 💰
