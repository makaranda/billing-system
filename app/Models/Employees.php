<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Employees extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $fillable = [
        'emp_id',
        'emp_no',
        'emp_name',
        'emp_dob',
        'emp_department',
        'emp_shift',
        'emp_off_day',
        'emp_position',
        'emp_telephone',
        'emp_email',
        'emp_date_join',
        'emp_gender',
        'emp_status',
    ];
}
