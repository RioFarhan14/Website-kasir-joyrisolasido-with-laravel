<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\Categorycontroller;
use App\Http\Controllers\Customerscontroller;
use App\Http\Controllers\Dashboardcontroller;
use App\Http\Controllers\Inventorycontroller;
use App\Http\Controllers\Paymentcontroller;
use App\Http\Controllers\Productcontroller;
use App\Http\Controllers\Reportcontroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [Authcontroller::class, 'index'])->name('login');
Route::post('/login', [Authcontroller::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');

Route::middleware(['preventBackAfterLogout', 'auth'])->group(function() {

    Route::get('/edit', [Authcontroller::class, 'edit'])->name('auth.edit');
    Route::put('/update', [Authcontroller::class, 'update'])->name('auth.update');
    

    Route::get('/Dashboard', [Dashboardcontroller::class, 'index'])->name('dashboard');
    Route::get('/inventori', [Inventorycontroller::class, 'index'])->name('inventori');
    Route::get('/inventori/kategori', [Categorycontroller::class, 'index'])->name('kategori');
    Route::get('/inventori/kategori/{id}', [Categorycontroller::class, 'edit'])->name('kategori.edit');
    Route::get('/inventori/produk', [Productcontroller::class, 'index'])->name('produk');
    Route::get('/inventori/produk/{id}', [Productcontroller::class, 'edit'])->name('produk.edit');
    Route::get('/pembayaran', [Paymentcontroller::class, 'index'])->name('pembayaran');

    Route::get('/customers',[Customerscontroller::class, 'index'])->name('customer');

        Route::get('/pembayaran/checkout', [Paymentcontroller::class, 'checkout']);
        Route::get('/add-product/{product_id}', [Paymentcontroller::class, 'addproduct']);
        Route::get('/remove-product/{product_id}', [Paymentcontroller::class, 'removeproduct']);
        Route::post('/validatePayment', [Paymentcontroller::class, 'validatePayment']);
        Route::post('/validationform', [Paymentcontroller::class, 'validateAndStore']);
        Route::get('/downloadInvoice/{id}',[Paymentcontroller::class,'downloadInvoice']);

    Route::get('/get-products/{category}',[Paymentcontroller::class, 'getProductsByCategory']);
    Route::get('/laporan', [Reportcontroller::class, 'index'])->name('laporan');
    Route::get('/laporan/{id}', [Reportcontroller::class, 'ReportInvoice'])->name('get.invoice');

    //CRUD
    Route::post('/inventori/kategori', [Categorycontroller::class, 'create'])->name('kategori.create');
    Route::put('/inventori/kategori/{id}', [Categorycontroller::class, 'update'])->name('kategori.update');
    Route::delete('/inventori/kategori/{id}', [Categorycontroller::class, 'delete'])->name('kategori.delete');
    Route::post('/inventori/produk', [Productcontroller::class, 'create'])->name('produk.create');
    Route::put('/inventori/produk/{id}', [Productcontroller::class, 'update'])->name('produk.update');
    Route::delete('/inventori/produk/{id}', [Productcontroller::class, 'delete'])->name('produk.delete');
});



