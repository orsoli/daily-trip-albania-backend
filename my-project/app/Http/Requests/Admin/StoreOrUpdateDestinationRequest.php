<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateDestinationRequest extends FormRequest
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
            'region_id'            => 'required|exists:regions,id',
            'title'                => 'required|string|max:255',
            'thumbnail'            => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price'                => 'required|numeric|min:0|decimal:0,2|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'country'              => 'required|string|max:255',
            'city'                 => 'required|string|max:255',
            'description'          => 'nullable|string',
            'nearest_airport'      => 'nullable|string|max:255',
            'latitude'             => 'nullable|numeric',
            'longitude'            => 'nullable|numeric',
            'is_visible'           => 'boolean',

            //    ---- Pivot tables ----

            // Accommodations
            'accommodations'          => 'nullable|array',
            'accommodations.*'        => 'exists:accommodations,id',

            // Gallery images
            'gallery_images'        => 'nullable|array',
            'gallery_images.*'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Delete gallery images
            'delete_gallery_images' => 'nullable|array',
            'delete_gallery_images.*' => 'exists:galleries,id',
        ];
    }
}
