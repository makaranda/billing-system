<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Emails extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    public $timestamps = false;
    protected $table = 'emails';
    protected $fillable = [
        'type',
        'format_id',
        'reference',
        'subject',
        'body',
        'reply_to',
        'recipient_email',
        'cc_email',
        'attachments',
        'scheduled_to',
        'created_by',
        'is_sent',
        'send_attempts',
        'sent_at',
        'response',
    ];
}
