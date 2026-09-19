<?php

namespace App\Http\Requests;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user('web') !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user('web');
        $profile = $user?->profile()->first();

        return [
            // User information
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user?->id),
            ],

            // Customer profile information
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone_number' => [
                'nullable',
                'string',
                'max:15',
                Rule::unique(Profile::class, 'phone_number')
                    ->ignore($profile?->id),
            ],

            'birthday' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'required',
                'in:male,female',
            ],

            'country' => [
                'required',
                'string',
                'size:2',
            ],

            'city' => [
                'required',
                'string',
                'max:255',
            ],

            'street_address' => [
                'required',
                'string',
                'max:255',
            ],

            'postal_code' => [
                'required',
                'string',
                'max:10',
            ],
        ];
    }
}