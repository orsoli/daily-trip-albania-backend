<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class storeOrUpdateTourRequest extends FormRequest
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
            'guide_id'             => 'nullable|exists:users,id',
            'region_id'            => 'required|exists:regions,id',
            'title'                => 'required|string|max:255',
            'thumbnail'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'          => 'nullable|string',
            'is_active'            => 'boolean',
            'price'                => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'duration'             => 'nullable|string|max:255',
            'difficulty'           => 'nullable|string|max:255',

            // Pivot tables
            'categories'           => 'required|array',
            'categories.*'         => 'exists:categories,id',

            'destinations'         => 'required|array',
            'destinations.*'       => 'exists:destinations,id',

            'services'             => 'required|array',
            'services.*'           => 'exists:services,id',

            // Gallery images
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
