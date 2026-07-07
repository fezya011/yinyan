<?php

namespace App\Services;

use App\Models\Lead;

class LeadService
{
    public function create(array $data): Lead
    {
        // Обработка interested_products
        // Используем !empty(), чтобы пустой массив [] тоже превращался в null
        if (!empty($data['interested_products'])) {
            $data['interested_products'] = array_map('intval', $data['interested_products']);
        } else {
            $data['interested_products'] = null;
        }

        $lead = Lead::create([
            ...$data,
            'status' => Lead::STATUS_NEW,
        ]);

        return $lead;
    }
}
