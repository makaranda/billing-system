<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Taxes extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'taxes';
    protected $fillable = [
        'code',
        'name',
        'rate',
        'nominal_account_id',
        'category',
        'calc_method',
        'calc_order',
        'added_date',
        'status',
    ];
}
