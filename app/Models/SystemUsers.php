<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Observers\SystemLogObserver;

class SystemUsers extends Authenticatable
{
    // use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'system_users';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // If the primary key is not auto-incrementing
    // public $incrementing = false;

    // If the primary key is not an integer
    // protected $keyType = 'string';

    // Define the fillable properties
    protected $fillable = [
        'branch_id',
        'username',
        'password',
        'privilege',
        'full_name',
        'email',
        'phone',
        'receipt_printer_id',
        'employee_id',
        'group_id',
        'is_debt_collect',
        'collection_bureau_id',
        'last_login_time',
        'last_login_ip',
        'last_login_user_agent',
        'last_online',
        'session_timeout',
        'tfa_phone',
        'tfa_email',
        'otp_code',
        'status',
        'created_by',
    ];

    // Define the attributes that should be cast
    protected $casts = [
        'last_login_time' => 'datetime',
        'last_online' => 'datetime',
    ];

    // If the model should be timestamped
    public $timestamps = true;
}
