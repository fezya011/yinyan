<?php

namespace App\Http\Controllers\Web\Lead;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\StoreLeadRequest;
use App\Services\LeadService;
use App\Services\LeadNotificationService;
use Illuminate\Http\JsonResponse;
use App\Traits\HasRateLimit;

class LeadController extends Controller
{
    use HasRateLimit;
    public function __construct(
        private readonly LeadService $leadService,
        private readonly LeadNotificationService $notificationService
    ) {}

    public function store(StoreLeadRequest $request): JsonResponse
    {
        $limitResponse = $this->checkIpLimit($request);
        if ($limitResponse) return $limitResponse;

        $limitResponse = $this->checkEmailLimit($request);
        if ($limitResponse) return $limitResponse;

        $limitResponse = $this->checkPhoneLimit($request);
        if ($limitResponse) return $limitResponse;

        $data = $request->validated();
        $lead = $this->leadService->create($data);

        // Отправка уведомлений
        $this->notificationService->notify($lead);

        return response()->json([
            'success' => true,
            'message' => 'Заявка успешно отправлена. Мы свяжемся с вами в ближайшее время.',
            'lead_id' => $lead->id,
        ], 201);
    }
}
