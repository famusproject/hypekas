@extends('umkm.layouts.app')

@section('title', 'Daftar Customer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Customer</h1>
        <a href="{{ route('umkm.customers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Customer
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
            @if($customers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Customer</th>
                                <th>Platform</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td>
                                    <strong>{{ $customer->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $customer->platform }}</span>
                                </td>
                                <td>{{ $customer->phone ?? '-' }}</td>
                                <td>{{ $customer->email ?? '-' }}</td>
                                <td>
                                    @if($customer->address)
                                        {{ Str::limit($customer->address, 50) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('umkm.customers.show', $customer->id) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('umkm.customers.edit', $customer->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('umkm.customers.destroy', $customer->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus customer ini?')">
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
                    {{ $customers->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada customer</h5>
                    <p class="text-muted">Mulai dengan menambahkan customer pertama Anda.</p>
                    <a href="{{ route('umkm.customers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Customer Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 