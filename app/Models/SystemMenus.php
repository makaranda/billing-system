<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class SystemMenus extends Model
{
    use HasFactory;
    public $table = 'system_menus';
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    public function children()
    {
        return $this->hasMany(SystemMenus::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(SystemMenus::class, 'parent_id');
    }
}
