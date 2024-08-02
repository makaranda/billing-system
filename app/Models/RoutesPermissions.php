<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutesPermissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_route',
        'admin',
        'user',
        'show',
        'add',
        'edit',
        'delete',
        'report',
        'print',
        'send',
        'other',
    ];
}

