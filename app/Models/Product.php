<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'id',
        'kategori_id',
        'nama',
        'harga',
        'stok',
        'gambar',
        'terjual'
        
    ];
    public $timestamps = false;  // Menonaktifkan fitur timestamps
        public function category()
    {
        return $this->belongsTo(Category::class,'kategori_id');
    }
    public function detail_transaction()
    {
        return $this->hasMany(Detail_Transaction::class);
    }
}
