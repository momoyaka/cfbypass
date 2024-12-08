<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BypassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => 'required|string|url', // Must be a valid URL.
            'method' => 'required|string|in:GET,POST,PUT,PATCH,DELETE,HEAD,OPTIONS', // Restrict to HTTP methods.
            'data' => 'nullable|array', // Optional and must be an array.
            'cookies' => 'nullable|array', // Optional and must be an array.
            'proxy' => 'nullable|string', // Optional and must be a valid URL.
        ];
    }
}
