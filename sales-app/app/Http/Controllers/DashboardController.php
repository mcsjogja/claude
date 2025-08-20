<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalPenjualan = Transaction::where('type', 'penjualan')->sum('total');
        $totalPembelian = Transaction::where('type', 'pembelian')->sum('total');
        
        $recentTransactions = Transaction::with(['user', 'transactionDetails.product'])
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalUsers', 
            'totalPenjualan',
            'totalPembelian',
            'recentTransactions',
            'lowStockProducts'
        ));
    }
}
