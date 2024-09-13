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
    protected $table = 'default_payment_banks';
    protected $fillable = [
        'payment_method',
        'currency_id',
        'card_type_id',
        'bank_account_id',
        'created_by',
    ];
}
