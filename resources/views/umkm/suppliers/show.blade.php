@extends('umkm.layouts.app')

@section('title', 'Detail Supplier')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Supplier</h1>
        <div>
            <a href="{{ route('umkm.suppliers.edit', $supplier->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('umkm.suppliers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Supplier</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Nama Supplier</strong></td>
                            <td>{{ $supplier->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Contact Person</strong></td>
                            <td>{{ $supplier->contact_person ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nomor Telepon</strong></td>
                            <td>{{ $supplier->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ $supplier->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $supplier->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Catatan</strong></td>
                            <td>{{ $supplier->notes ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat</strong></td>
                            <td>{{ $supplier->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Diupdate</strong></td>
                            <td>{{ $supplier->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produk dari Supplier Ini</h6>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>SKU</th>
                                        <th>Stok</th>
                                        <th>Harga Jual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <a href="{{ route('umkm.products.show', $product->id) }}" class="text-decoration-none">
                                                {{ $product->name }}
                                            </a>
                                        </td>
                                        <td><code>{{ $product->sku }}</code></td>
                                        <td>
                                            @if($product->stock > 0)
                                                <span class="badge bg-success">{{ $product->stock }}</span>
                                            @else
                                                <span class="badge bg-danger">Habis</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-box fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada produk dari supplier ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 