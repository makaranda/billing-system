<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;


class CustomerCdNote extends Model
{
    use HasFactory;

    protected $table = 'customer_cd_notes';
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    // The fields that are mass assignable
    protected $fillable = [
        'type',
        'cdn_no',
        'customer_id',
        'date',
        'amount',
        'total_credit_notes',
        'total_receipts',
        'allocated_amount',
        'created_by',
        'is_posted',
        'posted_by',
        'posted_at',
        'is_allocated',
        'is_exported',
        'exported_by',
        'exported_at',
        'transaction_id',
        'status'
    ];

    // Disable timestamps if not using created_at/updated_at
    public $timestamps = true;

    // Optionally, define any relationships here, such as the customer or creator
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
