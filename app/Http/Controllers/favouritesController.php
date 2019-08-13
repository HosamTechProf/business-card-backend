<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favourite;
use DB;
use Illuminate\Support\Facades\Auth;

class favouritesController extends Controller
{
    public function addFavourite(Request $request)
    {
        $input = $request->all();
        $friend = Favourite::create($input);
        return response()->json(['status'=>true], 200);
    }
    public function removeFavourite(Request $request)
    {
        $input = $request->all();
		DB::table("favourites")->where("user1_id", $input['user1_id'])->where("user2_id", $input['user2_id'])->delete();
        return response()->json(['status'=>true], 200);
    }
    public function isFavorited(Request $request)
    {
        $input = $request->all();
        return DB::table("favourites")->where("user1_id", $input['user1_id'])->where("user2_id", $input['user2_id'])->count();
    }
    public function getFavourites(){
        $user = Auth::user();
		return $user->favourites;
    }
}
