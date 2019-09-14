<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Friend;
use App\Sharelink;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanFavorite;
use Overtrue\LaravelFollow\Traits\CanBeFavorited;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, CanFollow, CanBeFollowed, CanFavorite, CanBeFavorited;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','desc','company','mobile','isPublic','socialLink','deviceToken'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForFcm() {
        //return a device token, either from the model or from some other place.
        return $this->device_token;
    }

    public function favourites()
    {
        return $this->belongsToMany('App\User', 'favourites', 'user1_id', 'user2_id');
    }

    public function links()
    {
        return $this->hasMany('App\Sharelink');
    }
}
