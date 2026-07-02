<?php

namespace App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // форма публичная
    }

    public function rules(): array
    {
        return [
            'name'                => ['required', 'string', 'max:100'],
            'phone'               => ['required', 'string', 'max:30'],
            'email'               => ['nullable', 'email', 'max:150'],
            'message'             => ['nullable', 'string', 'max:2000'],
            'estimated_budget'    => ['nullable', 'string', 'max:50'],
            'delivery_city'       => ['nullable', 'string', 'max:100'],
            'interested_products' => ['nullable', 'array'],
            'interested_products.*' => ['integer', 'exists:products,id'],
            'product_id'          => ['nullable', 'integer', 'exists:products,id'],
            'g_recaptcha_response' => ['nullable', 'string'], // если подключишь reCAPTCHA
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Укажите ваше имя',
            'phone.required' => 'Укажите телефон для связи',
            'email.email'    => 'Некорректный формат email',
            'interested_products.*.exists' => 'Выбранный товар не найден',
        ];
    }
}
