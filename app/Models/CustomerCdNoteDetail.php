<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class CustomerCdNoteDetail extends Model
{
    use HasFactory;
    protected $table = 'customer_cd_note_details';
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }

    // The fields that are mass assignable
    protected $fillable = [
        'cd_note_id',
        'sales_account_id',
        'description',
        'reference',
        'tax_percentage',
        'tax_array',
        'net_amount',
        'tax_amount',
        'gross_amount',
        'created_by',
        'status'
    ];

    // Define relationships
    public function customerCdNote()
    {
        return $this->belongsTo(CustomerCdNote::class, 'cd_note_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
