<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class AcAccountCategories extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'ac_account_categories';
    protected $fillable = [
        'code',
        'name',
        'pl_bl',
        'sort_order',
        'group_order',
        'created_by',
        'enable',
        'status',
    ];
}
