<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class VendorStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    Admin::STATUS_ACTIVE,
                    Admin::STATUS_REJECTED,
                ]),
            ],
        ];
    }
}
