@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Detail Kategori</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tag me-2"></i>
                        Informasi Kategori
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Nama:</strong></td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $category->color }}">
                                            {{ $category->name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tipe:</strong></td>
                                    <td>
                                        @if($category->type === 'income')
                                            <span class="badge bg-success">Pendapatan</span>
                                        @else
                                            <span class="badge bg-danger">Pengeluaran</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi:</strong></td>
                                    <td>{{ $category->description ?: 'Tidak ada deskripsi' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Warna:</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="color-preview me-2" style="width: 20px; height: 20px; background-color: {{ $category->color }}; border-radius: 4px;"></div>
                                            <span>{{ $category->color }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total Transaksi:</strong></td>
                                    <td><span class="fw-bold">{{ $category->transactions()->count() }}</span> transaksi</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Statistik Transaksi</h6>
                                    @php
                                        $totalIncome = $category->transactions()->where('type', 'income')->sum('amount');
                                        $totalExpense = $category->transactions()->where('type', 'expense')->sum('amount');
                                        $netAmount = $totalIncome - $totalExpense;
                                    @endphp
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <h5 class="text-success mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h5>
                                            <small class="text-muted">Total Pendapatan</small>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="text-danger mb-0">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h5>
                                            <small class="text-muted">Total Pengeluaran</small>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="{{ $netAmount >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                                                Rp {{ number_format($netAmount, 0, ',', '.') }}
                                            </h5>
                                            <small class="text-muted">Net</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Riwayat Transaksi</h6>
                            <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Transaksi
                            </a>
                        </div>
                        
                        @if($transactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Deskripsi</th>
                                            <th>Akun</th>
                                            <th>Tipe</th>
                                            <th class="text-end">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                            <td>{{ $transaction->description }}</td>
                                            <td>{{ $transaction->account->name }}</td>
                                            <td>
                                                @if($transaction->type === 'income')
                                                    <span class="badge bg-success">Pendapatan</span>
                                                @elseif($transaction->type === 'expense')
                                                    <span class="badge bg-danger">Pengeluaran</span>
                                                @else
                                                    <span class="badge bg-info">Transfer</span>
                                                @endif
                                            </td>
                                            <td class="text-end {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $transactions->links() }}
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada transaksi untuk kategori ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 