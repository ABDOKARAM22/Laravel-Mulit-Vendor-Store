<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $countryCodes = array_keys(Countries::getNames());

        return [
            'payment' => ['required', Rule::in(['cod'])],
            'addr' => ['required', 'array'],
            'addr.billing' => ['required', 'array'],
            'addr.shipping' => ['required', 'array'],
            'addr.*.first_name' => ['required', 'string', 'max:100'],
            'addr.*.last_name' => ['required', 'string', 'max:100'],
            'addr.*.email' => ['nullable', 'email', 'max:255'],
            'addr.*.phone_number' => ['required', 'string', 'max:50'],
            'addr.*.country' => ['required', Rule::in($countryCodes)],
            'addr.*.city' => ['required', 'string', 'max:100'],
            'addr.*.state' => ['nullable', 'string', 'max:100'],
            'addr.*.street_address' => ['required', 'string', 'max:255'],
            'addr.*.postal_code' => ['nullable', 'string', 'max:30'],
        ];
    }
}
