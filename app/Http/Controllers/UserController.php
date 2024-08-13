<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\User;
use Hash;
use App\traits\HttpResponses;

class UserController extends Controller
{
    use HttpResponses;

    public function login()
    {
        return 'This is login!';
    }
    public function register(StoreUserRequest $request)
    {
        $request->validate($request->all());

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
        return response()->json('this is my logout');
    }
    
}
