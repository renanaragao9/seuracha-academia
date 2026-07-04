<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\Assessment\AssessmentResource;
use App\Models\Assessment;
use App\Services\Assessment\IndexAssessmentService;
use App\Services\Assessment\ShowAssessmentService;
use App\Services\Pdf\GenerateAssessmentPdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssessmentController extends BaseController
{
    public function index(
        Request $request,
        IndexAssessmentService $indexAssessmentService
    ): JsonResponse {
        $assessments = $indexAssessmentService->run($request->user());

        return $this->successResponse(
            data: AssessmentResource::collection($assessments),
            message: 'Avaliações carregadas com sucesso.'
        );
    }

    public function show(
        Assessment $assessment,
        Request $request,
        ShowAssessmentService $showAssessmentService
    ): JsonResponse {
        $assessment = $showAssessmentService->run($assessment, $request->user());

        return $this->successResponse(
            data: new AssessmentResource($assessment),
            message: 'Avaliação carregada com sucesso.'
        );
    }

    public function downloadPdf(Assessment $assessment, Request $request): Response
    {
        $service = app(GenerateAssessmentPdfService::class);
        $path = $service->run($assessment->student_id, $request->user(), assessment: $assessment);

        return response()->download($path, "avaliacao-{$assessment->id}.pdf")->deleteFileAfterSend();
    }
}
