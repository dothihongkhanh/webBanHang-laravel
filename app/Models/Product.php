<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_category',
        'name_product',
        'price',
        'description',
        'avt'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class, 'id_product');
    }
}
