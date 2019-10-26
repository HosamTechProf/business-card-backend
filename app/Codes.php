<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codes extends Model
{
    protected $fillable = [
        'name', 'code', 'dial_code'
    ];
    public $timestamps = false;
}
