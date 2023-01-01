<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
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
