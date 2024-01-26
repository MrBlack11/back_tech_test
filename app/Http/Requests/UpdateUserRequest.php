<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = request()->route('user');

        return [
            'email' => 'email|unique:users,email,' . $userId,
            'password' => 'min:6|string',
            'name' => 'string|max:255'
        ];
    }
}
