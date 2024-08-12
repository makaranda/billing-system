<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionsTypes extends Model
{
    use HasFactory;
    protected $table = 'permissions_types';
    protected $fillable = [
        'permission_type',
        'route',
    ];
}
