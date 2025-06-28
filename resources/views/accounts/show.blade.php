@extends('layouts.app')

@section('title', 'Detail Akun')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Detail Akun</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Akun</a></li>
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
                        <i class="fas fa-wallet me-2"></i>
                        Informasi Akun
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Nama Akun:</strong></td>
                                    <td><span class="fw-bold">{{ $account->name }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tipe Akun:</strong></td>
                                    <td>
                                        @switch($account->type)
                                            @case('cash')
                                                <span class="badge bg-success">Cash</span>
                                                @break
                                            @case('bank')
                                                <span class="badge bg-primary">Bank</span>
                                                @break
                                            @case('credit_card')
                                                <span class="badge bg-warning">Kartu Kredit</span>
                                                @break
                                            @case('investment')
                                                <span class="badge bg-info">Investasi</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Saldo Saat Ini:</strong></td>
                                    <td><span class="fw-bold text-primary">Rp {{ number_format($account->balance, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi:</strong></td>
                                    <td>{{ $account->description ?: 'Tidak ada deskripsi' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Transaksi:</strong></td>
                                    <td><span class="fw-bold">{{ $account->transactions()->count() }}</span> transaksi</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Statistik Transaksi</h6>
                                    @php
                                        $totalIncome = $account->transactions()->where('type', 'income')->sum('amount');
                                        $totalExpense = $account->transactions()->where('type', 'expense')->sum('amount');
                                        $totalTransferIn = $account->transactions()->where('type', 'transfer')->where('account_id', $account->id)->sum('amount');
                                        $totalTransferOut = $account->transactions()->where('type', 'transfer')->where('transfer_account_id', $account->id)->sum('amount');
                                        $netAmount = $totalIncome - $totalExpense + $totalTransferIn - $totalTransferOut;
                                    @endphp
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <h5 class="text-success mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h5>
                                            <small class="text-muted">Total Masuk</small>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="text-danger mb-0">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h5>
                                            <small class="text-muted">Total Keluar</small>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="{{ $netAmount >= 0 ? 'text-success' : 'text-danger' }} mb-0">
                                                Rp {{ number_format($netAmount, 0, ',', '.') }}
                                            </h5>
                                            <small class="text-muted">Net</small>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h6 class="text-info mb-0">Rp {{ number_format($totalTransferIn, 0, ',', '.') }}</h6>
                                            <small class="text-muted">Transfer Masuk</small>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="text-warning mb-0">Rp {{ number_format($totalTransferOut, 0, ',', '.') }}</h6>
                                            <small class="text-muted">Transfer Keluar</small>
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
                                            <th>Kategori</th>
                                            <th>Tipe</th>
                                            <th class="text-end">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                            <td>{{ $transaction->description }}</td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $transaction->category->color }}">
                                                    {{ $transaction->category->name }}
                                                </span>
                                            </td>
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
                                <p class="text-muted mb-0">Belum ada transaksi untuk akun ini</p>
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
                <a href="{{ route('accounts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 