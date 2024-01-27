<?php

namespace app\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmRegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'required|size:50',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
