<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentHeads extends Model
{
    use HasFactory;
    protected $table = 'department_heads';
    protected $fillable = [
    'title',
    'full_name',
    'email',
    'phone',
    'status',
    ];
}
