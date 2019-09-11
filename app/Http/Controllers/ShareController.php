<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sharelink;

class ShareController extends Controller
{
    public function share(Request $request)
    {
    	$user_id = $request->user_id;
    	$token = $request->token;
    	$link = new Sharelink;
    	$link->user_id = $user_id;
    	$link->token = $token;
    	$link->save();
        return response()->json(['status'=>true, 'token'=> $token], 200);
    }

    public function updateShare(Request $request)
    {
    	$token = $request->token;
    	$user_id = $request->user_id;
    	$user2_id = $request->user2_id;
	    $link = App\Sharelink::where('token', $token)->where('user_id', $user_id);
	    if ($link->user_id == $user2_id) {
        	return response()->json(['msg'=>'رابط خطأ','status'=>false]);
	    }
	    elseif ($link->user_id != null) {
	    	return response()->json(['msg'=>'رابط خطأ','status'=>false]);
	    }
	    elseif ($link->user_id == null) {
		    $link->user2_id = $user2_id;
		    $link->save();
	    	return response()->json(['msg'=>'رابط خطأ','status'=>true]);
	    }
    }
}