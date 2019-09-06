<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use App\Friend;
use App\Notifications\MyNotification;
use Propaganistas\LaravelPhone\PhoneNumber;

Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/home', 'AdminController@index')->name('admin.home');
    Route::get('/users', 'AdminController@getUsers');
    Route::get('/users/info/{id}', 'AdminController@userInfo')->name('admin.userInfo');
    Route::get('/users/edit/{id}', 'AdminController@showEditForm')->name('admin.userEditGet');
    Route::post('/users/edit/{id}', 'AdminController@editUser')->name('admin.userSave');
    Route::get('/users/delete/{id}', 'AdminController@deleteUser')->name('admin.userDelete');
    Route::get('/users/add', 'AdminController@showAddForm')->name('admin.addUserGet');
    Route::post('/users/add', 'AdminController@addUser')->name('admin.addUser');


    Route::get('/users/deletefollow/{followed}&{follower}', 'AdminController@deleteFollow')->name('admin.deleteFollow');
    Route::get('/users/deletefavourite/{favourited}&{favouriter}', 'AdminController@deleteFavourite')->name('admin.deleteFavourite');

    Route::get('/advertisements', 'AdminController@getAdvertisements');
    Route::get('/advertisements/add', 'AdminController@showAddAdvertisementForm')->name('admin.addAdvertisementGet');
    Route::post('/advertisements/add', 'AdminController@addAdvertisement')->name('admin.addAdvertisement');
    Route::get('/advertisements/info/{id}', 'AdminController@advertisementInfo')->name('admin.advertisementInfo');
    Route::get('/advertisements/edit/{id}', 'AdminController@showAdvertisementEditForm')->name('admin.advertisementEditGet');
    Route::post('/advertisements/edit/{id}', 'AdminController@editAdvertisement')->name('admin.advertisementSave');
    Route::get('/advertisements/delete/{id}', 'AdminController@deleteAdvertisement')->name('admin.advertisementDelete');

    Route::get('/users/search/', 'AdminController@usersSearch');
    Route::get('/users/adduserto/{id}', 'AdminController@adduserto')->name('admin.addusertoGet');
    Route::get('/users/adduserto/{id}/{friendid}', 'AdminController@saveUserTo')->name('admin.adduserto');
    Route::get('/users/adduserto/search/', 'AdminController@addusertoSearch');
});

Route::get('test', function(){

return PhoneNumber::make('01024325125')->getCountry();

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/codes', function(){
    return file_get_contents(storage_path() . "/json/codes.json");

});
