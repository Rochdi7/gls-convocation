<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamConvocationController;
use App\Http\Controllers\Convocations\ConvocationExportController;

Route::get('/', function () {
    return redirect()->route('convocations.index');
});

Route::prefix('convocations')->name('convocations.')->group(function () {
    Route::get('/', [ExamConvocationController::class, 'index'])->name('index');
    Route::post('/import-json', [ExamConvocationController::class, 'importJson'])->name('importJson');

    Route::get('/export/all-pdf', [ConvocationExportController::class, 'exportAllPdf'])->name('export_all_pdf');
    Route::get('/{student}/pdf', [ExamConvocationController::class, 'exportPdf'])->name('pdf');
});
