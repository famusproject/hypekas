<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'amount',
        'expense_date',
        'description',
        'payment_method',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }

    // Scope untuk biaya iklan
    public function scopeAdvertising($query)
    {
        return $query->where('category', 'iklan');
    }

    // Scope untuk gaji
    public function scopeSalary($query)
    {
        return $query->where('category', 'gaji');
    }

    // Scope untuk stok
    public function scopeStock($query)
    {
        return $query->where('category', 'stok');
    }
}
