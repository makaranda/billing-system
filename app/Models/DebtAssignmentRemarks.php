<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class DebtAssignmentRemarks extends Model
{
    use HasFactory;
    protected $table = 'debt_assignment_remarks';

    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }

    protected $fillable = [
        'assignment_id',
        'date',
        'remarks',
        'created_by',
        'status'
    ];

}
