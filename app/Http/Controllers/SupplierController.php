<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Auth::user()->suppliers()
            ->orderBy('name')
            ->paginate(15);
            
        return view('umkm.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('umkm.suppliers.create');
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
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        Auth::user()->suppliers()->create($request->all());

        return redirect()->route('umkm.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Auth::user()->suppliers()->findOrFail($id);
        $products = $supplier->products()->paginate(10);
        
        return view('umkm.suppliers.show', compact('supplier', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Auth::user()->suppliers()->findOrFail($id);
        return view('umkm.suppliers.edit', compact('supplier'));
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
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $supplier = Auth::user()->suppliers()->findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('umkm.suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Auth::user()->suppliers()->findOrFail($id);
        
        // Cek apakah supplier masih digunakan di produk
        if ($supplier->products()->count() > 0) {
            return redirect()->route('umkm.suppliers.index')
                ->with('error', 'Supplier tidak dapat dihapus karena masih digunakan dalam produk.');
        }
        
        $supplier->delete();

        return redirect()->route('umkm.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
