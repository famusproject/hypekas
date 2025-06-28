@extends('umkm.layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Penjualan</h1>
        <a href="{{ route('umkm.sales.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Penjualan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            @if($sales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Total</th>
                                <th>Platform</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                <td>
                                    <code>{{ $sale->order_id }}</code>
                                </td>
                                <td>
                                    @if($sale->customer)
                                        <strong>{{ $sale->customer->name }}</strong>
                                        <br><small class="text-muted">{{ $sale->customer->platform }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sale->product)
                                        <strong>{{ $sale->product->name }}</strong>
                                        <br><small class="text-muted">{{ $sale->product->sku }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $sale->quantity }}</span>
                                </td>
                                <td>
                                    Rp {{ number_format($sale->unit_price, 0, ',', '.') }}
                                </td>
                                <td>
                                    <strong class="text-success">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $sale->platform }}</span>
                                </td>
                                <td>
                                    @if($sale->status == 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($sale->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($sale->status == 'cancelled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @elseif($sale->status == 'returned')
                                        <span class="badge bg-secondary">Dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('umkm.sales.show', $sale->id) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('umkm.sales.edit', $sale->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('umkm.sales.destroy', $sale->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus penjualan ini?')">
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
                    {{ $sales->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada penjualan</h5>
                    <p class="text-muted">Mulai dengan mencatat penjualan pertama Anda.</p>
                    <a href="{{ route('umkm.sales.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Penjualan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 