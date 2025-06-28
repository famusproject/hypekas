@extends('layouts.app')

@section('title', 'Tambah Akun - HypeKas')

@section('page-title', 'Tambah Akun')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Akun Baru
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('accounts.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Akun <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipe Akun <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Pilih Tipe</option>
                                <option value="cash" {{ old('type') === 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank" {{ old('type') === 'bank' ? 'selected' : '' }}>Bank</option>
                                <option value="credit_card" {{ old('type') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="investment" {{ old('type') === 'investment' ? 'selected' : '' }}>Investment</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="balance" class="form-label">Saldo Awal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('balance') is-invalid @enderror" 
                                       id="balance" name="balance" value="{{ old('balance', 0) }}" step="0.01" min="0" required>
                            </div>
                            @error('balance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('accounts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 