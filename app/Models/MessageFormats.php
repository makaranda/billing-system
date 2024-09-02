<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageFormats extends Model
{
    use HasFactory;
    protected $table = 'message_formats';
    protected $fillable = [
        'type',
        'name',
        'content',
        'status',
    ];
}
