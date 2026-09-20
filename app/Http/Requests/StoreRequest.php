<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $store = $this->route('store');

        $storeId = $store instanceof Store
            ? $store->id
            : null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('stores', 'name')->ignore($storeId),
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('stores', 'slug')->ignore($storeId),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'logo_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,gif,webp',
                'max:2048',
            ],

            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,gif,webp',
                'max:4096',
            ],
        ];
    }
}