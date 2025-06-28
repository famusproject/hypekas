@extends('umkm.layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Penjualan</h1>
        <div>
            <a href="{{ route('umkm.sales.edit', $sale->id) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('umkm.sales.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Penjualan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Tanggal</strong></td>
                                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Order ID</strong></td>
                                    <td><code>{{ $sale->order_id }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Produk</strong></td>
                                    <td>
                                        @if($sale->product)
                                            <a href="{{ route('umkm.products.show', $sale->product->id) }}" class="text-decoration-none">
                                                {{ $sale->product->name }}
                                            </a>
                                            <br><small class="text-muted">{{ $sale->product->sku }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Customer</strong></td>
                                    <td>
                                        @if($sale->customer)
                                            <a href="{{ route('umkm.customers.show', $sale->customer->id) }}" class="text-decoration-none">
                                                {{ $sale->customer->name }}
                                            </a>
                                            <br><small class="text-muted">{{ $sale->customer->platform }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Jumlah</strong></td>
                                    <td><span class="badge bg-primary">{{ $sale->quantity }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Harga Satuan</strong></td>
                                    <td>Rp {{ number_format($sale->unit_price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong class="text-success">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Platform</strong></td>
                                    <td><span class="badge bg-info">{{ $sale->platform }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
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
                            </table>
                        </div>
                    </div>

                    @if($sale->shipping_cost > 0)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6><strong>Biaya Pengiriman:</strong> Rp {{ number_format($sale->shipping_cost, 0, ',', '.') }}</h6>
                        </div>
                    </div>
                    @endif

                    @if($sale->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6><strong>Catatan:</strong></h6>
                            <p>{{ $sale->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="15%"><strong>Dibuat</strong></td>
                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Diupdate</strong></td>
                                    <td>{{ $sale->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('umkm.sales.edit', $sale->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Penjualan
                        </a>
                        <form action="{{ route('umkm.sales.destroy', $sale->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus penjualan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Hapus Penjualan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Perhitungan Keuntungan</h6>
                </div>
                <div class="card-body">
                    @if($sale->product)
                        @php
                            $cost = $sale->product->cost_price * $sale->quantity;
                            $revenue = $sale->total_amount;
                            $profit = $revenue - $cost;
                            $profitMargin = $revenue > 0 ? ($profit / $revenue) * 100 : 0;
                        @endphp
                        <div class="row text-center">
                            <div class="col-6">
                                <h6 class="text-danger">Rp {{ number_format($cost, 0, ',', '.') }}</h6>
                                <small class="text-muted">Total Biaya</small>
                            </div>
                            <div class="col-6">
                                <h6 class="text-success">Rp {{ number_format($revenue, 0, ',', '.') }}</h6>
                                <small class="text-muted">Total Pendapatan</small>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <h5 class="{{ $profit >= 0 ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($profit, 0, ',', '.') }}
                            </h5>
                            <small class="text-muted">Keuntungan ({{ number_format($profitMargin, 1) }}%)</small>
                        </div>
                    @else
                        <p class="text-muted text-center">Tidak dapat menghitung keuntungan karena produk tidak ditemukan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 