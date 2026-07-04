<?php

namespace App\Services\Pdf;

use App\Models\Configuration;
use App\Models\TrainingSheet;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class GenerateTrainingSheetPdfService
{
    public function run(TrainingSheet $trainingSheet): string
    {

        $trainingSheet->loadMissing(['student', 'divisions.trainingDivision', 'divisions.exercises.exercise', 'creator']);

        $company = Configuration::first();

        $image = base64_encode(
            file_get_contents(
                public_path('image/pdf/physical-therapy-exercise-rafiki.png')
            )
        );

        $logoBase64 = null;
        if ($company?->logo) {
            $logoPath = Storage::disk('public')->path($company->logo);
            if (file_exists($logoPath)) {
                $logoBase64 = base64_encode(file_get_contents($logoPath));
            }
        }

        $html = view('pdf.training-sheet.training-sheet', compact('trainingSheet', 'image', 'company', 'logoBase64'))->render();

        $directory = storage_path('app/public/training-sheets');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = "{$directory}/ficha-{$trainingSheet->id}.pdf";

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
