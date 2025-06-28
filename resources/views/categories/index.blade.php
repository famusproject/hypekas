@extends('layouts.app')

@section('title', 'Kategori - HypeKas')

@section('page-title', 'Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-tags me-2"></i>
                    Daftar Kategori
                </h5>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Kategori
                </a>
            </div>
            <div class="card-body">
                @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tipe</th>
                                    <th>Deskripsi</th>
                                    <th>Warna</th>
                                    <th>Jumlah Transaksi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $category->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $category->type === 'income' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $category->type === 'income' ? 'Pendapatan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td>{{ $category->description ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2" style="width: 20px; height: 20px; background-color: {{ $category->color }}; border-radius: 4px;"></div>
                                            <span class="small">{{ $category->color }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $category->transactions->count() }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada kategori</h5>
                        <p class="text-muted">Mulai dengan menambahkan kategori untuk transaksi Anda</p>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Kategori Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 