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
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {

        $request->validated();

        if(!Auth::attempt($request->only('name', 'password'))){
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('name', $request->name)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API token of ' . $user->name)->plainTextToken,

        ]);
    }
    public function register(StoreUserRequest $request)
    {
        $request->validated();

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $profileImagePath = $profileImage->store('profile_images', 'public');
            $profileImageUrl = Storage::url($profileImagePath);
            
        } else {
            $profileImageUrl = '';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $profileImageUrl,
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
