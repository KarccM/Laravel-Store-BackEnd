<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function register(Request $request){
        $request_user = $request->validate([
            "username"=> 'required',
            "password"=> 'required|unique:users,username',
            "is_active"=> 'nullable'
        ]);
        $user = User::create([
            "username"=> $request_user['username'],
            "password"=> $request_user['password'],
            "is_active"=> $request_user['is_active'] ?? true,
        ]);
        return [
            "user" => $user,
            "token" => $user->createToken('app-secret')->plainTextToken
        ];
        
    }
}
