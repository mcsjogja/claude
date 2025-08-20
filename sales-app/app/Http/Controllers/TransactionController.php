<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'transactionDetails.product']);
        
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        $transactions = $query->latest()->paginate(10);
        
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'penjualan');
        $products = Product::where('stock', '>', 0)->get();
        
        return view('transactions.create', compact('type', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:penjualan,pembelian',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            
            // Calculate total
            foreach ($request->products as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                $total += $subtotal;
            }

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'type' => $request->type,
                'total' => $total,
            ]);

            // Create transaction details and update stock
            foreach ($request->products as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                // Update product stock
                $product = Product::find($item['product_id']);
                if ($request->type === 'penjualan') {
                    $product->decrement('stock', $item['quantity']);
                } else {
                    $product->increment('stock', $item['quantity']);
                }
            }
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'transactionDetails.product']);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Transactions should not be editable for data integrity
        abort(403, 'Transaksi tidak dapat diedit.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Transactions should not be editable for data integrity
        abort(403, 'Transaksi tidak dapat diedit.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Only admin can delete transactions
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya admin yang dapat menghapus transaksi.');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
