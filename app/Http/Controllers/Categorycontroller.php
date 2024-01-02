<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Categorycontroller extends Controller
{
    public function index(){
        return view('crud_category.category', ['activeSidebar' => 'inventori']);
    }

    public function create(request $request){ 
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Kolom nama harus diisi.',
            'nama.min' => 'Kolom nama minimal diisi 3 karakter.',
            'gambar.required' => 'Kolom gambar harus diisi.',
            'gambar.image' => 'Kolom gambar harus berupa file gambar.',
            'gambar.mimes' => 'Kolom gambar harus memiliki format file jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran file gambar tidak boleh melebihi 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $imageName = time() . '.' . $request->gambar->extension();
        // simpan file ke folder public/category
        Storage::putFileAs('public/category', $request->gambar, $imageName);
        // masukkan data ke database
        Category::create([
            'nama' => $request->nama,
            'gambar' => $imageName
        ]);

        // redirect ke halaman category.index
        return redirect()->route('inventori');
    }
    public function edit($id){
        $category = Category::where('id', $id)->first();
         // ambil data category sebagai isian di pilihan (select)
        $activeSidebar = 'inventori';
         // tampilkan view edit dan passing data product
         return view('crud_category.edit', compact('activeSidebar','category'));
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|min:3',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Kolom nama harus diisi.',
            'nama.min' => 'Kolom nama minimal diisi 3 karakter.',
            'gambar.image' => 'Kolom gambar harus berupa file gambar.',
            'gambar.mimes' => 'Kolom gambar harus memiliki format file jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran file gambar tidak boleh melebihi 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        if ($request->hasFile('gambar')) {
            // ambil nama file gambar lama dari database
            $old_image = Category::find($id)->gambar;

            // hapus file gambar lama dari folder slider
            Storage::delete('public/product/' . $old_image);

        $imageName = time() . '.' . $request->gambar->extension();
        // simpan file ke folder public/category
        Storage::putFileAs('public/category', $request->gambar, $imageName);
        // masukkan data ke database
        Category::where('id', $id)->update([
            'nama' => $request->nama,
            'gambar' => $imageName
        ]);
    }else{
        Category::where('id', $id)->update([
            'nama' => $request->nama,
        ]);
    }
        // redirect ke halaman category.index
        return redirect()->route('inventori');
    }
    public function delete($id){
        // ambil data Category berdasarkan id
        $Category = Category::find($id);

        // hapus data Category
        $Category->delete();

        // redirect ke halaman inventori
        return redirect()->route('inventori');
   }
}
