<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\SystemLogObserver;

class HotelInformation extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        self::observe(SystemLogObserver::class);
    }
    protected $table = 'hotel_information';
    protected $fillable = [
        'name',
        'address',
        'address_post',
        'telephone',
        'mobile',
        'fax',
        'email',
        'web',
        'tandc',
        'tpin',
        'acc_name',
        'status',
        'logo',
        'letter_head',
    ];
}
