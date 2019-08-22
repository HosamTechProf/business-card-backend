<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advertisement;

class AdvertisementsController extends Controller
{
    public function getAdvertisements(){
    	$advertisements = Advertisement::get();
    	return $advertisements;
    }
    public function getAdvertisementsCount(){
    	$advertisementsCount = Advertisement::get()->count();
    	return $advertisementsCount;
    }
}
