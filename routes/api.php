<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('register', 'Auth\AuthController@register');
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::post('user', 'Auth\AuthController@user');
        Route::post('addFriend', 'FriendsController@addFriend');
        Route::post('addFriendQr', 'FriendsController@addFriendQr');
        Route::post('addFavourite', 'favouritesController@addFavourite');
        Route::post('isFavorited', 'favouritesController@isFavorited');
        Route::post('getFavourites', 'favouritesController@getFavourites');
        Route::post('removeFavourite', 'favouritesController@removeFavourite');
        Route::post('updateUser', 'Auth\AuthController@update');
        Route::post('getFriends', 'FriendsController@getFriends');
        Route::post('isFriend', 'FriendsController@isFriend');
        Route::post('deleteFriend', 'FriendsController@deleteFriend');
        Route::post('getFriendData', 'FriendsController@getFriendData');
        Route::post('search', 'Auth\AuthController@search');
        Route::post('getads', 'AdvertisementsController@getAdvertisements');
        Route::post('getadscount', 'AdvertisementsController@getAdvertisementsCount');
    });
});
