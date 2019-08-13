<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }
    public function getUsers()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }
    public function userInfo($id, Request $request){
        $userData = User::findOrFail($id);
        $userFriends = $userData->friends;
        $userFavourites = $userData->favourites;
        return view('admin.users.info', compact(['userData', 'userFriends', 'userFavourites']));
    }
    public function showEditForm($id, Request $request)
    {
        $userData = User::findOrFail($id);
        return view('admin.users.edit', compact('userData'));
    }
}
