<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cdrs extends Model
{
    use HasFactory;

    protected $fillable = [
        'calldate',
        'clid',
        'src',
        'dst',
        'dcontext',
        'channel',
        'dstchannel',
        'lastapp',
        'lastdata',
        'duration',
        'billsec',
        'disposition',
        'amaflags',
        'accountcode',
        'uniqueid',
        'userfield',
        'did',
        'recordingfile',
        'cnum',
        'cnam',
        'outbound_cnum',
        'outbound_cnam',
        'dst_cnam',
        'linkedid',
        'peeraccount',
        'sequence'
    ];
}
