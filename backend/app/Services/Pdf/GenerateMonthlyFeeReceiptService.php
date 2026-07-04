<?php

namespace App\Services\Pdf;

use App\Models\Configuration;
use App\Models\MonthlyFee;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class GenerateMonthlyFeeReceiptService
{
    public function run(MonthlyFee $fee, User $user): string
    {
        if ($fee->student->user_id !== $user->id) {
            abort(404, 'Mensalidade não encontrada.');
        }

        $fee->loadMissing(['student', 'planType', 'paymentType', 'user']);

        $company = Configuration::first();

        $image = base64_encode(
            file_get_contents(
                public_path('image/pdf/payment-Information-cuate.png')
            )
        );

        $logoBase64 = null;
        if ($company?->logo) {
            $logoPath = Storage::disk('public')->path($company->logo);
            if (file_exists($logoPath)) {
                $logoBase64 = base64_encode(file_get_contents($logoPath));
            }
        }

        $html = view('pdf.monthly-fee.receipt', compact('fee', 'image', 'company', 'logoBase64'))->render();

        $path = storage_path("app/public/monthly-fees/receipt-{$fee->uuid}.pdf");

        Browsershot::html($html)
            ->setNodeBinary(env('BROWSERSHOT_NODE_BINARY', '/usr/bin/node'))
            ->setChromePath(env('BROWSERSHOT_CHROME_PATH', '/home/renan/.cache/puppeteer/chrome/linux-147.0.7727.57/chrome-linux64/chrome'))
            ->setNodeModulePath(base_path('node_modules'))
            ->margins(0, 0, 0, 0)
            ->format('A4')
            ->noSandbox()
            ->showBrowserHeaderAndFooter(false)
            ->save($path);

        return $path;
    }
}
