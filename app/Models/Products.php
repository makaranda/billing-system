<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Products extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
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
