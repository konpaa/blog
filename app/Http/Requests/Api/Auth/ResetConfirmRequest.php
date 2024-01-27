<?php

namespace app\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetConfirmRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}
