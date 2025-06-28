<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Auth::user()->expenses()->with(['product']);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('expense_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('expense_date', '<=', $request->end_date);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $expenses = $query->orderBy('expense_date', 'desc')->paginate(15);
        $products = Auth::user()->products()->orderBy('name')->get();

        return view('umkm.expenses.index', compact('expenses', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Auth::user()->products()->orderBy('name')->get();
        return view('umkm.expenses.create', compact('products'));
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
            'expense_date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'product_id' => 'nullable|exists:products,id',
            'notes' => 'nullable|string'
        ]);

        Auth::user()->expenses()->create($request->all());

        return redirect()->route('umkm.expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Auth::user()->expenses()->with(['product'])->findOrFail($id);
        return view('umkm.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Auth::user()->expenses()->findOrFail($id);
        $products = Auth::user()->products()->orderBy('name')->get();
        return view('umkm.expenses.edit', compact('expense', 'products'));
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
            'expense_date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'product_id' => 'nullable|exists:products,id',
            'notes' => 'nullable|string'
        ]);

        $expense = Auth::user()->expenses()->findOrFail($id);
        $expense->update($request->all());

        return redirect()->route('umkm.expenses.index')
            ->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Auth::user()->expenses()->findOrFail($id);
        $expense->delete();

        return redirect()->route('umkm.expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
