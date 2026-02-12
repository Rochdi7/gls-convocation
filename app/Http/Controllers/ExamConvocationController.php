<?php

namespace App\Http\Controllers;

use App\Models\ExamStudent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $pdf = Pdf::loadView('convocations.pdf', compact('student'))->setPaper('a4');

        return $pdf->download('convocation_'.$student->student_code.'.pdf');
    }

    public function exportZip()
    {
        $students = ExamStudent::query()->orderBy('full_name')->get();

        $tmpDir = 'tmp/convocations_'.now()->format('Ymd_His');
        Storage::disk('local')->makeDirectory($tmpDir);

        foreach ($students as $student) {
            $pdf = Pdf::loadView('convocations.pdf', compact('student'))->setPaper('a4');

            Storage::disk('local')->put(
                $tmpDir.'/convocation_'.$student->student_code.'.pdf',
                $pdf->output()
            );
        }

        $zipName = 'convocations_A2_'.now()->format('Ymd_His').'.zip';
        $zipPath = storage_path('app/'.$zipName);

        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach (Storage::disk('local')->files($tmpDir) as $file) {
            $zip->addFile(storage_path('app/'.$file), basename($file));
        }

        $zip->close();

        Storage::disk('local')->deleteDirectory($tmpDir);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
