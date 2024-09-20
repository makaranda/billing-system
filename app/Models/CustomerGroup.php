<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class CustomerGroup extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'customer_groups';
    protected $fillable = [
        'code',
        'name',
        'default_customer_id',
        'created_by',
        'status',
    ];
}
