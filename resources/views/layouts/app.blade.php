<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HypeKas - Sistem Keuangan')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    :root {
        --primary-color: #3B82F6;
        --secondary-color: #1E40AF;
        --success-color: #10B981;
        --danger-color: #EF4444;
        --warning-color: #F59E0B;
        --info-color: #06B6D4;
    }

    .sidebar {
        min-height: 100vh;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin: 0.25rem 0;
        transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        color: white;
        background-color: rgba(255, 255, 255, 0.1);
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
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
    }

    .stat-card.income {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }

    .stat-card.expense {
        background: linear-gradient(135deg, var(--danger-color), #DC2626);
    }

    .stat-card.balance {
        background: linear-gradient(135deg, var(--info-color), #0891B2);
    }
    </style>

    @yield('styles')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white fw-bold">
                            <i class="fas fa-chart-line me-2"></i>
                            HypeKas
                        </h4>
                        <small class="text-white-50">Sistem Keuangan</small>
                    </div>

                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
                            href="{{ route('transactions.index') }}">
                            <i class="fas fa-exchange-alt"></i>
                            Transaksi
                        </a>
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                            href="{{ route('categories.index') }}">
                            <i class="fas fa-tags"></i>
                            Kategori
                        </a>
                        <a class="nav-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}"
                            href="{{ route('accounts.index') }}">
                            <i class="fas fa-wallet"></i>
                            Akun
                        </a>
                        <a class="nav-link {{ request()->routeIs('budgets.*') ? 'active' : '' }}"
                            href="{{ route('budgets.index') }}">
                            <i class="fas fa-chart-pie"></i>
                            Anggaran
                        </a>
                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                            href="{{ route('reports.index') }}">
                            <i class="fas fa-file-alt"></i>
                            Laporan
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-0">
                <div class="main-content p-4">
                    <!-- Top Navigation -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-white rounded-3 mb-4 shadow-sm">
                        <div class="container-fluid">
                            <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>

                            <div class="navbar-nav ms-auto">
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-2"></i>
                                        {{ Auth::user()->name ?? 'User' }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="fas fa-cog me-2"></i>Pengaturan</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>

                    <!-- Flash Messages -->
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

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>