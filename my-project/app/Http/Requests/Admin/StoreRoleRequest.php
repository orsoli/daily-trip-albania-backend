<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'name')->ignore($this->role)
            ],
            'slug' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z0-9-]+$/', // Ensures that the slug contains only lowercase letters, numbers, and '-'
                Rule::unique('roles', 'slug')->ignore($this->role)
            ],
            'description' => [
                'nullable',
                'string',
                'max:500'
            ],
        ];
    }
}