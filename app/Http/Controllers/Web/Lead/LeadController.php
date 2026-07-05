<?php

namespace App\Http\Controllers\Web\Lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\StoreLeadRequest;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{
    public function __construct(
        private readonly LeadService $leadService
    ) {}

    public function store(StoreLeadRequest $request): JsonResponse
    {
        $data = $request->validated();
        $lead = $this->leadService->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Заявка успешно отправлена. Мы свяжемся с вами в ближайшее время.',
            'lead_id' => $lead->id,
        ], 201);
    }
}
