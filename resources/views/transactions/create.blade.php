@extends('layouts.app')

@section('title', 'Tambah Transaksi - HypeKas')

@section('page-title', 'Tambah Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Transaksi Baru
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipe Transaksi <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type"
                                required>
                                <option value="">Pilih Tipe</option>
                                <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Pendapatan
                                </option>
                                <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Pengeluaran
                                </option>
                                <option value="transfer" {{ old('type') === 'transfer' ? 'selected' : '' }}>Transfer
                                </option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required>
                            </div>
                            @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Kategori <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="account_id" class="form-label">Akun <span class="text-danger">*</span></label>
                            <select class="form-select @error('account_id') is-invalid @enderror" id="account_id"
                                name="account_id" required>
                                <option value="">Pilih Akun</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}"
                                    {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('account_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3" id="transfer_account_div" style="display: none;">
                            <label for="transfer_account_id" class="form-label">Akun Tujuan Transfer</label>
                            <select class="form-select @error('transfer_account_id') is-invalid @enderror"
                                id="transfer_account_id" name="transfer_account_id">
                                <option value="">Pilih Akun Tujuan</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}"
                                    {{ old('transfer_account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('transfer_account_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('type').addEventListener('change', function() {
    const transferDiv = document.getElementById('transfer_account_div');
    if (this.value === 'transfer') {
        transferDiv.style.display = 'block';
        document.getElementById('transfer_account_id').required = true;
    } else {
        transferDiv.style.display = 'none';
        document.getElementById('transfer_account_id').required = false;
    }
});
</script>
@endsection