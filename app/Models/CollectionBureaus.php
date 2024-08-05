<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionBureaus extends Model
{
    use HasFactory;
    protected $table = 'collection_bureaus';
    protected $fillable = [
    'name',
    'address',
    'telephone',
    'mobile',
    'email',
    'user_id',
    'created_by',
    'status',
    ];
}
