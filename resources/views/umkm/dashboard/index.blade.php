@extends('umkm.layouts.app')

@section('title', 'Dashboard UMKM')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard UMKM</h1>
        <div>
            <a href="{{ route('umkm.sales.create') }}" class="btn btn-success me-2">
                <i class="fas fa-plus"></i> Tambah Penjualan
            </a>
            <a href="{{ route('umkm.expenses.create') }}" class="btn btn-warning">
                <i class="fas fa-plus"></i> Tambah Pengeluaran
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Penjualan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Penjualan (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($monthlySales, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Pengeluaran (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profit Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Profit (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($monthlyProfit, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROAS Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                ROAS (Return on Ad Spend)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($roas, 2) }}x
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan 6 Bulan Terakhir</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Penjualan per Platform</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="platformChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($platformStats as $platform => $percentage)
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> {{ $platform }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Produk Terlaris -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produk Terlaris</h6>
                </div>
                <div class="card-body">
                    @if($topProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Terjual</th>
                                        <th>Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProducts as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ route('umkm.products.show', $product->id) }}" class="text-decoration-none">
                                                {{ $product->name }}
                                            </a>
                                        </td>
                                        <td>{{ $product->total_sold }}</td>
                                        <td>Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada data penjualan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Penjualan Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penjualan Terbaru</h6>
                </div>
                <div class="card-body">
                    @if($recentSales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Produk</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSales as $sale)
                                    <tr>
                                        <td>
                                            <a href="{{ route('umkm.sales.show', $sale->id) }}" class="text-decoration-none">
                                                {{ $sale->order_id }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($sale->product)
                                                {{ Str::limit($sale->product->name, 20) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($sale->status == 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($sale->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($sale->status == 'cancelled')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @elseif($sale->status == 'returned')
                                                <span class="badge bg-secondary">Dikembalikan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada data penjualan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('umkm.products.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-box"></i><br>
                                Tambah Produk
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('umkm.suppliers.create') }}" class="btn btn-info w-100">
                                <i class="fas fa-truck"></i><br>
                                Tambah Supplier
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('umkm.customers.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-user-plus"></i><br>
                                Tambah Customer
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('umkm.expenses.create') }}" class="btn btn-warning w-100">
                                <i class="fas fa-money-bill-wave"></i><br>
                                Catat Pengeluaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Penjualan',
            data: @json($chartData),
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Penjualan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

// Platform Chart
const platformCtx = document.getElementById('platformChart').getContext('2d');
const platformChart = new Chart(platformCtx, {
    type: 'doughnut',
    data: {
        labels: @json(array_keys($platformStats)),
        datasets: [{
            data: @json(array_values($platformStats)),
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});
</script>
@endpush
@endsection 