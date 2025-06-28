<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Auth::user()->sales()
            ->with(['product', 'customer'])
            ->orderBy('sale_date', 'desc')
            ->paginate(15);
            
        return view('umkm.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Auth::user()->products()->where('is_active', true)->orderBy('name')->get();
        $customers = Auth::user()->customers()->orderBy('name')->get();
        return view('umkm.sales.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'order_number' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'nullable|exists:customers,id',
            'qty' => 'required|integer|min:1',
            'price_per_unit' => 'required|numeric|min:0',
            'platform' => 'required|string|max:255',
            'status' => 'required|in:selesai,batal,retur',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);
        $totalPrice = ($request->qty * $request->price_per_unit) + ($request->shipping_cost ?? 0);

        $data = [
            'sale_date' => $request->sale_date,
            'order_number' => $request->order_number,
            'product_id' => $request->product_id,
            'product_name' => $product->name,
            'customer_id' => $request->customer_id,
            'qty' => $request->qty,
            'price_per_unit' => $request->price_per_unit,
            'total_price' => $totalPrice,
            'platform' => $request->platform,
            'status' => $request->status,
            'shipping_cost' => $request->shipping_cost,
            'notes' => $request->notes,
        ];

        $sale = Auth::user()->sales()->create($data);

        // Update stok produk jika status selesai
        if ($request->status === 'selesai') {
            $product->decrement('stock', $request->qty);
        }

        return redirect()->route('umkm.sales.index')
            ->with('success', 'Penjualan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Auth::user()->sales()->with(['product', 'customer'])->findOrFail($id);
        return view('umkm.sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Auth::user()->sales()->findOrFail($id);
        $products = Auth::user()->products()->where('is_active', true)->orderBy('name')->get();
        $customers = Auth::user()->customers()->orderBy('name')->get();
        return view('umkm.sales.edit', compact('sale', 'products', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'order_id' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'nullable|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'platform' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $sale = Auth::user()->sales()->findOrFail($id);
        
        // Handle stok update jika status berubah
        $oldStatus = $sale->status;
        $newStatus = $request->status;
        $oldQuantity = $sale->quantity;
        $newQuantity = $request->quantity;
        
        // Jika status berubah dari completed ke lainnya, kembalikan stok
        if ($oldStatus === 'completed' && $newStatus !== 'completed') {
            $product = Product::find($sale->product_id);
            if ($product) {
                $product->increment('stock', $oldQuantity);
            }
        }
        
        // Jika status berubah ke completed, kurangi stok
        if ($oldStatus !== 'completed' && $newStatus === 'completed') {
            $product = Product::find($request->product_id);
            if ($product) {
                $product->decrement('stock', $newQuantity);
            }
        }
        
        // Jika status tetap completed tapi quantity berubah
        if ($oldStatus === 'completed' && $newStatus === 'completed' && $oldQuantity !== $newQuantity) {
            $product = Product::find($request->product_id);
            if ($product) {
                $product->increment('stock', $oldQuantity);
                $product->decrement('stock', $newQuantity);
            }
        }

        // Hitung total amount
        $totalAmount = ($request->quantity * $request->unit_price) + ($request->shipping_cost ?? 0);

        $data = $request->all();
        $data['total_amount'] = $totalAmount;
        
        $sale->update($data);

        return redirect()->route('umkm.sales.index')
            ->with('success', 'Penjualan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Auth::user()->sales()->findOrFail($id);
        
        // Kembalikan stok jika status completed
        if ($sale->status === 'completed') {
            $product = Product::find($sale->product_id);
            if ($product) {
                $product->increment('stock', $sale->quantity);
            }
        }
        
        $sale->delete();

        return redirect()->route('umkm.sales.index')
            ->with('success', 'Penjualan berhasil dihapus.');
    }

    /**
     * Get product details for AJAX request
     */
    public function getProductDetails($productId)
    {
        $product = Auth::user()->products()->findOrFail($productId);
        return response()->json([
            'name' => $product->name,
            'selling_price' => $product->selling_price,
            'stock' => $product->stock
        ]);
    }
}
