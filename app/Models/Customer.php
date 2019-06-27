<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'title',
        'company',
        'industry',
        'province',
        'city',
        'area',
        'username',
        'phone',
        'created_at',
        'updated_at',
        'type',
        'status'
    ];

}
