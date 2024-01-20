<?php

namespace App\Http\Controllers;

use App\Models\Detail_Transaction;
use App\Models\Monthly_income;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

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


    public function add(Request $request){
        // Validasi input
        $validator = Validator::make($request->all(), [
            "bulanTahun" => "required",
            "totalTransaksi" => "required|numeric",
            "totalPendapatan" => "required|numeric|min:3",
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'min' => [
                'numeric' => 'Kolom :attribute harus minimal :min.',
            ],
        ], [
            'bulanTahun' => 'Bulan dan Tahun',
            'totalTransaksi' => 'Total Transaksi',
            'totalPendapatan' => 'Total Pendapatan',
        ]);
        
        
        
        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        // Buat instance Monthly_income
        $monthlyIncome = new Monthly_income;
        
        // Isi data dari permintaan
        $monthlyIncome->month = $request->bulanTahun;
        $monthlyIncome->total_transaksi = $request->totalTransaksi;
        $monthlyIncome->total_harga = $request->totalPendapatan;
    
        // Simpan instance ke database
        $monthlyIncome->save();
    
        // Berikan respons sukses
        return response()->json(['message' => 'Data berhasil ditambahkan.'], 200);
    }

    public function reportsales($id)
    {
        // Mencari data berdasarkan ID
        $saledata = Monthly_income::find($id);
    
        // Memeriksa apakah data ditemukan
        if ($saledata) {
            return response()->json(['sale' => $saledata]);
        } else {
            // Jika data tidak ditemukan, memberikan respons error
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
    public function update(Request $request)
    {
        // Validasi request sesuai kebutuhan
        $request->validate([
            'bulanTahun' => 'required',
            'totalTransaksi' => 'required|numeric',
            'totalPendapatan' => 'required|numeric',
        ]);

        // Proses update data
        $sale = Monthly_income::find($request->sale_id);

        if (!$sale) {
            return response()->json(['error' => 'Data tidak di temukan.'], 404);
        }

        $sale->month = $request->bulanTahun;
        $sale->total_transaksi = $request->totalTransaksi;
        $sale->total_harga = $request->totalPendapatan;

        $sale->save();

        // Beri respons success
        return response()->json(['message' => 'Data berhasil diubah.']);
    }

    public function delete($id){
        try {
            $sale = Monthly_income::findOrFail($id);
            $sale->delete();
    
            return response()->json(['message' => 'Data berhasil dihapus.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data.'], 500);
        }
    }
    

}
