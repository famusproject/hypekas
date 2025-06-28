@extends('umkm.layouts.app')

@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Pengeluaran Baru</h1>
        <a href="{{ route('umkm.expenses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('umkm.expenses.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expense_date" class="form-label">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('expense_date') is-invalid @enderror" 
                                   id="expense_date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                            @error('expense_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Jenis Pengeluaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Pilih Jenis Pengeluaran</option>
                                <option value="Operasional" {{ old('category') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                                <option value="Marketing" {{ old('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Gaji" {{ old('category') == 'Gaji' ? 'selected' : '' }}>Gaji</option>
                                <option value="Sewa" {{ old('category') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                <option value="Utilitas" {{ old('category') == 'Utilitas' ? 'selected' : '' }}>Utilitas</option>
                                <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" name="amount" value="{{ old('amount') }}" min="0" step="1000" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Produk (Opsional)</label>
                            <select class="form-select @error('product_id') is-invalid @enderror" 
                                    id="product_id" name="product_id">
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" 
                           id="description" name="description" value="{{ old('description') }}" required>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                    <a href="{{ route('umkm.expenses.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 