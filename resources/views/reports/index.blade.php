@extends('layouts.app')

@section('title', 'Laporan Keuangan - HypeKas')

@section('page-title', 'Laporan Keuangan')

@section('content')
<div class="row">
    <!-- Ringkasan -->
    <div class="col-lg-4 mb-4">
        <div class="card stat-card income h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Total Pendapatan</h6>
                        <h3 class="mb-0 text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                    </div>
                    <div class="text-white-50">
                        <i class="fas fa-arrow-up fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card stat-card expense h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Total Pengeluaran</h6>
                        <h3 class="mb-0 text-white">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                    </div>
                    <div class="text-white-50">
                        <i class="fas fa-arrow-down fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">Saldo Bersih</h6>
                        <h3 class="mb-0 text-white {{ $netIncome >= 0 ? '' : 'text-warning' }}">
                            Rp {{ number_format($netIncome, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="text-white-50">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pengeluaran per Kategori -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Pengeluaran per Kategori
                </h5>
            </div>
            <div class="card-body">
                @if($expensesByCategory->count() > 0)
                    @foreach($expensesByCategory as $data)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-2" style="width: 12px; height: 12px; background-color: {{ $data['category']->color }}; border-radius: 50%;"></div>
                            <span class="fw-medium">{{ $data['category']->name }}</span>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-danger">Rp {{ number_format($data['total'], 0, ',', '.') }}</div>
                            <small class="text-muted">{{ $data['count'] }} transaksi</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-pie fa-2x text-muted mb-2"></i>
                        <p class="text-muted small">Belum ada data pengeluaran</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Pendapatan per Kategori -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Pendapatan per Kategori
                </h5>
            </div>
            <div class="card-body">
                @if($incomeByCategory->count() > 0)
                    @foreach($incomeByCategory as $data)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="me-2" style="width: 12px; height: 12px; background-color: {{ $data['category']->color }}; border-radius: 50%;"></div>
                            <span class="fw-medium">{{ $data['category']->name }}</span>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">Rp {{ number_format($data['total'], 0, ',', '.') }}</div>
                            <small class="text-muted">{{ $data['count'] }} transaksi</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-bar fa-2x text-muted mb-2"></i>
                        <p class="text-muted small">Belum ada data pendapatan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 