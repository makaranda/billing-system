<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemUsersPermissions extends Model
{
    use HasFactory;
    protected $table = 'system_users_permissions';
    protected $fillable = [
        'main_route',
        'route',
        'userType',
    ];
}
