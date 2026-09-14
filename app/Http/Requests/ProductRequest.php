<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $admin = $this->user('admin');
        if (! $admin) {
            return false;
        }

        $product = $this->route('product');

        return $product instanceof Product
            ? Gate::forUser($admin)->allows('update', $product)
            : Gate::forUser($admin)->allows('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'options' => 'nullable|json',
            'price' => 'required|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
            'featured' => 'required|boolean',
            'status' => 'required|string|in:Active,Archived,Draft',
            'slug' => [
                'prohibited',
                Rule::unique('products', 'slug')->ignore($this->route('product')),
            ],
        ];
    }
}
