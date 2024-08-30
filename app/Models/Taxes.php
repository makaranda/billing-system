<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxes extends Model
{
    use HasFactory;
    protected $table = 'taxes';
    protected $fillable = [
        'code',
        'name',
        'rate',
        'nominal_account_id',
        'category',
        'calc_method',
        'calc_order',
        'added_date',
        'status',
    ];
}
