<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Transaction extends Model
{
    use HasFactory;
    protected $table = "detail_transactions";
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah_produk'
    ];
    public $timestamps = false;

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaksi_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'produk_id');
    }
}
