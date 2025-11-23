<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Tentukan kolom yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'name',
        'price',
        'stock',
    ];

    /**
     * Konversi 'price' dan 'stock' ke tipe data yang sesuai.
     */
    protected $casts = [
        'price' => 'integer', // Pastikan price adalah integer
        'stock' => 'integer', // Pastikan stock adalah integer
    ];
}