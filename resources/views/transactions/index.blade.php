@extends('layouts.app')

@section('title', 'Transaksi - HypeKas')

@section('page-title', 'Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Daftar Transaksi
                </h5>
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Transaksi
                </a>
            </div>
            <div class="card-body">
                @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Akun</th>
                                    <th>Tipe</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $transaction->description }}</span>
                                        @if($transaction->type === 'transfer' && $transaction->transferAccount)
                                            <br><small class="text-muted">→ {{ $transaction->transferAccount->name }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $transaction->category->color }}">
                                            {{ $transaction->category->name }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->account->name }}</td>
                                    <td>
                                        <span class="badge {{ $transaction->type === 'income' ? 'bg-success' : ($transaction->type === 'expense' ? 'bg-danger' : 'bg-info') }}">
                                            {{ $transaction->type === 'income' ? 'Pendapatan' : ($transaction->type === 'expense' ? 'Pengeluaran' : 'Transfer') }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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
                    <div class="text-center py-5">
                        <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada transaksi</h5>
                        <p class="text-muted">Mulai dengan menambahkan transaksi keuangan Anda</p>
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Transaksi Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 