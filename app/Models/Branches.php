<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Branches extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $fillable = [
        'code',
        'name',
        'main_branch_id',
        'status',
        'default_collection_bureau_id',
        'default_territory_id',
        ];
}
