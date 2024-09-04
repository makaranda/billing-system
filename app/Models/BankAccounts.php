<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class BankAccounts extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'bank_accounts';
    protected $fillable = [
        'hotel_id',
        'bank_id',
        'currency_id',
        'account_id',
        'account_type',
        'account_code',
        'account_no',
        'account_name',
        'od_limit',
        'last_cheque_no',
        'balance',
        'payment_method',
        'status',
    ];

}
