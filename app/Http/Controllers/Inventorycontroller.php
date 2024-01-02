<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class Inventorycontroller extends Controller
{
    public function index(){
        $kategori = Category::all();
        $produk = Product::with('category')->get();
        return view('content.inventori', ['activeSidebar' => 'inventori','kategori' => $kategori, 'produk' => $produk]);
    }
}
