<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\MonthlyFee\MonthlyFeeResource;
use App\Models\MonthlyFee;
use App\Services\MonthlyFee\IndexMonthlyFeeService;
use App\Services\MonthlyFee\ShowMonthlyFeeService;
use App\Services\Pdf\GenerateMonthlyFeeReceiptService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyFeeController extends BaseController
{
    public function index(
        Request $request,
        IndexMonthlyFeeService $indexMonthlyFeeService
    ): JsonResponse {
        $monthlyFees = $indexMonthlyFeeService->run($request->user());

        return $this->successResponse(
            data: MonthlyFeeResource::collection($monthlyFees),
            message: 'Mensalidades carregadas com sucesso.'
        );
    }

    public function show(
        MonthlyFee $monthlyFee,
        Request $request,
        ShowMonthlyFeeService $showMonthlyFeeService
    ): JsonResponse {
        $monthlyFee = $showMonthlyFeeService->run($monthlyFee, $request->user());

        return $this->successResponse(
            data: new MonthlyFeeResource($monthlyFee),
            message: 'Mensalidade carregada com sucesso.'
        );
    }

    public function downloadPdf(
        MonthlyFee $monthlyFee, Request $request, GenerateMonthlyFeeReceiptService $generateMonthlyFeeReceiptService
    ): Response {
        $path = $generateMonthlyFeeReceiptService->run($monthlyFee, $request->user());

        return response()->download($path, "mensalidade-{$monthlyFee->uuid}.pdf")->deleteFileAfterSend();
    }
}
