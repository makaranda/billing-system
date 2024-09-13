<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class BankRds extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'bank_rds';
    protected $fillable = [
        'rd_no',
        'date',
        'customer_id',
        'bank_account_id',
        'payment_type',
        'payment_id',
        'payment_date',
        'method',
        'reference',
        'payment_amount',
        'currency_id',
        'notes',
        'is_exported',
        'exported_by',
        'exported_at',
        'transaction_id',
        'created_by',
        'status',
    ];
}
