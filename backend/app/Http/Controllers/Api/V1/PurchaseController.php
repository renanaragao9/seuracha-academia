<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Api\V1\Purchase\PurchaseResource;
use App\Models\Sale;
use App\Services\Pdf\GenerateSaleReceiptPdfService;
use App\Services\Purchase\IndexPurchaseService;
use App\Services\Purchase\ShowPurchaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseController extends BaseController
{
    public function index(
        Request $request,
        IndexPurchaseService $indexPurchaseService
    ): JsonResponse {
        $purchases = $indexPurchaseService->run($request->user());

        return $this->successResponse(
            data: PurchaseResource::collection($purchases),
            message: 'Compras carregadas com sucesso.'
        );
    }

    public function show(
        Sale $purchase,
        Request $request,
        ShowPurchaseService $showPurchaseService
    ): JsonResponse {
        $purchase = $showPurchaseService->run($purchase, $request->user());

        return $this->successResponse(
            data: new PurchaseResource($purchase),
            message: 'Compra carregada com sucesso.'
        );
    }

    public function downloadPdf(
        Sale $purchase,
        Request $request,
        GenerateSaleReceiptPdfService $generateSaleReceiptPdfService
    ): Response {
        $path = $generateSaleReceiptPdfService->run($purchase, $request->user());

        return response()->download($path, "recibo-{$purchase->uuid}.pdf")->deleteFileAfterSend();
    }
}
