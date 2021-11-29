<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function check_login(Request $request){

        $request->validate([
            'email' =>['required'],
            'password' =>['required'],
        ]);
       $user = User::where('email',$request->email)->first();
       if(!$user){
           return response()->json(['message'=> 'Not Found']);
       }
       if(Hash::check($request->password , $user->password)){
           $token = $user->createToken('secret key')->accessToken;
           return response()->json(['message'=> 'successfully login' , 'token' => $token]);
       }else{
        return response()->json(['message'=> 'Wrong Password']);
       }



    }
}
