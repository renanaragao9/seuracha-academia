<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\ItemType\ItemTypeResource;
use App\Services\ItemType\IndexItemTypeService;
use Illuminate\Http\JsonResponse;

class ItemTypeController extends BaseController
{
    public function index(IndexItemTypeService $indexItemTypeService): JsonResponse
    {
        $types = $indexItemTypeService->run();

        return $this->successResponse(
            data: ItemTypeResource::collection($types),
            message: 'Tipos de item carregados com sucesso.'
        );
    }
}
