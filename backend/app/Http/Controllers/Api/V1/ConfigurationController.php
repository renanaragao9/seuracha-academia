<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\Configuration\ConfigurationResource;
use App\Services\Configuration\ShowConfigurationService;
use Illuminate\Http\JsonResponse;

class ConfigurationController extends BaseController
{
    public function show(
        ShowConfigurationService $showConfigurationService
    ): JsonResponse {
        $configuration = $showConfigurationService->run();

        if (! $configuration) {
            return $this->errorResponse(
                errors: ['configuration' => 'Configuração não encontrada.'],
                message: 'Configuração não encontrada.',
                statusCode: 404
            );
        }

        return $this->successResponse(
            data: new ConfigurationResource($configuration),
            message: 'Configuração encontrada com sucesso.'
        );
    }
}
