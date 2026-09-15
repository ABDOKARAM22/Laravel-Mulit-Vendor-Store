<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $admin = $this->user('admin');
        $order = $this->route('order');

        return $admin !== null
            && $order instanceof Order
            && $admin->can('updateStatus', [$order, $this->input('status')]);
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(Order::STATUSES)],
        ];
    }
}
