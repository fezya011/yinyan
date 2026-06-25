<?php
// app/Http/Requests/Admin/Lead/UpdateLeadStatusRequest.php

namespace App\Http\Requests\Admin\Lead;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(Lead::getStatuses()))],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Выберите статус',
            'status.in' => 'Некорректный статус заявки',
        ];
    }
}
