<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SequentialNumber extends Model
{
    use HasFactory;
    protected $table = 'sequential_numbers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'numeric_length',
        'last_number',
        'prefix',
        'sufix', // Corrected to 'suffix' if intended
        'status',
    ];
}
