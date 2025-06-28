@extends('umkm.layouts.app')

@section('title', 'Daftar Supplier')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Supplier</h1>
        <a href="{{ route('umkm.suppliers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Supplier
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            @if($suppliers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Supplier</th>
                                <th>Contact Person</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $supplier)
                            <tr>
                                <td>
                                    <strong>{{ $supplier->name }}</strong>
                                </td>
                                <td>{{ $supplier->contact_person ?? '-' }}</td>
                                <td>{{ $supplier->phone ?? '-' }}</td>
                                <td>{{ $supplier->email ?? '-' }}</td>
                                <td>
                                    @if($supplier->address)
                                        {{ Str::limit($supplier->address, 50) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('umkm.suppliers.show', $supplier->id) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('umkm.suppliers.edit', $supplier->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('umkm.suppliers.destroy', $supplier->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
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
                    {{ $suppliers->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada supplier</h5>
                    <p class="text-muted">Mulai dengan menambahkan supplier pertama Anda.</p>
                    <a href="{{ route('umkm.suppliers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Supplier Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 