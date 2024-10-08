<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class DepartmentHeads extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'department_heads';
    protected $fillable = [
    'title',
    'full_name',
    'email',
    'phone',
    'status',
    ];
}
