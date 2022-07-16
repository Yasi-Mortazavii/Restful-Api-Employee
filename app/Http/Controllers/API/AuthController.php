<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $validatedData = $request->validate([
            'name'     =>  'required|max:225',
            'email'    =>  'email|required|unique:users',
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
    public function login(Request $request){
        $loginData = $request->validate([
            'email'    =>  'email|required|unique:users',
            'password' =>  'required|confirmed',
        ]);

        if(!auth()->attempt($loginData)){
            return response(['message' => 'This User dose not exist. Check your details', 400]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response([
            'user'        => auth()->user(),
            'accessToken' => $accessToken
        ]);
    }
}
