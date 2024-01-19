<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monthly_income extends Model
{
    use HasFactory;
    protected $table = "monthly_incomes";
    protected $fillable = [
        'month',
        'total_harga',
        'total_transaksi',
    ];
    public $timestamps = false;
}
