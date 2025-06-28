<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Auth::user()->products()
            ->with(['supplier'])
            ->orderBy('name')
            ->paginate(15);
            
        return view('umkm.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Auth::user()->suppliers()->orderBy('name')->get();
        return view('umkm.products.create', compact('suppliers'));
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
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        Auth::user()->products()->create($data);

        return redirect()->route('umkm.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Auth::user()->products()->with(['supplier'])->findOrFail($id);
        return view('umkm.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Auth::user()->products()->findOrFail($id);
        $suppliers = Auth::user()->suppliers()->orderBy('name')->get();
        return view('umkm.products.edit', compact('product', 'suppliers'));
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
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $id,
            'supplier_id' => 'nullable|exists:suppliers,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $product = Auth::user()->products()->findOrFail($id);
        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        $product->update($data);

        return redirect()->route('umkm.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Auth::user()->products()->findOrFail($id);
        
        // Cek apakah produk masih digunakan di penjualan
        if ($product->sales()->count() > 0) {
            return redirect()->route('umkm.products.index')
                ->with('error', 'Produk tidak dapat dihapus karena masih digunakan dalam penjualan.');
        }
        
        $product->delete();

        return redirect()->route('umkm.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Get product details for AJAX request
     */
    public function getProductDetails($id)
    {
        $product = Auth::user()->products()->findOrFail($id);
        return response()->json($product);
    }
}
