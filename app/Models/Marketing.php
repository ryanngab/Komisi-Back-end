<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;


    protected $table = 'marketing';  // Ensure this matches your actual table name

    protected $fillable = ['name'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}
