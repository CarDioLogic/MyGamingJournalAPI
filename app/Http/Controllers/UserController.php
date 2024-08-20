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

    public function show(int $id)
    {
        if (Auth::User()->id !== $id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

        $user = User::find($id);

        if ($user) {
            return $this->success([
                'user' => $user,
            ]);
        } else {
            return $this->error([
                'message' => "User not found!",
            ]);
        }
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated();

        if (!Auth::attempt($request->only('name', 'password'))) {
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
            $filename = 'profile_image_' . $request->name . '.' . $profileImage->getClientOriginalExtension();

            $profileImagePath = $profileImage->storeAs('profile_images', $filename, 'public');
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

    public function update(StoreUserRequest $request)
    {
        $request->validated();

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $filename = 'profile_image_' . $request->name . '.' . $profileImage->getClientOriginalExtension();

            $profileImagePath = $profileImage->storeAs('profile_images', $filename, 'public');
            $profileImageUrl = Storage::url($profileImagePath);

        } else {
            $profileImageUrl = '';
        }

        $user = User::update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $profileImageUrl,
        ]);

        return $this->success([
            'user' => $user,
        ]);
    }

    public function updateUser(Request $request, int $id)
    {

        $user = User::find($id);

        if (Auth::User()->id !== $user->id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        } 

        if (!$user) {
            return $this->error(['message' => "User not found!"], 404);
        }

        if ($request->hasFile('profile_image')) {
            // Delete the old profile image if it exists
            if ($user->profile_image) {
                $profileImagePath = $user->profile_image;
                Storage::disk('public')->delete($profileImagePath);
            }
    
            $profileImage = $request->file('profile_image');
            $filename = 'profile_image_' . $request->name . '.' . $profileImage->getClientOriginalExtension();
                    
            $profileImagePath = $profileImage->storeAs('profile_images', $filename, 'public');
            $user->profile_image = Storage::url($profileImagePath);
        }
        $user->update($request->except('profile_image'));
    
        $token = $user->createToken('API token of ' . $user->name)->plainTextToken;
    
        return $this->success([
            'user' => $user,
            'token' => $token,
        ]);
    }
    
    public function destroy($id)
    {
        $user = User::find($id);

        if (Auth::User()->id !== $user->id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        } 
        if (!$user) {
            return $this->error(['message' => "User not found!"], 404);
        }
        if ($user->profile_image) {
            $profileImagePath = $user->profile_image;
            Storage::disk('public')->delete($profileImagePath);
        }
        $user->delete();
        return $this->success([
            'message' => 'You have succesfuly deleted your account!'
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
