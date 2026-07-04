<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\WorkoutLog\StoreWorkoutLogRequest;
use App\Http\Resources\Api\V1\TrainingSheet\WorkoutLogResource;
use App\Services\WorkoutLog\StoreWorkoutLogService;
use Illuminate\Http\JsonResponse;

class WorkoutLogController extends BaseController
{
    public function store(
        StoreWorkoutLogRequest $storeWorkoutLogRequest,
        StoreWorkoutLogService $storeWorkoutLogService
    ): JsonResponse {
        $data = $storeWorkoutLogRequest->validated();
        $workoutLog = $storeWorkoutLogService->run($storeWorkoutLogRequest->user(), $data);

        if ($workoutLog === null) {
            return $this->errorResponse(
                errors: ['workout_log' => 'Nao foi possivel registrar o log de treino.'],
                message: 'Nao foi possivel registrar o log de treino.',
                statusCode: 422
            );
        }

        return $this->successResponse(
            data: new WorkoutLogResource($workoutLog),
            message: 'Log de treino registrado com sucesso.'
        );
    }
}
