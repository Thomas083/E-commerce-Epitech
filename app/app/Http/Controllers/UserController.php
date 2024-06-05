<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Create a new user instance after a valid registration.
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'login' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $user = new User();
        $user->login = $fields['login'];
        $user->email = $fields['email'];
        $user->password = bcrypt($fields['password']);
        $user->firstname = $fields['firstname'];
        $user->lastname = $fields['lastname'];
        $user->save();
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    /**
     * Login a user instance after a valid registration.
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('login', $fields['login'])->first();
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
    }

    /**
     * Logout a user instance after a valid registration and return a response with status code 204.
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        $response = [
            'message' => 'Logged out'
        ];
        return response($response, 204);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return User::find(auth()->user()->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $user = User::find(auth()->user()->id);
        $user->login = $request->login;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage and return a response with status code 204.
     */
    public function destroy()
    {
        $user = User::find(auth()->user()->id);
        $user->delete();
        $response = [
            'message' => 'User deleted'
        ];
        return response($response, 204);
    }
}
