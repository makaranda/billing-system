<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Invoices extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }

    protected $table = 'invoices';
    protected $fillable = [
        'type',
        'branch_id',
        'product_group_id',
        'collection_bureau_id',
        'collection_bureau_assign_date',
        'invoice_no',
        'invoice_serial_no',
        'invoice_generated_date',
        'booking_no',
        'room_id',
        'guest_id',
        'manual_invoice_id',
        'customer_id',
        'date',
        'due_date',
        'description',
        'amount',
        'total_paid',
        'payments_due',
        'separate_ids',
        'total_credit_notes',
        'total_receipts',
        'is_paid',
        'is_exported',
        'exported_by',
        'exported_at',
        'transaction_id',
        'recurring_invoice_id',
        'start_date',
        'end_date',
        'private_note',
        'public_note',
        'status',
        'public_token',
        'created_by',
        'debt_collector_id',
        'debt_collector_assign_date',
        'is_printed',
        'is_email',
        'is_dispatched',
        'dispatched_date',
        'is_delivered',
        'delivery_date',
        'is_fallowup',
        'is_suspended',
        'suspended_date',
        'is_terminated',
        'terminated_date',
        'is_voided',
        'void_date',
        'void_by',
        'sales_user_id',
        'sales_tag',
        'is_converted',
        'converted_by',
        'converted_at',
        'attributes'
    ];
}
