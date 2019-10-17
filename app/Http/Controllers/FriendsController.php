<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use Illuminate\Support\Facades\DB;
use Edujugon\PushNotification\PushNotification;

class FriendsController extends Controller
{
    public function addFriend(Request $request){
        $user1 = User::find($request->user1_id);
        $user2 = User::find($request->user2_id);
        if ($user1->isFollowing($user2)) {
            return response()->json(['status'=>true], 200);
        }else{
            $user1->follow($user2);
            $userToken = $user2->deviceToken;
            $push = new PushNotification('fcm');
            $push->setMessage([
           'notification' => [
                   'title'=>'طلب متابعة',
                   'body'=>'ارسل اليك ' . $user1->name . ' طلب متابعة',
                   'sound' => 'default'
                   ]
           ])
            ->setApiKey('AIzaSyBJdHvkUToH48WbxvcdlHiDJorE3FHCAew')
            ->setDevicesToken($userToken)
            ->send();
            return response()->json(['status'=>true, 'id'=>$request->user2_id], 200);
        }
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
		$friends = $user->followings()->get();
        $test = collect($friends);
        $test2 = $test;
        return $test->where('pivot.status', '1')->values();
    }

    public function getFollowRequests(){
        $user = Auth::user();
        $followRequests = $user->followers()->get();
        $test = collect($followRequests);
        $test2 = $test;
        return $test->where('pivot.status', '0')->values();
    }

    public function getFollowRequestsCount(){
        $user = Auth::user();
        $followRequests = $user->followers()->get();
        $test = collect($followRequests);
        $test2 = $test;
        return $test->where('pivot.status', '0')->values()->count();
    }

    public function acceptFollowRequest($id1 = null, $id2 = null)
    {
        $user1 = User::find($id1);
        $user2 = User::find($id2);
        DB::table('followables')->where('user_id', $id1)->where('followable_id', $id2)->update(['status' => 1]);
            $userToken = $user1->deviceToken;
            $push = new PushNotification('fcm');
            $push->setMessage([
           'notification' => [
                   'title'=>'تم قبول طلب المتابعة',
                   'body'=>'لقد قام ' . $user2->name . ' بقبول طلب متابعتك',
                   'sound' => 'default'
                   ]
           ])
            ->setApiKey('AIzaSyBJdHvkUToH48WbxvcdlHiDJorE3FHCAew')
            ->setDevicesToken($userToken)
            ->send();
        return response()->json(['status'=>true, 'id'=>$id1], 200);
    }

    public function getFriendData($id = null, Request $request){
        $user = User::find($id);
        return $user;
    }

    public function deleteFriend(Request $request){
        $user1 = User::find($request->user1_id);
        $user2 = User::find($request->user2_id);
        $user1->unfollow($user2);
        $user1->unfavorite($user2);
     }

    public function isFriend($user1_id=null, $user2_id=null){
        $user1 = User::find($user1_id);
        $user2 = User::find($user2_id);
        if ($user1->isFollowing($user2)) {
            $following = DB::table('followables')->where('user_id', $user1_id)->where('followable_id', $user2_id)->get('status');
            if ($following[0]->status == 1) {
                return response()->json(['status'=>'true']);
            }
                return response()->json(['status'=>'false']);
        }
        return response()->json(['status'=>'notFriends']);
    }

    public function search($id, $name = null, Request $request)
    {
        $user = User::find($id);
        $friends = $user->followings()->where('name', 'like', '%' . $name . '%')->get();
        $test = collect($friends);
        $test2 = $test;
        return $test->where('pivot.status', '1')->values();
    }

    public function addFriendFromGallery(Request $request)
    {
        $image = $request->image;
        $image = substr($image, strpos($image, ",")+1);
        $data = base64_decode($image);
        $png_url = "qr-".time().".png";
        $path = public_path().'/img/users/' . $png_url;
        file_put_contents($path, $data);
        return response()->json(['photo'=>$png_url]);
    }
}
