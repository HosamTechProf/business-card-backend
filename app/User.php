<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Friend;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','desc','company','mobile','isPublic'
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

    protected function friendsOfThisUser()
    {
        return $this->belongsToMany('App\User', 'friends', 'user1_id', 'user2_id');
    }

    // friendship that this user was asked for
    protected function thisUserFriendOf()
    {
        return $this->belongsToMany('App\User', 'friends', 'user2_id', 'user1_id');
    }

    // accessor allowing you call $user->friends
    public function getFriendsAttribute()
    {
        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();
        return $this->getRelation('friends');
    }

    protected function loadFriends()
    {
        if ( ! array_key_exists('friends', $this->relations))
        {
        $friends = $this->mergeFriends();
        $this->setRelation('friends', $friends);
    }
    }

    protected function mergeFriends()
    {
        if($temp = $this->friendsOfThisUser)
        return $temp->merge($this->thisUserFriendOf);
        else
        return $this->thisUserFriendOf;
    }
    public function addFriend()
    {
        return $this->hasMany('App\Friend');
    }
    public function favourites()
    {
        return $this->belongsToMany('App\User', 'favourites', 'user1_id', 'user2_id');
    }
}
