<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "brand" => "required|string|max:20",
	        "model" => "required|string|max:40",
	        "year" => "required|integer",
        	"renavam" => "required|string|max:11",
	        "plate" => "required|string|max:10",
            "color" => "required|string|max:20"
        ];
    }
}
