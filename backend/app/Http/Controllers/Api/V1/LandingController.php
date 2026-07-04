<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\Landing\LandingResource;
use App\Services\Landing\ShowLandingService;
use Illuminate\Http\JsonResponse;

class LandingController extends BaseController
{
    public function index(ShowLandingService $showLandingService): JsonResponse
    {
        $data = $showLandingService->run();

        return $this->successResponse(
            data: new LandingResource($data),
            message: 'Dados da landing page retornados com sucesso.'
        );
    }
}
