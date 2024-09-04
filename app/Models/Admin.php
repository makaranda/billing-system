<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Observers\SystemLogObserver;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
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
