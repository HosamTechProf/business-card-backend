<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactusController extends Controller
{
    public function sendContactus(Request $request)
    {
    	$name = $request->name;
    	$email = $request->email;
    	$message = $request->message;

    	$contact = new Contact;
    	$contact->name = $name;
    	$contact->email = $email;
    	$contact->message = $message;
    	$contact->save();
        return response()->json(['status'=>true]);
    }
}
