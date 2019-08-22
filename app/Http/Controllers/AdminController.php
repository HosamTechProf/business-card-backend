<?php

namespace App\Http\Controllers;
use App\User;
use App\Favourite;
use App\Advertisement;
use Illuminate\Http\Request;
use Validator;
use App\Traits\UploadTrait;

class AdminController extends Controller
{
  use UploadTrait;
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
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function userInfo($id, Request $request){
        $userData = User::findOrFail($id);
        $userFriends = $userData->followings()->get();
        $userFavourites = $userData->favourites;
        return view('admin.users.info', compact(['userData', 'userFriends', 'userFavourites']));
    }

    public function showEditForm($id, Request $request)
    {
        $userData = User::findOrFail($id);
        return view('admin.users.edit', compact('userData'));
    }

    public function editUser($id, Request $request){
        if ($request->password != null) {
          $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6',
            'mobile' => 'required',
            'desc' => 'required',
            'company' => 'required'
          ]);
          $input = $request->except('_token');
          $input['password'] = bcrypt($input['password']);
          User::where('id', $id)->update($input);
          return redirect()->route('admin.userInfo', ['id'=>$id]);
        }
        $request->validate([
          'name' => 'required',
          'email' => 'required|email|unique:users,email,' . $id,
          'mobile' => 'required',
          'desc' => 'required',
          'company' => 'required'
        ]);
        $input = $request->except(['_token', 'password']);
        User::where('id', $id)->update($input);
        return redirect()->route('admin.userInfo', ['id'=>$id]);
    }

    public function deleteUser($id, Request $request){
        User::destroy($id);
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function addUser(Request $request){
        $request->validate([
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6',
          'mobile' => 'required',
          'desc' => 'required',
          'company' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        User::create($input);
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function showAddForm(){
        return view('admin.users.add');
    }
    public function deleteFollow($followed, $follower)
    {
        $user1 = User::find($follower);
        $user2 = User::find($followed);
        $user1->unfollow($user2);
        return redirect()->route('admin.userInfo', ['id'=>$follower]);
    }
    public function deleteFavourite($favourited, $favouriter)
    {
        Favourite::where("user1_id", $favouriter)->where("user2_id", $favourited)->delete();
        return redirect()->route('admin.userInfo', ['id'=>$favouriter]);
    }
    public function getAdvertisements()
    {
        $advertisements = Advertisement::paginate(20);
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function showAddAdvertisementForm()
    {
        return view('admin.advertisements.add');
    }

    public function addAdvertisement(Request $request)
    {
        $request->validate([
            'name'              =>  'required',
            'link'              =>  'required',
            'photo'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $photo = $request->file('photo');
        // Make a photo name based on user name and current timestamp
        $name = str_slug($request->input('name')).'_'.time();
        // Define folder path
        $folder = '/img/advertisements/';
        // Make a file path where photo will be stored [ folder path + file name + file extension]
        $filePath = $folder . $name. '.' . $photo->getClientOriginalExtension();
        // Upload photo
        $this->uploadOne($photo, $folder, 'public', $name);
        // Set user profile photo path in database to filePath
        $advertisement = new Advertisement;
        $advertisement->name = $request->name;
        $advertisement->link = $request->link;
        $advertisement->photo = $filePath;
        $advertisement->save();
        $advertisements = Advertisement::paginate(20);
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function editAdvertisement($id, Request $request)
    {
        if ($request->hasfile('photo')) {
          $request->validate([
              'name'              =>  'required',
              'link'              =>  'required',
              'photo'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
          ]);

          $photo = $request->file('photo');
          // Make a photo name based on user name and current timestamp
          $name = str_slug($request->input('name')).'_'.time();
          // Define folder path
          $folder = '/img/advertisements/';
          // Make a file path where photo will be stored [ folder path + file name + file extension]
          $filePath = $folder . $name. '.' . $photo->getClientOriginalExtension();
          // Upload photo
          $this->uploadOne($photo, $folder, 'public', $name);

          $input = $request->except('_token');
          $input['photo'] = $filePath;
          Advertisement::where('id', $id)->update($input);
        }
        $request->validate([
          'name'              =>  'required',
          'link'              =>  'required'
        ]);
        $input = $request->except(['photo', '_token']);
        Advertisement::where('id', $id)->update($input);
        $advertisements = Advertisement::paginate(20);
        return view('admin.advertisements.index', compact('advertisements'));
    }
    public function showAdvertisementEditForm($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('admin.advertisements.edit', compact('advertisement'));
    }
    public function deleteAdvertisement($id)
    {
        Advertisement::destroy($id);
        $advertisements = Advertisement::paginate(20);
        return view('admin.advertisements.index', compact('advertisements'));
    }
}
