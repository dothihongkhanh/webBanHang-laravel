<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'size',
        'color',
        'avt_detail',
        'inventory_number'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}
