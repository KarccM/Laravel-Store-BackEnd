<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
 
class LoginController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only("username", "password");
        $request_user = $request->validate([
            "username"=> 'required',
            "password"=> 'required',
        ]);
        $user = User::where('username', $request_user['username'])->first();


        // if (auth()->attempt(["username"=>$request_user['username'] , "password"=>$request_user['password']])) {
        //     // return $user->createToken($request->device_name)->plainTextToken;
        //     return [];
        // }
        if(!$user || $user->password != $request_user['password']){
            return "Failed";
        }
        return [
            "user" => $user,
            "token" => $user->createToken('app-secret')->plainTextToken
        ];
    }
}
