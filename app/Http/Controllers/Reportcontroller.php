<?php

namespace App\Http\Controllers;

use App\Models\Detail_Transaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reportcontroller extends Controller
{
    public function index()
    {
        // Pencapaian Penjualan Tiap Bulan
        $salesData = Transaction::selectRaw('
        DATE_FORMAT(created_at, "%Y-%m") as month,
        SUM(total_harga) as total_harga,
        COUNT(*) as total_transaksi
    ')
        ->groupBy('month')
        ->orderBy('month', 'ASC')
        ->get();
    
    
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
