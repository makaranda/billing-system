<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class ProductCategories extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'product_categories';
    protected $fillable = [
        'department_id',
        'service_type',
        'product_category_id',
        'name',
        'sales_account_id',
        'status',
    ];
}
