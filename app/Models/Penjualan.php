<?php

// App\Models\Penjualan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $fillable = [
        'transaction_number',
        'marketing_id',
        'date',
        'cargo_fee',
        'total_balance',
        'grand_total',
    ];

    public function marketing()
    {
        return $this->belongsTo(Marketing::class, 'marketing_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}

