<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class FilesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'preview' => 'required|file',
            'addition_files' => 'array',
            'addition_files.*.image' => 'image'
        ];
    }
}
