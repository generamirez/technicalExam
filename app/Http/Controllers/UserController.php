<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function me(Request $request){
        return User::with('events', 'tickets')->find($request->id);
    }

    public function store(Request $request){

        $validator =
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors(),'code'=> '422']);
        }
        else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->remember_token = Str::random(10);


             $user->save();
        }

    }
}
