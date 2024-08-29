<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcAccounts extends Model
{
    use HasFactory;
    protected $table = 'ac_accounts';
    protected $fillable = [
        'code',
        'name',
        'sub_category_id',
        'is_control',
        'control_type',
        'special_name',
        'allow_dr',
        'allow_cr',
        'is_floating',
        'created_by',
        'active',
        'status',
    ];
}
