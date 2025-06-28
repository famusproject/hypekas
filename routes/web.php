<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UmkmDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect root to UMKM dashboard
Route::get('/', function () {
    return redirect()->route('umkm.dashboard');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // UMKM Marketplace Routes
    Route::prefix('umkm')->name('umkm.')->group(function () {
        // Dashboard UMKM
        Route::get('/dashboard', [UmkmDashboardController::class, 'index'])->name('dashboard');
        // Products
        Route::resource('products', ProductController::class);
        Route::get('/products/{product}/details', [ProductController::class, 'getProductDetails'])->name('products.details');
        // Suppliers
        Route::resource('suppliers', SupplierController::class);
        // Customers
        Route::resource('customers', CustomerController::class);
        // Sales
        Route::resource('sales', SaleController::class);
        // Expenses
        Route::resource('expenses', ExpenseController::class);
        // Reports
        Route::get('/reports/profit-loss', [App\Http\Controllers\ReportController::class, 'profitLoss'])->name('reports.profit-loss');
        Route::get('/reports/returns-cancellations', [App\Http\Controllers\ReportController::class, 'returnsCancellations'])->name('reports.returns-cancellations');
        Route::get('/reports/cashflow', [App\Http\Controllers\ReportController::class, 'cashflow'])->name('reports.cashflow');
        Route::get('/reports/roas', [App\Http\Controllers\ReportController::class, 'roas'])->name('reports.roas');
    });
});
