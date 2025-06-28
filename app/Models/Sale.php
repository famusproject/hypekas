<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'product_name',
        'qty',
        'price_per_unit',
        'total_price',
        'platform',
        'status',
        'alasan_batal',
        'alasan_retur',
        'tanggal_retur',
        'biaya_iklan',
        'customer_id',
        'notes',
        'sale_date',
        'user_id'
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
        'biaya_iklan' => 'decimal:2',
        'sale_date' => 'date',
        'tanggal_retur' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope untuk order selesai
    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }

    // Scope untuk order batal
    public function scopeCancelled($query)
    {
        return $query->where('status', 'batal');
    }

    // Scope untuk order retur
    public function scopeReturned($query)
    {
        return $query->where('status', 'retur');
    }

    // Scope untuk filter berdasarkan platform
    public function scopeByPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('sale_date', [$startDate, $endDate]);
    }

    // Hitung profit dari penjualan
    public function getProfitAttribute()
    {
        // Asumsi cost price 60% dari selling price (bisa disesuaikan)
        $costPrice = $this->price_per_unit * 0.6;
        $profitPerUnit = $this->price_per_unit - $costPrice;
        return $profitPerUnit * $this->qty;
    }

    // Hitung ROAS untuk order ini
    public function getRoasAttribute()
    {
        if ($this->biaya_iklan > 0) {
            return $this->total_price / $this->biaya_iklan;
        }
        return 0;
    }
}
