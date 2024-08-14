<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use App\traits\HttpResponses;

class UserController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated();

        if(!Auth::attempt($request->only('email', 'password'))){
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API token of ' . $user->name)->plainTextToken,

        ]);
    }
    public function register(StoreUserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API token of ' . $user->name)->plainTextToken,

        ]);
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have succesfuly logged out and the token has been deleted!'
        ]);
    }
    
}
