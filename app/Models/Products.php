<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'currency_id',
        'price',
        'is_taxable',
        'stock_type',
        'status',
        'Kbilling_product_id',
    ];
}
