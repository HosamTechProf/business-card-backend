<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    public $timestamps = false;
    protected $table = "favourites";
    protected $fillable = [
        'user1_id', 'user2_id'
    ];
}
