<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Productcontroller extends Controller
{
    public function index(){
        $kategori = Category::all();
        return view('crud_product.product', ['activeSidebar' => 'inventori', 'kategori' => $kategori]);
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3',
            'kategori_id' => 'required',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Kolom nama harus diisi.',
            'nama.min' => 'Kolom nama minimal diisi 3 karakter.',
            'kategori_id.required' => 'Kolom kategori harus dipilih.', 
            'harga.required' => 'Kolom harga harus diisi.', 
            'harga.integer' => 'Kolom harga hanya boleh berisi angka',
            'stok.integer' => 'Kolom stok hanya boleh berisi angka',
            'stok.required' => 'Kolom stok harus diisi.', 
            'gambar.required' => 'Kolom gambar harus diisi.',
            'gambar.image' => 'Kolom gambar harus berupa file gambar.',
            'gambar.mimes' => 'Kolom gambar harus memiliki format file jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran file gambar tidak boleh melebihi 2MB.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $imageName = time() . '.' . $request->gambar->extension();
        // simpan file ke folder public/product
        Storage::putFileAs('public/product', $request->gambar, $imageName);
        // Hitung urutan produk untuk semua produk
        $urutan = Product::count();
        // Tambahkan 1 ke urutan untuk produk baru
        $urutan += 1;
        // logika id product. id kategori + urutan produk
        $id = $request->kategori_id.$urutan;
        // masukkan data ke database
        Product::create([
            'id' => $id,
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'gambar' => $imageName,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'terjual'=> 0
        ]);

        // redirect ke halaman category.index
        return redirect()->route('inventori');
    }
    public function edit($id){
         // ambil data product berdasarkan id
         $product = Product::where('id', $id)->with('category')->first();

         // ambil data category sebagai isian di pilihan (select)
         $category = Category::all();
        $activeSidebar = 'inventori';
         // tampilkan view edit dan passing data product
         return view('crud_product.edit', compact('product','activeSidebar','category'));
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3',
            'kategori_id' => 'required',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Kolom nama harus diisi.',
            'nama.min' => 'Kolom nama minimal diisi 3 karakter.',
            'kategori_id.required' => 'Kolom kategori harus dipilih.', 
            'harga.required' => 'Kolom harga harus diisi.', 
            'harga.integer' => 'Kolom harga hanya boleh berisi angka',
            'stok.integer' => 'Kolom stok hanya boleh berisi angka',
            'stok.required' => 'Kolom stok harus diisi.',
            'gambar.image' => 'Kolom gambar harus berupa file gambar.',
            'gambar.mimes' => 'Kolom gambar harus memiliki format file jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran file gambar tidak boleh melebihi 2MB.',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // cek jika user mengupload gambar di form
        if ($request->hasFile('gambar')) {
            // ambil nama file gambar lama dari database
            $old_image = Product::find($id)->gambar;

            // hapus file gambar lama dari folder slider
            Storage::delete('public/product/' . $old_image);

        $imageName = time() . '.' . $request->gambar->extension();
        // simpan file ke folder public/product
        Storage::putFileAs('public/product', $request->gambar, $imageName);
        
        Product::where('id', $id)->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'gambar' => $imageName,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);
    }else {
        // update data product tanpa menyertakan file gambar
        Product::where('id', $id)->update([
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);
    }
        // redirect ke halaman category.index
        return redirect()->route('inventori');
    }

    public function delete($id){
        // ambil data product berdasarkan id
        $product = Product::find($id);

        if ($product) {
            // hapus data product
            $product->delete();
    
            // redirect ke halaman inventori
            return redirect()->route('inventori')->with('success', 'Produk berhasil dihapus.');
        }
    
        // jika produk tidak ditemukan
        return redirect()->route('inventori')->with('error', 'Produk tidak ditemukan.');
   }
}
