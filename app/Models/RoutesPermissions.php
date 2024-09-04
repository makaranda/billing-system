<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class RoutesPermissions extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'routes_permissions';
    protected $fillable = [
        'user_id',
        'main_route',
        'route',
        'userType',
        'permission_type',
    ];
}

