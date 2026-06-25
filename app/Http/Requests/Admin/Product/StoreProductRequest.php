<?php
// app/Http/Requests/Admin/Product/StoreProductRequest.php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'card_subtitle' => ['nullable', 'string', 'max:255'],
            'emoji_icon' => ['nullable', 'string', 'max:10'],
            'tag' => ['nullable', 'string', 'max:255'],
            'accent_color' => ['nullable', 'string', 'max:7'],
            'packaging_type' => ['nullable', 'string', 'max:255'],
            'flavors' => ['nullable', 'array'],
            'flavors.*' => ['string'],
            'weight_grams' => ['nullable', 'numeric', 'min:0'],
            'pieces_per_box' => ['nullable', 'integer', 'min:0'],
            'boxes_per_pallet' => ['nullable', 'integer', 'min:0'],
            'shelf_life_days' => ['nullable', 'integer', 'min:0'],
            'retail_price' => ['nullable', 'numeric', 'min:0'],
            'wholesale_price' => ['nullable', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'price_display' => ['nullable', 'string', 'max:255'],
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'has_eac' => ['sometimes', 'boolean'],
            'has_honest_sign' => ['sometimes', 'boolean'],
            'status' => ['required', 'in:active,inactive,out_of_stock'],
            'is_featured' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Выберите категорию',
            'category_id.exists' => 'Выбранная категория не существует',
            'name.required' => 'Название товара обязательно',
            'name.max' => 'Название товара не должно превышать 255 символов',
            'status.required' => 'Выберите статус товара',
            'status.in' => 'Некорректный статус товара',
        ];
    }
}
