<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\Item\IndexItemRequest;
use App\Http\Resources\Api\V1\Item\ItemResource;
use App\Models\Item;
use App\Services\Item\IndexItemService;
use App\Services\Item\ShowItemService;
use Illuminate\Http\JsonResponse;

class ItemController extends BaseController
{
    public function index(
        IndexItemRequest $indexItemRequest,
        IndexItemService $indexItemService
    ): JsonResponse {
        $data = $indexItemRequest->all();
        $items = $indexItemService->run($data);

        return $this->successResponse(
            data: ItemResource::collection($items),
            message: 'Itens carregados com sucesso.'
        );
    }

    public function show(Item $item, ShowItemService $showItemService): JsonResponse
    {
        $item = $showItemService->run($item);

        return $this->successResponse(
            data: new ItemResource($item),
            message: 'Item carregado com sucesso.'
        );
    }
}
