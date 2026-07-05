<?php

namespace App\Services;

use App\Models\Lead;

class LeadService
{
    public function create(array $data): Lead
    {
        // Обработка interested_products
        if (isset($data['interested_products']) && is_array($data['interested_products'])) {
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
