<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public $timestamps = false;
    protected $table = "friends";
    protected $fillable = [
        'user1_id', 'user2_id'
    ];
}
