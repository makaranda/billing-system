<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class CustomerPayments extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'customer_payments';
    protected $fillable = [
        'branch_id',
        'receipt_no',
        'mcs_id',
        'customer_id',
        'bank_account_id',
        'date',
        'currency_id',
        'currency_value',
        'payment_amount',
        'payment',
        'method',
        'bank_id',
        'card_number',
        'reference',
        'card_type',
        'auth_number',
        'added_date',
        'added_user',
        'is_posted',
        'posted_by',
        'posted_date',
        'preceipt_printed',
        'allocated_amount',
        'is_allocated',
        'is_refund',
        'refund_amount',
        'created_at',
        'updated_at',
        'status',
        'update_date',
        'update_amount',
        'recon_bank_account_id',
        'statement_no',
        'reconciled_by',
        'reconciled_at',
        'is_reconciled',
        'is_exported',
        'exported_by',
        'exported_at',
        'transaction_id',
        'private_note',
        'is_deposit',
        'deposit_id',
        'deposit_date',
    ];
}
