<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password]);
        if ($token) {
            return $this->setStatusCode(201)->success(['token' => $token]);
        }
        return $this->failed('账号或密码错误');
    }

    public function profile(Request $request)
    {
        return $this->success(new UserResource(Auth::guard('api')->user()));
    }
}
