<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $fillable = [
        'penjualan_id',
        'amount',
        'payment_method',
        'payment_date',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }   
}
