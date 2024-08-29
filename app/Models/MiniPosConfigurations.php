<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiniPosConfigurations extends Model
{
    use HasFactory;
    protected $table = 'mini_pos_configurations';
    protected $fillable = [
        'config_name',
        'config_value',
        'created_by',
        'status',
    ];
}
