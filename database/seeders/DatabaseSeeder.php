<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        $user = User::create([
            'name' => 'Admin UMKM',
            'email' => 'admin@hypekas.com',
            'password' => Hash::make('password'),
        ]);

        // Create suppliers
        $suppliers = [
            ['name' => 'PT Supplier Utama', 'contact_person' => 'Budi Santoso', 'phone' => '08123456789', 'email' => 'budi@supplier.com', 'address' => 'Jl. Supplier No. 1, Jakarta'],
            ['name' => 'CV Distributor Jaya', 'contact_person' => 'Siti Aminah', 'phone' => '08187654321', 'email' => 'siti@distributor.com', 'address' => 'Jl. Distributor No. 2, Bandung'],
            ['name' => 'UD Grosir Makmur', 'contact_person' => 'Ahmad Rizki', 'phone' => '08111222333', 'email' => 'ahmad@grosir.com', 'address' => 'Jl. Grosir No. 3, Surabaya'],
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create(array_merge($supplierData, ['user_id' => $user->id]));
        }

        // Create products
        $products = [
            [
                'name' => 'Smartphone Android',
                'sku' => 'PHONE-001',
                'description' => 'Smartphone Android terbaru dengan kamera 48MP',
                'cost_price' => 1500000,
                'selling_price' => 2000000,
                'stock' => 50,
                'supplier_id' => 1,
                'user_id' => $user->id
            ],
            [
                'name' => 'Laptop Gaming',
                'sku' => 'LAPTOP-001',
                'description' => 'Laptop gaming dengan GPU RTX 3060',
                'cost_price' => 8000000,
                'selling_price' => 12000000,
                'stock' => 20,
                'supplier_id' => 2,
                'user_id' => $user->id
            ],
            [
                'name' => 'Headphone Wireless',
                'sku' => 'AUDIO-001',
                'description' => 'Headphone wireless dengan noise cancelling',
                'cost_price' => 500000,
                'selling_price' => 800000,
                'stock' => 100,
                'supplier_id' => 3,
                'user_id' => $user->id
            ],
            [
                'name' => 'Smartwatch',
                'sku' => 'WATCH-001',
                'description' => 'Smartwatch dengan fitur kesehatan',
                'cost_price' => 800000,
                'selling_price' => 1200000,
                'stock' => 75,
                'supplier_id' => 1,
                'user_id' => $user->id
            ],
            [
                'name' => 'Tablet Android',
                'sku' => 'TABLET-001',
                'description' => 'Tablet Android 10 inch dengan stylus',
                'cost_price' => 2000000,
                'selling_price' => 3000000,
                'stock' => 30,
                'supplier_id' => 2,
                'user_id' => $user->id
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create customers
        $customers = [
            ['name' => 'John Doe', 'phone' => '08111111111', 'email' => 'john@email.com', 'address' => 'Jl. Customer No. 1, Jakarta'],
            ['name' => 'Jane Smith', 'phone' => '08222222222', 'email' => 'jane@email.com', 'address' => 'Jl. Customer No. 2, Bandung'],
            ['name' => 'Bob Johnson', 'phone' => '08333333333', 'email' => 'bob@email.com', 'address' => 'Jl. Customer No. 3, Surabaya'],
            ['name' => 'Alice Brown', 'phone' => '08444444444', 'email' => 'alice@email.com', 'address' => 'Jl. Customer No. 4, Medan'],
            ['name' => 'Charlie Wilson', 'phone' => '08555555555', 'email' => 'charlie@email.com', 'address' => 'Jl. Customer No. 5, Semarang'],
        ];

        foreach ($customers as $customerData) {
            Customer::create(array_merge($customerData, ['user_id' => $user->id]));
        }

        // Create sales
        $platforms = ['Shopee', 'Tokopedia', 'Lazada', 'Instagram', 'Website'];
        $statuses = ['completed', 'pending', 'cancelled', 'returned'];
        
        for ($i = 0; $i < 50; $i++) {
            $product = Product::inRandomOrder()->first();
            $customer = Customer::inRandomOrder()->first();
            $quantity = rand(1, 5);
            $unitPrice = $product->selling_price;
            $totalAmount = $quantity * $unitPrice;
            $marketingCost = rand(50000, 200000);
            
            Sale::create([
                'order_id' => 'ORD-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'product_id' => $product->id,
                'customer_id' => $customer->id,
                'platform' => $platforms[array_rand($platforms)],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_amount' => $totalAmount,
                'marketing_cost' => $marketingCost,
                'shipping_cost' => rand(10000, 50000),
                'status' => $statuses[array_rand($statuses)],
                'sale_date' => now()->subDays(rand(0, 180)),
                'user_id' => $user->id
            ]);
        }

        // Create expenses
        $expenseTypes = ['Operasional', 'Marketing', 'Gaji', 'Sewa', 'Utilitas', 'Lainnya'];
        
        for ($i = 0; $i < 30; $i++) {
            $product = Product::inRandomOrder()->first();
            
            Expense::create([
                'expense_date' => now()->subDays(rand(0, 90)),
                'category' => $expenseTypes[array_rand($expenseTypes)],
                'amount' => rand(100000, 2000000),
                'description' => 'Pengeluaran ' . $expenseTypes[array_rand($expenseTypes)] . ' ' . ($i + 1),
                'product_id' => rand(0, 1) ? $product->id : null,
                'notes' => 'Catatan pengeluaran ' . ($i + 1),
                'user_id' => $user->id
            ]);
        }
    }
}
