<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Auth};
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    function register(Request $request){
        try{
            $validate = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'is_admin' => 'boolean'
            ]);
    
            $validate['password'] = Hash::make($validate['password']);
    
            $user = User::create($validate);
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json(['user' => $user, 'access_token' => $token], 201);
        }catch(ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    function login(Request $request){
        try{
            $validate = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();
            
            if($user && Hash::check($request->password, $user->password)){
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json(['access_token' => $token, 'is_admin' => $user->is_admin], 200);
            }

            return response()->json(['error' => 'Unauthorized'], 401);
        }catch(ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out success'], 200);
    }
}
