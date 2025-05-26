<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'email'=>'required|string|email|unique:users',
            'password' =>'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        return response()->json($user);
    }
    public function login(Request $request){
        $validated = $request->validate([
            'email'=>'required|email',
            'password' =>'required',
        ]);
        $user = User::where('email',$validated['email'])->first();
        if(!$user || !Hash::check($validated['password'], $user->password)){
            throw ValidationException::withMessages([
                'email' => ['Informations incorrectes'],
            ]);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['token'=>$token]);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message'=>'Déconnection réusssie']);
    }
}
