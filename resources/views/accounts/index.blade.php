@extends('layouts.app')

@section('title', 'Akun - HypeKas')

@section('page-title', 'Akun')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-wallet me-2"></i>
                    Daftar Akun
                </h5>
                <a href="{{ route('accounts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Akun
                </a>
            </div>
            <div class="card-body">
                @if($accounts->count() > 0)
                    <div class="row">
                        @foreach($accounts as $account)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="card-title mb-1">{{ $account->name }}</h6>
                                            <span class="badge bg-secondary">{{ ucfirst($account->type) }}</span>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('accounts.show', $account->id) }}">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('accounts.edit', $account->id) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h4 class="mb-0 {{ $account->balance >= 0 ? 'text-success' : 'text-danger' }}">
                                            Rp {{ number_format($account->balance, 0, ',', '.') }}
                                        </h4>
                                        <small class="text-muted">Saldo saat ini</small>
                                    </div>
                                    
                                    @if($account->description)
                                        <p class="card-text text-muted small">{{ $account->description }}</p>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-exchange-alt me-1"></i>
                                            {{ $account->transactions->count() }} transaksi
                                        </small>
                                        <small class="text-muted">
                                            Dibuat: {{ $account->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada akun</h5>
                        <p class="text-muted">Mulai dengan menambahkan akun untuk mengelola keuangan Anda</p>
                        <a href="{{ route('accounts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Akun Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 