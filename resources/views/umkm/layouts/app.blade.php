<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HypeKas UMKM') - Sistem Pencatatan Keuangan UMKM</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            border-radius: 15px 15px 0 0 !important;
        }
        .btn {
            border-radius: 10px;
            padding: 0.5rem 1.5rem;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
        }
        .stats-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .stats-card.danger {
            background: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
        }
        .stats-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stats-card.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white mb-0">
                            <i class="fas fa-store me-2"></i>
                            HypeKas UMKM
                        </h4>
                        <small class="text-white-50">Sistem Pencatatan Keuangan</small>
                    </div>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('umkm.dashboard') ? 'active' : '' }}" href="{{ route('umkm.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('umkm.products.*') ? 'active' : '' }}" href="{{ route('umkm.products.index') }}">
                            <i class="fas fa-box"></i> Produk
                        </a>
                        <a class="nav-link {{ request()->routeIs('umkm.suppliers.*') ? 'active' : '' }}" href="{{ route('umkm.suppliers.index') }}">
                            <i class="fas fa-truck"></i> Supplier
                        </a>
                        <a class="nav-link {{ request()->routeIs('umkm.customers.*') ? 'active' : '' }}" href="{{ route('umkm.customers.index') }}">
                            <i class="fas fa-users"></i> Customer
                        </a>
                        <a class="nav-link {{ request()->routeIs('umkm.sales.*') ? 'active' : '' }}" href="{{ route('umkm.sales.index') }}">
                            <i class="fas fa-shopping-cart"></i> Penjualan
                        </a>
                        <a class="nav-link {{ request()->routeIs('umkm.expenses.*') ? 'active' : '' }}" href="{{ route('umkm.expenses.index') }}">
                            <i class="fas fa-receipt"></i> Pengeluaran
                        </a>
                        
                        <hr class="text-white-50 my-3">
                        
                        <a class="nav-link {{ request()->routeIs('umkm.reports.*') ? 'active' : '' }}" href="{{ route('umkm.reports.profit-loss') }}">
                            <i class="fas fa-chart-line"></i> Laporan Laba Rugi
                        </a>
                        <a class="nav-link {{ request()->routeIs('umkm.reports.*') ? 'active' : '' }}" href="{{ route('umkm.reports.returns-cancellations') }}">
                            <i class="fas fa-undo"></i> Laporan Retur & Batal
                        </a>
                        <a class="nav-link {{ request()->routeIs('umkm.reports.*') ? 'active' : '' }}" href="{{ route('umkm.reports.cashflow') }}">
                            <i class="fas fa-money-bill-wave"></i> Arus Kas
                        </a>
                        <a class="nav-link {{ request()->routeIs('umkm.reports.*') ? 'active' : '' }}" href="{{ route('umkm.reports.roas') }}">
                            <i class="fas fa-chart-pie"></i> ROAS
                        </a>
                        
                        <hr class="text-white-50 my-3">
                        
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <div class="main-content p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html> 