@extends('umkm.layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Produk</h1>
        <div>
            <a href="{{ route('umkm.products.edit', $product->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('umkm.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Produk</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nama Produk</strong></td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>SKU</strong></td>
                                    <td><code>{{ $product->sku }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Supplier</strong></td>
                                    <td>
                                        @if($product->supplier)
                                            <a href="{{ route('umkm.suppliers.show', $product->supplier->id) }}" class="text-decoration-none">
                                                {{ $product->supplier->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Stok</strong></td>
                                    <td>
                                        @if($product->stock > 0)
                                            <span class="badge bg-success">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Habis</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Harga Beli</strong></td>
                                    <td><span class="text-danger">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Jual</strong></td>
                                    <td><span class="text-success">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Margin</strong></td>
                                    <td>
                                        @php
                                            $margin = $product->selling_price - $product->cost_price;
                                            $marginPercentage = $product->cost_price > 0 ? ($margin / $product->cost_price) * 100 : 0;
                                        @endphp
                                        <span class="text-info">Rp {{ number_format($margin, 0, ',', '.') }} ({{ number_format($marginPercentage, 1) }}%)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($product->description)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6><strong>Deskripsi:</strong></h6>
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="15%"><strong>Dibuat</strong></td>
                                    <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate</strong></td>
                                    <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
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
                        <a href="{{ route('umkm.products.edit', $product->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Produk
                        </a>
                        <a href="{{ route('umkm.sales.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Penjualan
                        </a>
                        <form action="{{ route('umkm.products.destroy', $product->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-success">{{ $product->sales()->count() }}</h4>
                            <small class="text-muted">Total Penjualan</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info">{{ $product->expenses()->count() }}</h4>
                            <small class="text-muted">Total Pengeluaran</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 