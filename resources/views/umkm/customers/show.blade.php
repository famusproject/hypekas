@extends('umkm.layouts.app')

@section('title', 'Detail Customer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Customer</h1>
        <div>
            <a href="{{ route('umkm.customers.edit', $customer->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('umkm.customers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Customer</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><strong>Nama Customer</strong></td>
                            <td>{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Platform</strong></td>
                            <td><span class="badge bg-primary">{{ $customer->platform }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Nomor Telepon</strong></td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ $customer->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $customer->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Catatan</strong></td>
                            <td>{{ $customer->notes ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Dibuat</strong></td>
                            <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Diupdate</strong></td>
                            <td>{{ $customer->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Penjualan</h6>
                </div>
                <div class="card-body">
                    @if($sales->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Order ID</th>
                                        <th>Produk</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                        <td><code>{{ $sale->order_id }}</code></td>
                                        <td>
                                            @if($sale->product)
                                                {{ $sale->product->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
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
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center">
                            {{ $sales->links() }}
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada riwayat penjualan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 