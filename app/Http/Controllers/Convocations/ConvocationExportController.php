<?php

namespace App\Http\Controllers\Convocations;

use App\Models\ExamStudent;
use App\Http\Controllers\Controller;
use App\Services\ConvocationPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;

class ConvocationExportController extends Controller
{
    public function exportAllPdf(Request $request)
    {
        $q = ExamStudent::query()->orderBy('full_name');

        if (!empty($request->get('class_name'))) {
            $q->where('class_name', $request->get('class_name'));
        }

        if (!empty($request->get('search'))) {
            $search = trim((string) $request->get('search'));
            $q->where(function ($qq) use ($search) {
                $qq->where('full_name', 'like', "%{$search}%")
                    ->orWhere('student_code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('class_name', 'like', "%{$search}%");
            });
        }

        $students = $q->get();
        $studentCount = $students->count();

        Log::info("[PDF Export] Starting bulk export", ['student_count' => $studentCount]);

        if ($students->isEmpty()) {
            Log::warning("[PDF Export] No students found");
            return back()->withErrors(['message' => 'Aucun étudiant trouvé.']);
        }

        // Static data for all students
        $staticData = [
            'level' => 'A2',
            'center_name' => 'Centre Marrakech',
            'letter_date' => now()->format('d F Y'),
            'exam_dates' => '16 - 17 février 2026',
            'exam_time' => '18h00 - 21h30',
            'address_block' => '3ème étage Bureau 28, Immeuble Espace,' . "\n" . 'Av. Yacoub El Mansour, Marrakesh 40000' . "\n" . 'Maroc',
        ];

        // Generate combined HTML with all students
        $html = '';
        foreach ($students as $student) {
            $studentArray = [
                'full_name' => $student->full_name,
                'student_code' => $student->student_code,
                'class_name' => $student->class_name,
                'reference' => $student->reference,
            ];

            $data = array_merge($staticData, ['student' => $studentArray]);
            $html .= View::make('convocations.pdf', $data)->render();
        }

        Log::info("[PDF Export] HTML generated", ['student_count' => $studentCount]);

        try {
            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(0, 0, 0, 0)
                ->showBackground()
                ->pdf();

            $fileName = 'convocations_A2_' . now()->format('Ymd_His') . '.pdf';
            $pdfSize = strlen($pdf);

            Log::info("[PDF Export] PDF generated successfully", [
                'student_count' => $studentCount,
                'pdf_size_bytes' => $pdfSize,
                'filename' => $fileName
            ]);

            return response()->streamDownload(
                function () use ($pdf) {
                    echo $pdf;
                },
                $fileName,
                ['Content-Type' => 'application/pdf']
            );
        } catch (\Throwable $e) {
            Log::error("[PDF Export] Browsershot failed", [
                'error' => $e->getMessage(),
                'student_count' => $studentCount
            ]);
            return back()->withErrors(['message' => 'Erreur lors de la génération du PDF.']);
        }
    }
}
