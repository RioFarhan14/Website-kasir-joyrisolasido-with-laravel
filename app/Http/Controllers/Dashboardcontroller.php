<?php

namespace App\Http\Controllers;

use App\Models\Detail_Transaction;
use App\Models\Monthly_income;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboardcontroller extends Controller
{
    public function index(){
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
    
        $totalRevenueThisMonth = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                           ->sum('total_harga');
    
        $totalTransactionsThisMonth = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                                 ->count();
    
        $totalProductsSoldThisMonth = Detail_Transaction::whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth) {
                                            $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                                        })
                                        ->sum('jumlah_produk');

        $totalStockAvailable = Product::sum('stok');

        $salesData = Monthly_income::limit(5) 
        ->get();


                // Produk Terlaris
        $bestSellingProducts = Detail_Transaction::select('produk_id', DB::raw('SUM(jumlah_produk) as total_sold'))
        ->groupBy('produk_id')
        ->orderBy('total_sold', 'DESC')
        ->limit(5)
        ->get();

        return view('content.dashboard', [
            'bestSellingProducts' => $bestSellingProducts,
            'salesData' => $salesData,
            'activeSidebar' => 'dashboard',
            'totalRevenueThisMonth' => $totalRevenueThisMonth,
            'totalTransactionsThisMonth' => $totalTransactionsThisMonth,
            'totalProductsSoldThisMonth' => $totalProductsSoldThisMonth,
            'totalStockAvailable' => $totalStockAvailable
        ]);
    }
    
    
}
