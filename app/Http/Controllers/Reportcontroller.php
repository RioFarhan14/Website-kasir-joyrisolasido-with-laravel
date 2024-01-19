<?php

namespace App\Http\Controllers;

use App\Models\Detail_Transaction;
use App\Models\Monthly_income;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reportcontroller extends Controller
{
    public function index()
    {
        // Pencapaian Penjualan Tiap Bulan
        $salesData = Monthly_income::all();
    
        // Produk Terlaris
        $bestSellingProducts = Detail_Transaction::select('produk_id', DB::raw('SUM(jumlah_produk) as total_sold'))
                                                 ->groupBy('produk_id')
                                                 ->orderBy('total_sold', 'DESC')
                                                 ->get();
    
        // Riwayat Transaksi
        $transactions = Transaction::with('customer')->get();
    
        return view('content.report', [
            'activeSidebar' => 'laporan',
            'salesData' => $salesData,
            'bestSellingProducts' => $bestSellingProducts,
            'transactions' => $transactions
        ]);
    }
    
    public function ReportInvoice($id) {
        $invoice = Transaction::find($id);
    
        // Ambil detail transaksi berdasarkan transaksi ID dengan produk terkait
        $products = Detail_Transaction::where('transaksi_id', $id)->with('product')->get();
    
        return response()->json([
            'invoice' => $invoice,
            'products' => $products
        ]);
    }
    

}
