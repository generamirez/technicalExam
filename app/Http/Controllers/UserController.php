<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me(Request $request){
        // return response()->json(['message'=>$request->all()]);
        return User::with('events', 'tickets')->find($request->id);
    }
}
