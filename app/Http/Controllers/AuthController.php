<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Auth};
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register a new user
    function register(Request $request){
        try{
            // Validate the request data
            $validate = $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'is_admin' => 'boolean'
            ]);
    
            // Hash the password before storing
            $validate['password'] = Hash::make($validate['password']);
            // Create the user with the validated data
            $user = User::create($validate);

            // Create an authentication token for the user
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // Return the user data and the access token
            return response()->json(['user' => $user, 'access_token' => $token], 201);
        }catch(ValidationException $e){
            // If validation fails, return the errors
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Login an existing user
    function login(Request $request){
        try{
            // Validate the request data
            $validate = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Find the user by email
            $user = User::where('email', $validate['email'])->first();
            
            // Check if the user exists and the password is correct
            if($user && Hash::check($validate['password'], $user->password)){
                // Create an authentication token for the user
                $token = $user->createToken('auth_token')->plainTextToken;
                // Return the access token and admin status
                return response()->json(['access_token' => $token, 'is_admin' => $user->is_admin], 200);
            }

            // If authentication fails, return an unauthorized error
            return response()->json(['error' => 'Unauthorized'], 401);
        }catch(ValidationException $e){
            // If validation fails, return the errors
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Logout the authenticated user
    function logout(Request $request){
        // Delete the user's current access token
        $request->user()->currentAccessToken()->delete();
        // Return a success message
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
