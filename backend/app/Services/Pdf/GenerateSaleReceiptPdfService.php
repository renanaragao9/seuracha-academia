<?php

namespace App\Services\Pdf;

use App\Models\Configuration;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class GenerateSaleReceiptPdfService
{
    public function run(Sale $sale, User $user): string
    {
        if ($sale->student->user_id !== $user->id) {
            abort(404, 'Compra não encontrada.');
        }

        $sale->loadMissing(['student', 'saleItems.item', 'user']);

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

        $statusLabel = match ($sale->status) {
            'paid' => 'Pago',
            'pending' => 'Pendente',
            'cancelled' => 'Cancelado',
            default => $sale->status ?? '—',
        };

        $html = view('pdf.sale.receipt', compact('sale', 'image', 'company', 'logoBase64', 'statusLabel'))->render();

        $directory = storage_path('app/public/sales');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = "{$directory}/recibo-{$sale->uuid}.pdf";

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
