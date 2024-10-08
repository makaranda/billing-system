<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerWhtAttachments extends Model
{
    use HasFactory;
    protected $table = 'customer_wht_attachments';

    // Allow mass assignment for these fields
    protected $fillable = [
        'type',
        'receipt_id',
        'date',
        'file_name',
        'uploaded_by',
        'status'
    ];

    // Disable auto-incrementing if the primary key is not auto-incrementing
    public $incrementing = true;
}
