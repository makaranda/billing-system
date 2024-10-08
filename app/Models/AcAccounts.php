<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class AcAccounts extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'ac_accounts';
    protected $fillable = [
        'code',
        'name',
        'sub_category_id',
        'is_control',
        'control_type',
        'special_name',
        'allow_dr',
        'allow_cr',
        'is_floating',
        'created_by',
        'active',
        'status',
    ];
}
