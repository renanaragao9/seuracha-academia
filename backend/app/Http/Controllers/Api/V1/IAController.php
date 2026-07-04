<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\IA\ChatRequest;
use App\Services\IA\ChatService;
use Illuminate\Http\JsonResponse;

class IAController extends BaseController
{
    public function chat(
        ChatRequest $chatRequest,
        ChatService $chatService
    ): JsonResponse {
        $data = $chatRequest->validated();
        $result = $chatService->run($data, $chatRequest->user());

        return $this->successResponse(
            data: $result,
            message: 'Chat processado com sucesso.'
        );
    }
}
