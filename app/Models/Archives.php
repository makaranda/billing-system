<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Archives extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'archives';
    public $timestamps = false;
    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'customer_id',
        'category_id',
        'archive_date',
        'name',
        'description',
        'reference',
        'reminder_date',
        'file',
        'uploaded_by',
        'status',
        'task_review_completed',
        'task_review_at',
        'task_review_id',
    ];

    // You can also define relationships if needed
    // Example: Relationship to Customer if exists
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Example: Relationship to User if exists
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
