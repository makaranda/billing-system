<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    use HasFactory;
    protected $table = 'Currencies';
    protected $fillable = [
        'code',
        'symbol',
        'name',
        'rate',
        'is_base',
        'status',
    ];
}
