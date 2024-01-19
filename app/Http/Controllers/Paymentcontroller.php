<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Detail_Transaction;
use App\Models\Monthly_income;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class Paymentcontroller extends Controller
{
    public function index(){
        $category = Category::all();
        return view('content.payment', ['activeSidebar' => 'pembayaran','category' => $category]);
    }
    public function checkout() {
        try {
            // Ambil data keranjang belanja dari sesi
            $cart = session('cart', []);
    
            // Ambil semua ID produk dari keranjang belanja
            $productIds = collect($cart)->pluck('product.id')->toArray();
    
            // Ambil data produk berdasarkan ID dengan eager loading
            $products = Product::whereIn('id', $productIds)->get();
    
            // Hitung total harga produk berdasarkan kuantitas
            $totalPrice = 0;
            foreach ($cart as $item) {
                // Validasi properti produk dan kuantitas
                if (isset($item['product']) && isset($item['product']->harga) && isset($item['quantity'])) {
                    $product = $products->firstWhere('id', $item['product']->id);
                    if ($product) {
                        $totalPrice += $product->harga * $item['quantity'];
                    } else {
                        throw new \Exception('Produk tidak ditemukan.');
                    }
                } else {
                    throw new \Exception('Data produk tidak valid dalam keranjang.');
                }
            }
    
            // Kirim data ke view
            return view('content.list-product', [
                'cart' => $cart,
                'totalPrice' => $totalPrice
            ]);
        } catch (\Exception $e) {
            // Tangani error dengan mengirim respons error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    public function getProductsByCategory($category) {
        $products = Product::where('kategori_id', $category)->where('stok', '>', 0)->get();
        return view('content.partial_products', compact('products'));
    }
    public function addproduct($productId, Request $request) {
        $productData = Product::find($productId);
        
        if ($productData) {
            $cart = $request->session()->get('cart', []);
            
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += 1;
            } else {
                $cart[$productId] = [
                    'product' => $productData,
                    'quantity' => 1
                ];
            }
            
            $request->session()->put('cart', $cart);
            
            return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan ke keranjang.', 'cart' => $cart, 'updateCart' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan atau ada kesalahan.'], 404);
    }
    
    
    public function removeproduct($productId, Request $request) {
        // Menggunakan findOrFail untuk mencari produk dan menangani error jika tidak ditemukan
        $productData = Product::findOrFail($productId);
    
        $cart = $request->session()->get('cart', []);
    
        // Memeriksa apakah produk ada dalam keranjang
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] > 1) {
                // Mengurangi kuantitas jika produk sudah ada di keranjang lebih dari 1
                $cart[$productId]['quantity'] -= 1;
            } else {
                // Menghapus produk dari keranjang jika kuantitasnya adalah 1
                unset($cart[$productId]);
            }
    
            // Memperbarui session dengan data keranjang yang baru
            $request->session()->put('cart', $cart);
    
            return response()->json(['success' => true, 'message' => 'Kuantitas produk berhasil dikurangi.', 'cart' => $cart, 'updateCart' => true]);
        }
    
        // Jika produk tidak ditemukan atau tidak ada dalam keranjang
        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan atau ada kesalahan dalam mengurangi kuantitas.'], 404);
    }
    
    
    public function validatePayment(Request $request)
    {
        $paymentMethod = strtoupper($request->input('paymentMethod'));
        $cart = Session::get('cart');
    
        // Validasi keberadaan produk dan metode pembayaran
        if (!$cart && !$paymentMethod) {
            return response()->json([
                'status' => false,
                'message' => 'Produk dan metode pembayaran diperlukan.'
            ]);
        }
    
        if (!$cart) {
            return response()->json([
                'status' => false,
                'message' => 'Produk diperlukan.'
            ]);
        }
    
        if (!$paymentMethod) {
            return response()->json([
                'status' => false,
                'message' => 'Metode pembayaran diperlukan.'
            ]);
        }
    
        // Set atau ganti session untuk metode pembayaran
        Session::put('paymentMethod', $paymentMethod);
    
        return response()->json([
            'status' => true,
            'message' => 'Data valid.'
        ]);
    }
    
    public function validateAndStore(Request $request)
    {
        $telepon = $request->input('telepon');
        $nama = $request->input('nama');
        
        // Cari customer berdasarkan telepon
        $customer = Customer::where('no_telepon', $telepon)->first();
    
        if (!$nama) {
            if (!$customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'No.telepon tidak ada.'
                ]);
            }
    
            $idPelanggan = $customer->id;
        } else {
            if ($customer) {
                return response()->json([
                    'status' => false,
                    'message' => 'nomor telepon sudah terpakai.',
                ]);
            }
    
            // Buat customer baru
            $customer = Customer::create([
                'nama' => $nama,
                'no_telepon' => $telepon,
            ]);
    
            $idPelanggan = $customer->id;
        }
    
        // Buat urutan transaksi
        $urutanTransaksi = Transaction::count() + 1;
        $tanggal = Carbon::now()->format('dmy');
        $idTransaksi = "{$idPelanggan}{$urutanTransaksi}{$tanggal}";
    
        // Ambil metode pembayaran dari session
        $metodePembayaran = session('paymentMethod'); 
    
        // Ambil produk dari session
        $products = session('cart', []);
    
        $totalHarga = 0;
        foreach ($products as $product) {
            $totalHarga += $product['product']->harga * $product['quantity'];
        }
    
        // Simpan transaksi
        $newTransaction = Transaction::create([
            'id' => $idTransaksi,
            'pelanggan_id' => $idPelanggan,
            'total_harga' => $totalHarga,
            'metode_pembayaran' => $metodePembayaran,
        ]);
        // Mengambil data yang baru saja dibuat
        $created_at = $newTransaction->created_at;
        $total_harga_transaksi = $newTransaction->total_harga;

        // Mengekstrak tahun dan bulan dari created_at
        $monthYear = $created_at->format('Y-m');

        // Memeriksa apakah data bulan ini sudah ada di tabel pencapaian bulanan atau belum
        $salesData = Monthly_income::where('month', $monthYear)->first();

        // Jika data sudah ada, update nilai total harga dan total transaksi
        if ($salesData) {
            $salesData->total_harga += $total_harga_transaksi;
            $salesData->total_transaksi += 1;
            $salesData->save();
        } else {
            // Jika data belum ada, buat data baru untuk bulan ini
            Monthly_income::create([
                'month' => $monthYear,
                'total_harga' => $total_harga_transaksi,
                'total_transaksi' => 1,
            ]);
        }
    
        // Simpan detail transaksi
        foreach ($products as $productData) {
            $product = $productData['product'];
            $quantity = $productData['quantity'];
        
            // Update jumlah produk terjual di model Product
            $product->update([
                'terjual' => $product->terjual + $quantity,
                'stok' => $product->stok - $quantity,
            ]);
        
            Detail_Transaction::create([
                'transaksi_id' => $idTransaksi,
                'produk_id' => $product->id,
                'jumlah_produk' => $quantity,
            ]);
        }
        
    
        // Bersihkan session
        session()->forget('cart');
        session()->forget('paymentMethod');
    
        // Berikan respons
        return response()->json([
            'status' => true,
            'id' => $idTransaksi,
            'message' => 'Pembayaran '. $metodePembayaran .' berhasil',
            'metode_pembayaran' => $metodePembayaran,
            'total_harga' => $totalHarga
        ]);
    }
    

public function downloadInvoice($id)
{
    // Cari transaksi berdasarkan ID
    $invoice = Transaction::find($id);

    // Jika transaksi tidak ditemukan, kembalikan respons
    if (!$invoice) {
        return response()->json([
            'status' => false,
            'message' => 'Transaksi tidak ditemukan.'
        ], 404);
    }

    // Ambil detail transaksi berdasarkan transaksi ID dengan produk terkait
    $products = Detail_Transaction::where('transaksi_id', $id)->with('product')->get();

    // Pastikan ada detail transaksi
    if ($products->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Detail transaksi tidak ditemukan.'
        ], 404);
    }

    $pdf = Pdf::loadView('content.invoice', compact('invoice', 'products'));
    $pdf->setPaper('A4', 'landscape');

    return $pdf->download('invoice-' . $id . '.pdf');
}

}