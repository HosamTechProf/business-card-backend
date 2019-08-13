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

Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/home', 'AdminController@index')->name('admin.home');
    Route::get('/users', 'AdminController@getUsers');
    Route::get('/users/info/{id}', 'AdminController@userInfo')->name('admin.userInfo');
    Route::get('/users/edit/{id}', 'AdminController@showEditForm');
    Route::post('/users/edit/{id}', 'AdminController@editUser')->name('admin.userEdit');
});

Route::get('test', function(){


$user = User::find(4);

dd($user->favourites);


	// DB::table("friends")->where("user1_id", 1)->where("user2_id", 2)->delete();

        // $user->delete();

// $input = ['user1_id'=>3, 'user2_id'=>4];
// $friend = Friend::create($input);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
