<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\TrainingSheet\TrainingSheetResource;
use App\Models\TrainingSheet;
use App\Services\Pdf\GenerateTrainingSheetPdfService;
use App\Services\TrainingSheet\IndexTrainingSheetService;
use App\Services\TrainingSheet\ShowTrainingSheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainingSheetController extends BaseController
{
    public function index(
        Request $request,
        IndexTrainingSheetService $indexTrainingSheetService
    ): JsonResponse {
        $sheets = $indexTrainingSheetService->run($request->user());

        return $this->successResponse(
            data: TrainingSheetResource::collection($sheets),
            message: 'Fichas de treino carregadas com sucesso.'
        );
    }

    public function show(
        TrainingSheet $trainingSheet,
        Request $request,
        ShowTrainingSheetService $showTrainingSheetService
    ): JsonResponse {
        $sheet = $showTrainingSheetService->run($trainingSheet, $request->user());

        return $this->successResponse(
            data: new TrainingSheetResource($sheet),
            message: 'Ficha de treino carregada com sucesso.'
        );
    }

    public function downloadPdf(
        TrainingSheet $trainingSheet,
        Request $request,
        ShowTrainingSheetService $showTrainingSheetService,
        GenerateTrainingSheetPdfService $generateTrainingSheetPdfService
    ): Response {
        $showTrainingSheetService->run($trainingSheet, $request->user());

        $path = $generateTrainingSheetPdfService->run($trainingSheet);

        return response()->download($path, "ficha-{$trainingSheet->id}.pdf")->deleteFileAfterSend();
    }
}
