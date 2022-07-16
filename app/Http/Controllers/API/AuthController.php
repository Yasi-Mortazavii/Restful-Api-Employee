<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){

        $validatedData = $request->validate([
            'name'     =>  'required|max:225',
            'email'    =>  'required|unique:users',
            'password' =>  'required|confirmed',
        ]);

        $validatedData['password'] = Hash::make($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response([
            'user'         => $user,
            'accessToken'  => $accessToken
        ], 201);
    }
    
}
