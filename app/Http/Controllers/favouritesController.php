<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favourite;
use App\User;

use Illuminate\Support\Facades\Auth;

class favouritesController extends Controller
{
    public function addFavourite(Request $request)
    {
        $input = $request->only(['user1_id', 'user2_id']);
        $user1 = User::findOrFail($input["user1_id"]);
        $user2 = User::findOrFail($input["user2_id"]);
        $user1->favorite($user2);
        return response()->json(['status'=>true], 200);
    }

    public function removeFavourite(Request $request, $user1_id=null, $user2_id=null)
    {
        $user1 = User::findOrFail($user1_id);
        $user2 = User::findOrFail($user2_id);
        $user1->unfavorite($user2);
        return response()->json(['status'=>true], 200);
    }

    public function isFavorited(Request $request, $user1_id=null, $user2_id=null)
    {
        $user1 = User::findOrFail($user1_id);
        $user2 = User::findOrFail($user2_id);
        if ($user1->hasFavorited($user2)) {
            return 'true';
        }
            return 'false';
        }

    public function getFavourites(){
        $user = Auth::user();
		return $user->favorites()->get();
    }
}
