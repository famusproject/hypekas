<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UmkmDashboardController extends Controller
{
    /**
     * Display the UMKM dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistik bulan ini
        $currentMonth = Carbon::now()->startOfMonth();
        $monthlySales = $user->sales()
            ->where('status', 'completed')
            ->whereMonth('sale_date', $currentMonth->month)
            ->whereYear('sale_date', $currentMonth->year)
            ->sum('total_price');
            
        $monthlyExpenses = $user->expenses()
            ->whereMonth('expense_date', $currentMonth->month)
            ->whereYear('expense_date', $currentMonth->year)
            ->sum('amount');
            
        $monthlyProfit = $monthlySales - $monthlyExpenses;
        
        // ROAS (Return on Ad Spend) - menggunakan biaya marketing
        $marketingExpenses = $user->expenses()
            ->where('category', 'Marketing')
            ->whereMonth('expense_date', $currentMonth->month)
            ->whereYear('expense_date', $currentMonth->year)
            ->sum('amount');
            
        $roas = $marketingExpenses > 0 ? $monthlySales / $marketingExpenses : 0;
        
        // Data untuk grafik penjualan 6 bulan terakhir
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyTotal = $user->sales()
                ->where('status', 'completed')
                ->whereYear('sale_date', $date->year)
                ->whereMonth('sale_date', $date->month)
                ->sum('total_price');
            
            $chartLabels[] = $date->format('M Y');
            $chartData[] = $monthlyTotal;
        }
        
        // Penjualan per platform
        $platformStats = $user->sales()
            ->where('status', 'completed')
            ->selectRaw('platform, SUM(total_price) as total_sales')
            ->groupBy('platform')
            ->pluck('total_sales', 'platform')
            ->toArray();
        
        // Top products berdasarkan penjualan
        $topProducts = $user->sales()
            ->where('status', 'completed')
            ->with('product')
            ->selectRaw('product_id, SUM(qty) as total_sold, SUM(total_price) as total_revenue')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        // Recent sales
        $recentSales = $user->sales()
            ->with(['product', 'customer'])
            ->orderBy('sale_date', 'desc')
            ->limit(10)
            ->get();
        
        return view('umkm.dashboard.index', compact(
            'monthlySales',
            'monthlyExpenses',
            'monthlyProfit',
            'roas',
            'chartLabels',
            'chartData',
            'platformStats',
            'topProducts',
            'recentSales'
        ));
    }
}
