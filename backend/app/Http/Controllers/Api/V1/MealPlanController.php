<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\MealPlan\MealPlanResource;
use App\Models\MealPlan;
use App\Services\MealPlan\IndexMealPlanService;
use App\Services\MealPlan\ShowMealPlanService;
use App\Services\Pdf\GenerateMealPlanPdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MealPlanController extends BaseController
{
    public function index(
        Request $request,
        IndexMealPlanService $indexMealPlanService
    ): JsonResponse {
        $mealPlans = $indexMealPlanService->run($request->user());

        return $this->successResponse(
            data: MealPlanResource::collection($mealPlans),
            message: 'Planos alimentares carregados com sucesso.'
        );
    }

    public function show(
        MealPlan $mealPlan,
        Request $request,
        ShowMealPlanService $showMealPlanService
    ): JsonResponse {
        $mealPlan = $showMealPlanService->run($mealPlan, $request->user());

        return $this->successResponse(
            data: new MealPlanResource($mealPlan),
            message: 'Plano alimentar carregado com sucesso.'
        );
    }

    public function downloadPdf(
        MealPlan $mealPlan,
        Request $request,
        GenerateMealPlanPdfService $generateMealPlanPdfService
    ): Response {
        $path = $generateMealPlanPdfService->run($mealPlan, $request->user());

        return response()->download($path, "plano-alimentar-{$mealPlan->id}.pdf")->deleteFileAfterSend();
    }
}
