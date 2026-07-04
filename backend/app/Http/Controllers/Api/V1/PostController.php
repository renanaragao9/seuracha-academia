<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\Post\IndexPostRequest;
use App\Http\Resources\Api\V1\Post\PostResource;
use App\Models\Post;
use App\Services\Post\IndexPostService;
use App\Services\Post\ShowPostService;
use Illuminate\Http\JsonResponse;

class PostController extends BaseController
{
    public function index(
        IndexPostRequest $indexPostRequest,
        IndexPostService $indexPostService
    ): JsonResponse {
        $data = $indexPostRequest->all();
        $posts = $indexPostService->run($data);

        return $this->successResponse(
            data: PostResource::collection($posts),
            message: 'Postagens carregadas com sucesso.'
        );
    }

    public function show(
        Post $post,
        ShowPostService $showPostService
    ): JsonResponse {
        $post = $showPostService->run($post);

        return $this->successResponse(
            data: new PostResource($post),
            message: 'Postagem carregada com sucesso.'
        );
    }
}
