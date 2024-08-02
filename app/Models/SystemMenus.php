<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemMenus extends Model
{
    use HasFactory;
    public $table = 'system_menus';

    public function children()
    {
        return $this->hasMany(SystemMenus::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(SystemMenus::class, 'parent_id');
    }
}
