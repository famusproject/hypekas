<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'selling_price',
        'cost_price',
        'stock',
        'category_id',
        'supplier_id',
        'description',
        'is_active',
        'user_id'
    ];

    protected $casts = [
        'selling_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Hitung margin profit
    public function getProfitMarginAttribute()
    {
        if ($this->selling_price > 0) {
            return (($this->selling_price - $this->cost_price) / $this->selling_price) * 100;
        }
        return 0;
    }

    // Hitung profit per unit
    public function getProfitPerUnitAttribute()
    {
        return $this->selling_price - $this->cost_price;
    }
}
