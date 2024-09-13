<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class CustomerPaymentAllocations extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'customer_payment_allocations';
    protected $fillable = [
        'transaction_id',
        'payment_id',
        'date',
        'source_type',
        'source_id',
        'allocated_amount',
        'created_by',
        'created_at',
        'updated_at',
        'status',
        'is_sync_invoice',
        'invoice_sync_at',
        'invoice_sync_by',
        'invoice_sync_tr_id',
        'is_sync_payment',
        'payment_sync_at',
        'payment_sync_by',
        'payment_sync_tr_id',
    ];
}
