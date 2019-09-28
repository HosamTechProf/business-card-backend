<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Friend;

class FriendsController extends Controller
{
    public function addFriend(Request $request){
        $user1 = User::find($request->user1_id);
        $user2 = User::find($request->user2_id);
        $user1->follow($user2);
        return response()->json(['status'=>true], 200);
    }

    public function addFriendQr(Request $request){
        $user1 = User::find($request->user1_id);
        $user2 = User::find($request->user2_id);
        $user1->follow($user2);
        $user2->follow($user1);
        return response()->json(['status'=>true], 200);
    }

    public function getFriends(){
        $user = Auth::user();
		return $user->followings()->get();
    }

    public function getFriendData($id = null, Request $request){
        $user = User::find($id);
        return $user;
    }

    public function deleteFriend(Request $request){
        $user1 = User::find($request->user1_id);
        $user2 = User::find($request->user2_id);
        $user1->unfollow($user2);
     }

    public function isFriend(Request $request, $user1_id=null, $user2_id=null){
        $user1 = User::find($user1_id);
        $user2 = User::find($user2_id);
        if ($user1->isFollowing($user2)) {
            return 'true';
        }
            return 'false';
        }
    public function search($id, $name = null, Request $request)
    {
        $user = User::find($id);
        return $user->followings()->where('name', 'like', '%' . $name . '%')->get();
    }

}
