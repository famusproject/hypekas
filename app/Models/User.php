<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke model-model keuangan (sistem lama)
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    // Relasi ke model-model UMKM marketplace (sistem baru)
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Method untuk menghitung total penjualan selesai
    public function getTotalSalesAttribute()
    {
        return $this->sales()->completed()->sum('total_price');
    }

    // Method untuk menghitung total pengeluaran
    public function getTotalExpensesAttribute()
    {
        return $this->expenses()->sum('amount');
    }

    // Method untuk menghitung laba bersih
    public function getNetProfitAttribute()
    {
        return $this->total_sales - $this->total_expenses;
    }

    // Method untuk menghitung ROAS
    public function getRoasAttribute()
    {
        $totalAdSpend = $this->sales()->sum('biaya_iklan');
        if ($totalAdSpend > 0) {
            return $this->total_sales / $totalAdSpend;
        }
        return 0;
    }
}
