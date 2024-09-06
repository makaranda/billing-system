<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class CustomerTransactions extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'customer_transactions';
    protected $fillable = [
        'booking_no',
        'room_id',
        'guest_id',
        'customer_id',
        'is_separate',
        'transaction_type',
        'transaction_reference',
        'source_reference',
        'payment_method',
        'reference',
        'bank_account_id',
        'nominal_account_id',
        'transaction_date',
        'effective_date',
        'currency_id',
        'currency_value',
        'amount',
        'debits',
        'credits',
        'balance',
        'customer_balance',
        'created_by',
        'is_transfer',
        'is_reconciled',
        'is_rd',
        'reconciled_by',
        'reconciled_at',
        'update_date',
        'statement_no',
        'amount_received',
        'status',
    ];
}
