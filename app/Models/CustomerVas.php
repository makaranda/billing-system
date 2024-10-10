<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class CustomerVas extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'customer_vas';

    protected $fillable = [
        'customer_id',
        'product_id',
        'qty',
        'product_description',
        'start_date',
        'end_date',
        'approved_by',
        'attach',
        'invoice_id',
        'created_by',
        'status',
    ];
}
