<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            throw new AuthenticationException(__('validation.incorrect_credentials'));
        }
        if (!auth()->user()->email_verified_at) {
            throw new AuthorizationException(__('validation.validate_email_first'));
        }

        return [
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ];
    }
}
