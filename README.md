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


## 🚀 Tampilan Aplikasi
- **Tampilan Login**
  
- **Tampilan Dashboard**
- **Tampilan Tabel Produk**
- **Tampilan Form Create**
- **Tampilan Form Edit***
- **Tampilan Delete**

