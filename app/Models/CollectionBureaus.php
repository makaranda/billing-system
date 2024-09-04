<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class CollectionBureaus extends Model
{
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }

    use HasFactory;
    protected $table = 'collection_bureaus';
    protected $fillable = [
    'name',
    'address',
    'telephone',
    'mobile',
    'email',
    'user_id',
    'created_by',
    'status',
    ];
}
