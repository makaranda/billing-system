<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class MiniPosConfigurations extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'mini_pos_configurations';
    protected $fillable = [
        'config_name',
        'config_value',
        'created_by',
        'status',
    ];
}
