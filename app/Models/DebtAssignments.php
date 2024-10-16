<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class DebtAssignments extends Model
{
    use HasFactory;
    protected $table = 'debt_assignments';

    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $fillable = [
        'user_id',
        'invoice_id',
        'customer_id',
        'assigned_date',
        'assigned_upto',
        'collection_date',
        'assigned_by',
        'status'
    ];

    // Define relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
