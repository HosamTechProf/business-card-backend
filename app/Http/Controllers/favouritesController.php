<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favourite;

use Illuminate\Support\Facades\Auth;

class favouritesController extends Controller
{
    public function addFavourite(Request $request)
    {
        $input = $request->all();
        $friend = Favourite::create($input);
        return response()->json(['status'=>true], 200);
    }

    public function removeFavourite(Request $request, $user1_id=null, $user2_id=null)
    {
		Favourite::where("user1_id", $user1_id)->where("user2_id", $user2_id)->delete();
        return response()->json(['status'=>true], 200);
    }

    public function isFavorited(Request $request, $user1_id=null, $user2_id=null)
    {
        return Favourite::where("user1_id", $user1_id)->where("user2_id", $user2_id)->count();
    }

    public function getFavourites(){
        $user = Auth::user();
		return $user->favourites;
    }
}
