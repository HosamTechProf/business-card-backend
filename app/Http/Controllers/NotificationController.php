<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Edujugon\PushNotification\PushNotification;

class NotificationController extends Controller
{
    public function addDeviceToken(Request $request)
    {
    	$user = Auth::user();
    	$user->deviceToken = $request->deviceToken;
    	$user->save();
        return response()->json(['status'=>true], 200);
    }

    public function sendNotification(Request $request)
    {
    	$usersTokens = User::all()->pluck('deviceToken')->toArray();
    	$push = new PushNotification('fcm');
    	$push->setMessage([
       'notification' => [
               'title'=>$request->title,
               'body'=>$request->body,
               'sound' => 'default'
               ]
       ])
    ->setApiKey('AIzaSyBJdHvkUToH48WbxvcdlHiDJorE3FHCAew')
    ->setDevicesToken($usersTokens)
    ->send();
      return view('admin.notifications.index');
    }

    public function sendNotificationForm()
    {
        return view('admin.notifications.index');

    }
}
