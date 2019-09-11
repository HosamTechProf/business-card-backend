<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sharelink extends Model
{
    public function user()
    {
        return $this->belongsTo('App\user');
    }
}
