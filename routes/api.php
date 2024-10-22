<?php

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('register', 'Auth\AuthController@register');
    Route::get('getcodes', 'Auth\AuthController@getCodes');
    Route::post('verifycode', 'Auth\AuthController@verifyCode');
    Route::post('sendcode', 'Auth\AuthController@sendCode');
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('user', 'Auth\AuthController@user');
        Route::get('isfavorited/{user1_id?}/{user2_id?}', 'favouritesController@isFavorited');
        Route::get('removefavourite/{user1_id?}/{user2_id?}', 'favouritesController@removeFavourite');
        Route::get('isfriend/{user1_id?}/{user2_id?}', 'FriendsController@isFriend');
        Route::post('addFriend', 'FriendsController@addFriend');
        Route::post('addFriendQr', 'FriendsController@addFriendQr');
        Route::post('addFriendFromGallery', 'FriendsController@addFriendFromGallery');
        Route::post('addFavourite', 'favouritesController@addFavourite');
        Route::get('getFavourites', 'favouritesController@getFavourites');
        Route::post('updateUser', 'Auth\AuthController@update');
        Route::get('getFriends', 'FriendsController@getFriends');
        Route::get('getfollowrequests', 'FriendsController@getFollowRequests');
        Route::get('getfollowrequestscount', 'FriendsController@getFollowRequestsCount');
        Route::post('deleteFriend', 'FriendsController@deleteFriend');
        Route::get('getFriendData/{id?}', 'FriendsController@getFriendData');
        Route::post('search', 'Auth\AuthController@search');
        Route::get('getads', 'AdvertisementsController@getAdvertisements');
        Route::get('getadscount', 'AdvertisementsController@getAdvertisementsCount');
        Route::get('user/followings/{id}/{name?}', 'FriendsController@search');
        Route::get('user/acceptfollowrequest/{id1?}/{id2?}', 'FriendsController@acceptFollowRequest');
        Route::post('share', 'ShareController@share');
        Route::post('updateshare', 'ShareController@updateShare');
        Route::post('adddevicetoken', 'NotificationController@addDeviceToken');
        Route::post('getcontacts', 'ContactController@getcontacts');
        Route::post('sendcontactus', 'ContactusController@sendContactus');
    });
});
Route::get('/codes', function(){
    return file_get_contents(storage_path() . "/json/codes.json");

});
