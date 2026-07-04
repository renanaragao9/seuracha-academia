<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\V1\Student\ChangePasswordRequest;
use App\Http\Requests\Api\V1\Student\ShowStudentRequest;
use App\Http\Requests\Api\V1\Student\UpdateStudentProfileImageRequest;
use App\Http\Resources\Api\V1\Student\StudentProfileResource;
use App\Http\Resources\Api\V1\Student\StudentResource;
use App\Services\Student\ChangeStudentPasswordService;
use App\Services\Student\ShowStudentProfileService;
use App\Services\Student\ShowStudentService;
use App\Services\Student\UpdateStudentProfileImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends BaseController
{
    public function show(
        ShowStudentRequest $showStudentRequest,
        ShowStudentService $showStudentService
    ): JsonResponse {
        $student = $showStudentService->run($showStudentRequest->validated());

        return $this->successResponse(
            data: new StudentResource($student),
            message: 'Aluno encontrado com sucesso.'
        );
    }

    public function profile(
        Request $request,
        ShowStudentProfileService $showStudentProfileService
    ): JsonResponse {
        $student = $showStudentProfileService->run($request->user());

        return $this->successResponse(
            data: new StudentProfileResource($student),
            message: 'Perfil carregado com sucesso.'
        );
    }

    public function updateProfileImage(
        UpdateStudentProfileImageRequest $updateStudentProfileImageRequest,
        UpdateStudentProfileImageService $updateStudentProfileImageService
    ): JsonResponse {
        $data = $updateStudentProfileImageRequest->validated();
        $student = $updateStudentProfileImageService->run(
            $updateStudentProfileImageRequest->user(),
            $data
        );

        return $this->successResponse(
            data: new StudentProfileResource($student),
            message: 'Imagem atualizada com sucesso.'
        );
    }

    public function changePassword(
        ChangePasswordRequest $changePasswordRequest,
        ChangeStudentPasswordService $changeStudentPasswordService
    ): JsonResponse {
        $data = $changePasswordRequest->validated();
        $changeStudentPasswordService->run($changePasswordRequest->user(), $data);

        return $this->successResponse(
            data: null,
            message: 'Senha alterada com sucesso.'
        );
    }
}
