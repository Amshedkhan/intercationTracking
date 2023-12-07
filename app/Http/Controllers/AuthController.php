<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()  
    {
        $this->middleware('JWT', ['except' => ['login', 'signup']]);
    }


    public function login(Request $request){
        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        $credentials = $request->only('email', 'password');
        
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create token',
            ], 500);
        }
        
        $user = JWTAuth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

    }
    public function signup(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:6',
            'name' => 'required',
        ]);
        $arr = [];
        $arr['name'] = $request->name;
        $arr['password'] = Hash::make($request->password);
        $arr['email'] = $request->email;
        User::Create($arr);
        return $this->login($request);

    }
    
    
    public function logout(Request $request){

    }
}
