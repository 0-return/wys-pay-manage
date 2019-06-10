<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuiouStore extends Model
{
    protected $table = 'fuiou_stores';

    protected $fillable = [
        'store_id',
        'config_id',
        'mchnt_cd',
    ];

}
