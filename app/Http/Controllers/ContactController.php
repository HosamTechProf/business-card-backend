<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ContactController extends Controller
{
    public function getcontacts(Request $request)
    {
    	$users = collect();
    	for ($i=0; $i < $request->length; $i++) {
    			$user = User::where('mobile', 'like', '%' . str_replace( ' ', '',$request->contacts[$i]['number']['0']) . '%')->orWhere('mobile', 'like', '%' . str_replace( ' ', '',$request->contacts[$i]['number']['1']) . '%')->get();
        		$users->add($user);
    		}
    	return $users->sortBy('name')->filter()->flatten()->all();
    }
}
