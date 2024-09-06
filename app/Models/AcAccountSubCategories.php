<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class AcAccountSubCategories extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    public $timestamps = false;
    protected $table = 'ac_account_sub_categories';
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'range_from',
        'range_to',
        'is_bank',
        'is_pop',
        'active',
        'status',
    ];
}
