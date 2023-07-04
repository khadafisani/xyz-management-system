<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
   public function register(RegisterRequest $request)
   {
    $data = $request->validated();

    \DB::beginTransaction();
    try {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        \DB::commit();
        return response()->api($user, 200, 'ok', 'Successfully register user');
    } catch (\Exception $e) {
        \DB::rollback();
        return response()->api([], 400, 'error', 'Failed to register new user');
    }
   }

   public function login(LoginRequest $request)
   {
    $data = $request->validated();

    try {
        if(! Auth::attempt($data)) {
            return response()->api([], 403, 'Email or password incorrect');
        }

        $data = [
            'user' => auth()->user(),
            'access_token' => auth()->user()->createToken('authToken')->accessToken
        ];
        return response()->api($data, 200, 'ok', 'Successfully logged in');
    }catch(\Exception $e) {
        return response()->api([], 400, 'error', 'Failed to login');
    }
   }

   public function logout()
   {
    auth()->user()->token()->revoke();
    return response()->api([], 200, 'ok', 'Successfully logged out');
   }

   public function profile()
   {
    return response()->api(auth()->user()->load('customer'), 200, 'ok', 'Successfully get profile');
   }

   public function updateProfile(UpdateProfileRequest $request)
   {
    $data = $request->validated();

    \DB::beginTransaction();
    try {
        $user = auth()->user();
        $customerData = Arr::pull($data, 'customer');
        $customer = Customer::where('user_id', '=', $user->id)->first();
        if(!$customer) {
            Customer::create([...$customerData, 'user_id' => $user->id]);
        } else {
            $customer->update($customerData);
        }

        $user->update($data);
        \DB::commit();
        return response()->api($user->load('customer'), 200, 'ok', 'Successfully update profile');
    }catch(\Exception $e) {
        \DB::rollback();
        return response()->api([], 400, 'error', 'Failed to update profile');
    }
   }
}
