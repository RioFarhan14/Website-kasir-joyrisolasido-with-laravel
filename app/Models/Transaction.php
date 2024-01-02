<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = [
        'id',
        'pelanggan_id',
        'total_harga',
        'metode_pembayaran',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'pelanggan_id');
    }

    public function detail_Transaction()
    {
        return $this->hasMany(Detail_Transaction::class);
    }
}
