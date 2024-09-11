<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class BankDepositTypes extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    public $timestamps = false;
    protected $table = 'bank_deposit_types';
    protected $fillable = [
        'category',
        'deposit_type',
        'status',
        'created_by',
    ];
}
