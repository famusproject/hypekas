@extends('umkm.layouts.app')

@section('title', 'Daftar Pengeluaran')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pengeluaran</h1>
        <a href="{{ route('umkm.expenses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengeluaran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Pengeluaran</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('umkm.expenses.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="category" class="form-label">Jenis Pengeluaran</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Semua Jenis</option>
                                <option value="Operasional" {{ request('category') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                                <option value="Marketing" {{ request('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Gaji" {{ request('category') == 'Gaji' ? 'selected' : '' }}>Gaji</option>
                                <option value="Sewa" {{ request('category') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                <option value="Utilitas" {{ request('category') == 'Utilitas' ? 'selected' : '' }}>Utilitas</option>
                                <option value="Lainnya" {{ request('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk</label>
                            <select class="form-select" id="product_id" name="product_id">
                                <option value="">Semua Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('umkm.expenses.index') }}" class="btn btn-secondary me-2">Reset</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if($expenses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Deskripsi</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                            <tr>
                                <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-warning">{{ $expense->category }}</span>
                                </td>
                                <td>
                                    <strong>{{ $expense->description }}</strong>
                                    @if($expense->notes)
                                        <br><small class="text-muted">{{ Str::limit($expense->notes, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($expense->product)
                                        <span class="badge bg-info">{{ $expense->product->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-danger">Rp {{ number_format($expense->amount, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('umkm.expenses.show', $expense->id) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('umkm.expenses.edit', $expense->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('umkm.expenses.destroy', $expense->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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

                <div class="d-flex justify-content-center">
                    {{ $expenses->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada pengeluaran</h5>
                    <p class="text-muted">Mulai dengan mencatat pengeluaran pertama Anda.</p>
                    <a href="{{ route('umkm.expenses.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pengeluaran Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 