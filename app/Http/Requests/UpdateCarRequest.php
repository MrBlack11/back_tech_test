<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "brand" => "string|max:20",
            "model" => "string|max:40",
            "year" => "integer",
            "renavam" => "string|max:11",
            "plate" => "string|max:10",
            "color" => "string|max:20"
        ];
    }
}
