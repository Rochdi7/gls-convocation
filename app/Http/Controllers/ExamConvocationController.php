<?php

namespace App\Http\Controllers;

use App\Models\ExamStudent;
use App\Services\ConvocationPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamConvocationController extends Controller
{
    public function index()
    {
        $students = ExamStudent::query()
            ->orderBy('full_name')
            ->paginate(30);

        return view('convocations.index', compact('students'));
    }

    public function importJson(Request $request)
    {
        $request->validate([
            'payload' => ['required', 'string'],
        ]);

        $decoded = json_decode($request->payload, true);

        if (!is_array($decoded)) {
            return back()->withErrors(['payload' => 'JSON invalide.']);
        }

        $rows = $decoded['students'] ?? $decoded;

        if (!is_array($rows)) {
            return back()->withErrors(['payload' => 'Structure JSON invalide.']);
        }

        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                if (!is_array($row)) continue;

                $studentCode = trim((string)($row['student_code'] ?? ''));
                $fullName    = trim((string)($row['full_name'] ?? ''));

                if ($studentCode === '' || $fullName === '') {
                    continue;
                }

                ExamStudent::updateOrCreate(
                    ['student_code' => $studentCode],
                    [
                        'full_name'  => $fullName,
                        'class_name' => $row['class_name'] ?? null,
                        'reference'  => $row['reference'] ?? null,
                    ]
                );
            }
        });

        return redirect()->route('convocations.index')->with('success', 'Import JSON terminé.');
    }

    public function exportPdf(ExamStudent $student)
{
    $pdfPath = app(ConvocationPdfService::class)->generate($student);

    return response()
        ->download($pdfPath, 'convocation_' . $student->student_code . '.pdf')
        ->deleteFileAfterSend(true);
}

}
