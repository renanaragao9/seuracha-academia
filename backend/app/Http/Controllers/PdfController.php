<?php

namespace App\Http\Controllers;

use App\Models\MonthlyFee;
use App\Services\Pdf\GenerateMonthlyFeeReceiptService;

class PdfController extends Controller
{
    public function monthlyFee(string $uuid)
    {
        $fee = MonthlyFee::where('uuid', $uuid)->firstOrFail();

        $service = app(GenerateMonthlyFeeReceiptService::class);
        $path = $service->run($fee);

        return response()->download($path, "mensalidade-{$fee->uuid}.pdf")->deleteFileAfterSend();
    }
}
