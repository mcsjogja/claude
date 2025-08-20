<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display sales report.
     */
    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $salesTransactions = Transaction::where('type', 'penjualan')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'transactionDetails.product'])
            ->latest()
            ->get();

        $totalSales = $salesTransactions->sum('total');
        $totalTransactions = $salesTransactions->count();

        return view('reports.sales', compact(
            'salesTransactions',
            'totalSales',
            'totalTransactions',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Display purchase report.
     */
    public function purchases(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $purchaseTransactions = Transaction::where('type', 'pembelian')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'transactionDetails.product'])
            ->latest()
            ->get();

        $totalPurchases = $purchaseTransactions->sum('total');
        $totalTransactions = $purchaseTransactions->count();

        return view('reports.purchases', compact(
            'purchaseTransactions',
            'totalPurchases',
            'totalTransactions',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Display stock report.
     */
    public function stock()
    {
        $products = Product::orderBy('stock', 'asc')->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->get();
        $outOfStockProducts = Product::where('stock', 0)->get();

        return view('reports.stock', compact(
            'products',
            'lowStockProducts',
            'outOfStockProducts'
        ));
    }
}
