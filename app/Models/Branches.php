<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'main_branch_id',
        'status',
        'default_collection_bureau_id',
        'default_territory_id',
        ];
}
