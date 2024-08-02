<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = [
        'username',
        'email',
        'password',
        'privilege',
        'extensions',
        'status',
    ];
}
