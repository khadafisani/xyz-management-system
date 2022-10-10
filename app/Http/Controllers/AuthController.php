<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
   public function register(RegisterRequest $request)
   {
    $data = $request->validated();

    try {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return response()->api($user, 200, 'ok', 'Successfully register user');
    } catch (Exception $e) {
        return response()->api([], 400, 'error', 'Failed to register new user');
    }
   }
}
