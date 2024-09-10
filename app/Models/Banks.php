<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class Banks extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'banks';
    protected $fillable = [
        'code',
        'name',
        'status',
    ];
}
