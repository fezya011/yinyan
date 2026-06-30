<?php
// app/Http/Requests/Admin/Product/UpdateProductRequest.php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product');

        return [
            // Основное
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($id)],
            'description' => ['nullable', 'string'],
            'card_subtitle' => ['nullable', 'string', 'max:255'],
            'emoji_icon' => ['nullable', 'string', 'max:10'],
            'tag' => ['nullable', 'string', 'max:255'],
            'accent_color' => ['nullable', 'string', 'max:7'],
            'packaging_type' => ['nullable', 'string', 'max:255'],
            'flavors' => ['nullable', 'array'],
            'flavors.*' => ['string'],

            // ===== НОВЫЕ ПОЛЯ =====
            'barcode' => ['nullable', 'string', 'max:50', Rule::unique('products', 'barcode')->ignore($id)],
            'weight_grams' => ['nullable', 'numeric', 'min:0'],
            'pieces_per_box' => ['nullable', 'integer', 'min:0'],
            'boxes_per_pallet' => ['nullable', 'integer', 'min:0'],
            'shelf_life_days' => ['nullable', 'integer', 'min:0'],
            'box_volume' => ['nullable', 'numeric', 'min:0'],
            'box_weight_kg' => ['nullable', 'numeric', 'min:0'],
            'vat_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'tnved_code' => ['nullable', 'string', 'max:20'],

            // Цены
            'wholesale_price' => ['nullable', 'numeric', 'min:0'],
            'retail_price' => ['nullable', 'numeric', 'min:0'],
            'distributor_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'price_display' => ['nullable', 'string', 'max:255'],

            // Изображения
            'main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            // Сертификация
            'has_eac' => ['sometimes', 'boolean'],
            'has_honest_sign' => ['sometimes', 'boolean'],

            // Статусы
            'status' => ['required', 'in:active,inactive,out_of_stock'],
            'is_featured' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],

            // SEO
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],

            // Дополнительно
            'comment' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Выберите категорию',
            'category_id.exists' => 'Выбранная категория не существует',
            'name.required' => 'Название товара обязательно',
            'status.required' => 'Выберите статус товара',
            'barcode.unique' => 'Товар с таким штрих-кодом уже существует',
            'vat_rate.max' => 'Ставка НДС не может быть больше 100%',
        ];
    }
}
