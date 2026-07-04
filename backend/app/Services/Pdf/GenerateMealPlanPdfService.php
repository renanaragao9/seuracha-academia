<?php

namespace App\Services\Pdf;

use App\Models\Configuration;
use App\Models\MealPlan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class GenerateMealPlanPdfService
{
    public function run(MealPlan $mealPlan, User $user): string
    {
        if ($mealPlan->student->user_id !== $user->id) {
            abort(404, 'Plano alimentar não encontrado.');
        }

        $mealPlan->loadMissing(['student', 'meals.mealType', 'meals.foods.food', 'creator']);

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

        $html = view('pdf.meal-plan.meal-plan', compact('mealPlan', 'image', 'company', 'logoBase64'))->render();

        $directory = storage_path('app/public/meal-plans');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = "{$directory}/plano-alimentar-{$mealPlan->id}.pdf";

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
