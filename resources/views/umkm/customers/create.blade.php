@extends('umkm.layouts.app')

@section('title', 'Tambah Customer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Customer Baru</h1>
        <a href="{{ route('umkm.customers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('umkm.customers.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Customer <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
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
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
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
                    <a href="{{ route('umkm.customers.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 