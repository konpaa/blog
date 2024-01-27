<?php

namespace app\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
