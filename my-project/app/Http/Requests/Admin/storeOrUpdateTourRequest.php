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
            'guide_id'              => 'nullable|exists:users,id',
            'region_id'             => 'required|exists:regions,id',
            'accommodation_id'      => 'nullable|exists:accommodations,id',
            'title'                 => 'required|string|max:255',
            'thumbnail'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'           => 'nullable|string',
            'is_active'             => 'boolean',
            'wheelchair_accessible' => 'boolean',
            'price'                 => 'required|numeric|min:0|decimal:0,2|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'duration'              => 'nullable|string|max:255',
            'difficulty'            => 'nullable|string|max:255',

            // Pivot tables
            'categories'            => 'nullable|array',
            'categories.*'          => 'exists:categories,id',

            'destinations'          => 'nullable|array',
            'destinations.*'        => 'exists:destinations,id',

            'services'              => 'nullable|array',
            'services.*'            => 'exists:services,id',

            // Gallery images
            'gallery_images'        => 'nullable|array',
            'gallery_images.*'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Delete gallery images
            'delete_gallery_images' => 'nullable|array',
            'delete_gallery_images.*' => 'exists:galleries,id',
        ];

    }
}