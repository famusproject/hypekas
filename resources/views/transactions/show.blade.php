@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Detail Transaksi</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
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
                        <i class="fas fa-receipt me-2"></i>
                        Informasi Transaksi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Deskripsi:</strong></td>
                                    <td><span class="fw-bold">{{ $transaction->description }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tipe Transaksi:</strong></td>
                                    <td>
                                        @if($transaction->type === 'income')
                                            <span class="badge bg-success">Pendapatan</span>
                                        @elseif($transaction->type === 'expense')
                                            <span class="badge bg-danger">Pengeluaran</span>
                                        @else
                                            <span class="badge bg-info">Transfer</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah:</strong></td>
                                    <td>
                                        <span class="fw-bold {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori:</strong></td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $transaction->category->color }}">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Akun:</strong></td>
                                    <td>{{ $transaction->account->name }}</td>
                                </tr>
                                @if($transaction->type === 'transfer' && $transaction->transferAccount)
                                <tr>
                                    <td><strong>Akun Tujuan:</strong></td>
                                    <td>{{ $transaction->transferAccount->name }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Dampak pada Saldo</h6>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h6 class="text-primary mb-0">{{ $transaction->account->name }}</h6>
                                            <small class="text-muted">Akun Sumber</small>
                                            <div class="mt-2">
                                                @if($transaction->type === 'income')
                                                    <span class="text-success">+ Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                                @elseif($transaction->type === 'expense')
                                                    <span class="text-danger">- Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-danger">- Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($transaction->type === 'transfer' && $transaction->transferAccount)
                                        <div class="col-6">
                                            <h6 class="text-info mb-0">{{ $transaction->transferAccount->name }}</h6>
                                            <small class="text-muted">Akun Tujuan</small>
                                            <div class="mt-2">
                                                <span class="text-success">+ Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    @if($transaction->type === 'transfer' && $transaction->transferAccount)
                                    <hr>
                                    <div class="text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-exchange-alt me-1"></i>
                                            Transfer dari {{ $transaction->account->name }} ke {{ $transaction->transferAccount->name }}
                                        </small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Informasi Tambahan</h6>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calendar fa-2x text-primary mb-2"></i>
                                        <h6 class="mb-1">Dibuat</h6>
                                        <small class="text-muted">{{ $transaction->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-edit fa-2x text-warning mb-2"></i>
                                        <h6 class="mb-1">Terakhir Diupdate</h6>
                                        <small class="text-muted">{{ $transaction->updated_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-tag fa-2x text-info mb-2"></i>
                                        <h6 class="mb-1">Tipe Kategori</h6>
                                        <small class="text-muted">{{ ucfirst($transaction->category->type) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 