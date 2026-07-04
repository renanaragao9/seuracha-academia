<?php

namespace App\Services\Pdf;

use App\Models\Assessment;
use App\Models\AssessmentItem;
use App\Models\Configuration;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

class GenerateAssessmentPdfService
{
    public function run(int $studentId, User $user, ?string $dateFrom = null, ?string $dateTo = null, ?Assessment $assessment = null): string
    {
        if ($assessment && $assessment->student->user_id !== $user->id) {
            abort(404, 'Avaliação não encontrada.');
        }
        $student = Student::findOrFail($studentId);

        $company = Configuration::first();

        $query = AssessmentItem::whereHas('assessment', fn ($q) => $q->where('student_id', $studentId))
            ->with(['measurementType', 'assessment'])
            ->orderByDesc('created_at');

        if ($assessment) {
            $query->where('assessment_id', $assessment->id);
        }

        $items = $query->get();

        $grouped = $items->groupBy(fn ($item) => $item->measurementType->name);

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

        $html = view('pdf.assessment.assessment', compact('student', 'grouped', 'dateFrom', 'dateTo', 'image', 'company', 'logoBase64', 'assessment'))->render();

        $directory = storage_path('app/public/assessments');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $slug = str($student->name)->slug()->value();
        $path = "{$directory}/avaliacoes-{$slug}.pdf";

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
