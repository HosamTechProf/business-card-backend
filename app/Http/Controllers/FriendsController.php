<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use DB;
class FriendsController extends Controller
{
    public function addFriend(Request $request)
    {
        $input = $request->all();
        $friend = Friend::create($input);
        return response()->json(['status'=>true], 200);
    }

    public function getFriends(){
        $user = Auth::user();
		return $user->friends;
    }

    public function getFriendData(Request $request){
        $id = $request->id;
        $user = User::find($id);
        return $user;
    }

    public function recentlyUsed(){
        $user = Auth::user();
        return $user->friends->take(4);
    }

    public function deleteFriend(Request $request){
        $input = $request->all();
        if (Friend::where('user1_id', '=', $input['user1_id'])->where('user2_id' , '=', $input['user2_id'])->exists()) {
            Friend::where('user1_id', '=', $input['user1_id'])->where('user2_id' , '=', $input['user2_id'])->delete();
        return response()->json(['status'=>true], 200);
        }
        elseif (Friend::where('user2_id', '=', $input['user1_id'])->where('user1_id' , '=', $input['user2_id'])->exists()) {
            Friend::where('user1_id', '=', $input['user1_id'])->where('user2_id' , '=', $input['user2_id'])->delete();
        return response()->json(['status'=>true], 200);
        }
    }

    public function isFriend(Request $request)
    {
        $input = $request->all();
        $first = DB::table("friends")->where("user1_id", $input['user1_id'])->where("user2_id", $input['user2_id'])->count();
        $second = DB::table("friends")->where("user2_id", $input['user1_id'])->where("user1_id", $input['user2_id'])->count();
        return $first + $second;
    }
}
