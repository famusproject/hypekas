<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HypeKas UMKM - Sistem Pencatatan Keuangan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            body {
                min-height: 100vh;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .welcome-card {
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 0.125rem 0.5rem rgba(0,0,0,0.12);
                overflow: hidden;
                max-width: 600px;
                margin: 2rem auto;
            }
            .welcome-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: #fff;
                padding: 2rem 1rem 1.2rem 1rem;
                text-align: center;
            }
            .welcome-header h3 {
                font-weight: 700;
                margin-bottom: 0.2rem;
            }
            .welcome-header small {
                color: #e0e7ff;
            }
            .welcome-body {
                padding: 2rem 2rem 1.5rem 2rem;
            }
            .btn-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                border-radius: 10px;
                padding: 0.75rem 1.5rem;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            }
            .btn-success {
                background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
                border: none;
                border-radius: 10px;
                padding: 0.75rem 1.5rem;
            }
            .btn-success:hover {
                background: linear-gradient(135deg, #40c057 0%, #51cf66 100%);
            }
            .alert {
                border-radius: 10px;
                border: none;
            }
            .alert-success {
                background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
                color: white;
            }
            .feature-card {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 1.5rem;
                margin: 1rem 0;
                border-left: 4px solid #667eea;
            }
            .feature-icon {
                font-size: 2rem;
                color: #667eea;
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="welcome-card">
            <div class="welcome-header">
                <h3><i class="fas fa-store me-2"></i>HypeKas UMKM</h3>
                <small>Sistem Pencatatan Keuangan</small>
            </div>
            <div class="welcome-body">
                {{-- Session Success Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <h4 class="text-center mb-4">Selamat Datang di HypeKas UMKM</h4>
                <p class="text-center text-muted mb-4">
                    Sistem pencatatan keuangan yang dirancang khusus untuk UMKM (Usaha Mikro, Kecil, dan Menengah)
                </p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h6>Dashboard Analytics</h6>
                            <p class="text-muted small">Monitor performa bisnis dengan grafik dan statistik real-time</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <h6>Manajemen Produk</h6>
                            <p class="text-muted small">Kelola inventori produk dengan mudah dan efisien</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h6>Pencatatan Penjualan</h6>
                            <p class="text-muted small">Catat setiap transaksi penjualan dengan detail lengkap</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <h6>Pengelolaan Pengeluaran</h6>
                            <p class="text-muted small">Monitor dan catat semua pengeluaran bisnis</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    @auth
                        <a href="{{ route('umkm.dashboard') }}" class="btn btn-primary me-2">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary me-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-success">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        © 2024 HypeKas UMKM. Dibuat dengan ❤️ untuk UMKM Indonesia
                    </small>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html> 