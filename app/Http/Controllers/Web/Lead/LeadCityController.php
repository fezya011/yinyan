<?php

namespace App\Http\Controllers\Web\Lead;

use App\Http\Controllers\Controller;
use App\Services\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadCityController extends Controller
{
    public function __construct(
        private readonly CityService $cityService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = $request->input('query');
        $cities = $this->cityService->search($query);

        return response()->json($cities);
    }
}
