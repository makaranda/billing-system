<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelInformation extends Model
{
    use HasFactory;
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
