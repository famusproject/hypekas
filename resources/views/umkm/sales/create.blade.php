@extends('umkm.layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Penjualan Baru</h1>
        <a href="{{ route('umkm.sales.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('umkm.sales.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sale_date" class="form-label">Tanggal Penjualan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('sale_date') is-invalid @enderror" 
                                   id="sale_date" name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" required>
                            @error('sale_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="order_number" class="form-label">Order Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('order_number') is-invalid @enderror" 
                                   id="order_number" name="order_number" value="{{ old('order_number') }}" required>
                            @error('order_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk <span class="text-danger">*</span></label>
                            <select class="form-select @error('product_id') is-invalid @enderror" 
                                    id="product_id" name="product_id" required>
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-select @error('customer_id') is-invalid @enderror" 
                                    id="customer_id" name="customer_id">
                                <option value="">Pilih Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="qty" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" 
                                   id="qty" name="qty" value="{{ old('qty', 1) }}" min="1" required>
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="price_per_unit" class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('price_per_unit') is-invalid @enderror" 
                                       id="price_per_unit" name="price_per_unit" value="{{ old('price_per_unit') }}" min="0" step="1000" required>
                            </div>
                            @error('price_per_unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="platform" class="form-label">Platform <span class="text-danger">*</span></label>
                            <select class="form-select @error('platform') is-invalid @enderror" 
                                    id="platform" name="platform" required>
                                <option value="">Pilih Platform</option>
                                <option value="Shopee" {{ old('platform') == 'Shopee' ? 'selected' : '' }}>Shopee</option>
                                <option value="Tokopedia" {{ old('platform') == 'Tokopedia' ? 'selected' : '' }}>Tokopedia</option>
                                <option value="Lazada" {{ old('platform') == 'Lazada' ? 'selected' : '' }}>Lazada</option>
                                <option value="Bukalapak" {{ old('platform') == 'Bukalapak' ? 'selected' : '' }}>Bukalapak</option>
                                <option value="Blibli" {{ old('platform') == 'Blibli' ? 'selected' : '' }}>Blibli</option>
                                <option value="Instagram" {{ old('platform') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                                <option value="Facebook" {{ old('platform') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                <option value="WhatsApp" {{ old('platform') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="Offline" {{ old('platform') == 'Offline' ? 'selected' : '' }}>Offline</option>
                                <option value="Lainnya" {{ old('platform') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('platform')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                                <option value="retur" {{ old('status') == 'retur' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="shipping_cost" class="form-label">Biaya Pengiriman</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('shipping_cost') is-invalid @enderror" 
                                       id="shipping_cost" name="shipping_cost" value="{{ old('shipping_cost', 0) }}" min="0" step="1000">
                            </div>
                            @error('shipping_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('umkm.sales.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Penjualan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 