<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Customerscontroller extends Controller
{
    public function index(){
        $customers = Customer::select(
            'id',
            'nama',
            'no_telepon',
            DB::raw('(SELECT COUNT(*) FROM transactions WHERE transactions.pelanggan_id = customers.id) as totalTransaksi'),
            DB::raw('(SELECT SUM(total_harga) FROM transactions WHERE transactions.pelanggan_id = customers.id) as totalPembelian')
        )
        ->get();
        $activeSidebar = 'customer';
        return view('content.customers', compact('customers', 'activeSidebar'));
        
    }
}
