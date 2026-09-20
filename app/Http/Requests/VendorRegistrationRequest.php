<?php

namespace App\Http\Requests;

use App\Models\Admin;
use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class VendorRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ! $this->user('admin');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:' . Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'store_name' => ['required', 'string', 'max:255', 'unique:' . Store::class . ',name'],
            'store_description' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
