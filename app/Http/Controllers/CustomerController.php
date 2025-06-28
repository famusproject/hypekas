<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Auth::user()->customers()
            ->orderBy('name')
            ->paginate(15);
            
        return view('umkm.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('umkm.customers.create');
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
            'platform' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        Auth::user()->customers()->create($request->all());

        return redirect()->route('umkm.customers.index')
            ->with('success', 'Customer berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Auth::user()->customers()->findOrFail($id);
        $sales = $customer->sales()->orderBy('sale_date', 'desc')->paginate(10);
        
        return view('umkm.customers.show', compact('customer', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Auth::user()->customers()->findOrFail($id);
        return view('umkm.customers.edit', compact('customer'));
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
            'platform' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $customer = Auth::user()->customers()->findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('umkm.customers.index')
            ->with('success', 'Customer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Auth::user()->customers()->findOrFail($id);
        
        // Cek apakah customer masih digunakan di penjualan
        if ($customer->sales()->count() > 0) {
            return redirect()->route('umkm.customers.index')
                ->with('error', 'Customer tidak dapat dihapus karena masih digunakan dalam penjualan.');
        }
        
        $customer->delete();

        return redirect()->route('umkm.customers.index')
            ->with('success', 'Customer berhasil dihapus.');
    }
}
