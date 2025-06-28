@extends('umkm.layouts.app')

@section('title', 'Detail Pengeluaran')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengeluaran</h1>
        <div>
            <a href="{{ route('umkm.expenses.edit', $expense->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('umkm.expenses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengeluaran</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Tanggal</strong></td>
                                    <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Pengeluaran</strong></td>
                                    <td><span class="badge bg-warning">{{ $expense->category }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah</strong></td>
                                    <td><strong class="text-danger">Rp {{ number_format($expense->amount, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Deskripsi</strong></td>
                                    <td>{{ $expense->description }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Produk</strong></td>
                                    <td>
                                        @if($expense->product)
                                            <a href="{{ route('umkm.products.show', $expense->product->id) }}" class="text-decoration-none">
                                                {{ $expense->product->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Catatan</strong></td>
                                    <td>{{ $expense->notes ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dibuat</strong></td>
                                    <td>{{ $expense->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate</strong></td>
                                    <td>{{ $expense->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('umkm.expenses.edit', $expense->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Pengeluaran
                        </a>
                        <form action="{{ route('umkm.expenses.destroy', $expense->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Hapus Pengeluaran
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 