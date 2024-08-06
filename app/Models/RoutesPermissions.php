<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutesPermissions extends Model
{
    use HasFactory;

    protected $table = 'routes_permissions';
    protected $fillable = [
        'user_id',
        'main_route',
        'route',
        'userType',
        'permission_type',
    ];
}

