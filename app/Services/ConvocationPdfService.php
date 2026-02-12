<?php

namespace App\Services;

use App\Models\ExamStudent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class ConvocationPdfService
{
    public function generate(ExamStudent $student): string
    {
        $studentArray = [
            'full_name' => $student->full_name,
            'student_code' => $student->student_code,
            'class_name' => $student->class_name,
            'reference' => $student->reference,
        ];

        $data = [
            'student' => $studentArray,
            'level' => 'A2',
            'center_name' => 'Centre Marrakech',
            'letter_date' => now()->format('d F Y'),
            'exam_dates' => '16 - 17 février 2026',
            'exam_time' => '18h00 - 21h30',
            'address_block' => '3ème étage Bureau 28, Immeuble Espace,' . "\n" . 'Av. Yacoub El Mansour, Marrakesh 40000' . "\n" . 'Maroc',
        ];

        $html = View::make('convocations.pdf', $data)->render();

        $directory = storage_path('app/convocations');
        File::ensureDirectoryExists($directory);

        $studentCode = trim((string) $student->student_code);
        $studentCode = preg_replace('/[^\w\-]/u', '_', $studentCode);

        $path = $directory . DIRECTORY_SEPARATOR . ($studentCode ?: 'student') . '.pdf';

        try {
            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(0, 0, 0, 0)
                ->showBackground()
                ->pdf();

            File::put($path, $pdf);

            return $path;
        } catch (\Throwable $e) {
            Log::error("Browsershot PDF generation failed for student: {$student->student_code}", [
                'error' => $e->getMessage(),
                'path' => $path,
            ]);
            throw $e;
        }
    }

    public function generateFromArray(array $studentData, array $staticData): string
    {
        $data = array_merge($staticData, ['student' => $studentData]);
        $html = View::make('convocations.pdf', $data)->render();

        $directory = storage_path('app/convocations');
        File::ensureDirectoryExists($directory);

        $studentCode = trim((string) ($studentData['student_code'] ?? 'student'));
        $studentCode = preg_replace('/[^\w\-]/u', '_', $studentCode);

        $path = $directory . DIRECTORY_SEPARATOR . ($studentCode ?: 'student') . '.pdf';

        try {
            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(0, 0, 0, 0)
                ->showBackground()
                ->pdf();

            File::put($path, $pdf);

            return $path;
        } catch (\Throwable $e) {
            Log::error("Browsershot PDF generation failed for student: {$studentCode}", [
                'error' => $e->getMessage(),
                'path' => $path,
            ]);
            throw $e;
        }
    }
}
