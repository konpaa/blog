<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use app\Http\Requests\Api\Auth\ConfirmRegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use app\Http\Requests\Api\Auth\RegisterRequest;
use app\Http\Requests\Api\Auth\ResetConfirmRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Notifications\Api\AuthConfirmRegisterNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $user->notify(new AuthConfirmRegisterNotification());

        return new UserResource($user);
    }

    public function confirm(ConfirmRegisterRequest $request)
    {
        $userId = Cache::get('register:' . $request->input('code'));
        if ($userId) {
            Cache::forget('register:' . $request->input('code'));
            $user = User::findOrFail($userId);
            $user->markEmailAsVerified();

            return [
                'token' => $user->createToken('API Token')->plainTextToken
            ];
        }
        throw ValidationException::withMessages(['code' => __('validation.incorrect_code')]);
    }

    public function resetConfirm(ResetConfirmRequest $request)
    {
        $user = User::whereEmail($request->input('email'))->first();
        if ($user && !$user->email_verified_at) {
            $user->notify(new AuthConfirmRegisterNotification());
        }
        return response()->noContent();
    }

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
