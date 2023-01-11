<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{

    public function login(LoginRequest $request){
        $credentials = $request->only("email", "password");
        $request_user = $request->validate([
            "email"=> 'required',
            "password"=> 'required',
        ]);
        $user = User::where('email', $request_user['email'])->first();


        // if (auth()->attempt(["email"=>$request_user['email'] , "password"=>$request_user['password']])) {
        //     // return $user->createToken($request->device_name)->plainTextToken;
        //     return [];
        // }
        if(!$user || $user->password != $request_user['password']){
            return "Failed";
        }
        return [
            "user" => $user,
            "token" => $user->createToken('app-secret',['list'])->plainTextToken
        ];
    }

     public function register(Request $request){
        $request_user = $request->validate([
            "email"=> 'required',
            "password"=> 'required',
            "active"=> 'nullable'
        ]);
        $user = User::create([
            "email"=> $request_user['email'],
            "password"=> $request_user['password'],
            "active"=> $request_user['active'] ?? true,
        ]);
        return [
            "user" => $user,
            "token" => $user->createToken('app-secret')->plainTextToken
        ];

    }
}
