@extends('layouts.app')

@section('title', 'Detail Anggaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Detail Anggaran</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('budgets.index') }}">Anggaran</a></li>
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
                        <i class="fas fa-chart-pie me-2"></i>
                        Informasi Anggaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150"><strong>Kategori:</strong></td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $budget->category->color }}">
                                            {{ $budget->category->name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Anggaran:</strong></td>
                                    <td><span class="fw-bold text-primary">Rp {{ number_format($budget->amount, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Periode:</strong></td>
                                    <td><span class="badge bg-info">{{ ucfirst($budget->period) }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Mulai:</strong></td>
                                    <td>{{ $budget->start_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Selesai:</strong></td>
                                    <td>{{ $budget->end_date->format('d/m/Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Progress Pengeluaran</h6>
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Pengeluaran Aktual</span>
                                            <span class="fw-bold">Rp {{ number_format($actualExpense, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $percentage = min(100, ($actualExpense / $budget->amount) * 100);
                                                $progressClass = $percentage > 80 ? 'bg-danger' : ($percentage > 60 ? 'bg-warning' : 'bg-success');
                                            @endphp
                                            <div class="progress-bar {{ $progressClass }}" role="progressbar" 
                                                 style="width: {{ $percentage }}%" 
                                                 aria-valuenow="{{ $percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border-end">
                                                <h5 class="text-success mb-0">Rp {{ number_format($remainingBudget, 0, ',', '.') }}</h5>
                                                <small class="text-muted">Sisa Anggaran</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="text-info mb-0">{{ number_format($percentageUsed, 1) }}%</h5>
                                            <small class="text-muted">Terpakai</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Riwayat Transaksi dalam Periode Anggaran</h6>
                            <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Transaksi
                            </a>
                        </div>
                        
                        @php
                            $transactions = Auth::user()->transactions()
                                ->where('category_id', $budget->category_id)
                                ->where('type', 'expense')
                                ->whereBetween('date', [$budget->start_date, $budget->end_date])
                                ->orderBy('date', 'desc')
                                ->get();
                        @endphp

                        @if($transactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Deskripsi</th>
                                            <th>Akun</th>
                                            <th class="text-end">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                            <td>{{ $transaction->description }}</td>
                                            <td>{{ $transaction->account->name }}</td>
                                            <td class="text-end text-danger">
                                                - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-receipt fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada transaksi dalam periode anggaran ini</p>
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
                <a href="{{ route('budgets.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 