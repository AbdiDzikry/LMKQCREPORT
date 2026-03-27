<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'section_head') {
        $stats = [
            'pending' => \App\Models\ProblemReport::where('status', 'pending')->count(),
            'accepted' => \App\Models\ProblemReport::where('status', 'accepted')->count(),
            'rejected' => \App\Models\ProblemReport::where('status', 'rejected')->count(),
        ];
    } else {
        $stats = [
            'pending' => \App\Models\ProblemReport::where('user_id', $user->id)->where('status', 'pending')->count(),
            'accepted' => \App\Models\ProblemReport::where('user_id', $user->id)->where('status', 'accepted')->count(),
            'rejected' => \App\Models\ProblemReport::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];
    }
    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Problem Reports routes
    Route::get('/reports', [\App\Http\Controllers\ProblemReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [\App\Http\Controllers\ProblemReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [\App\Http\Controllers\ProblemReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/view/{report}', [\App\Http\Controllers\ProblemReportController::class, 'show'])->name('reports.show');
    Route::patch('/reports/verify/{report}', [\App\Http\Controllers\ProblemReportController::class, 'verify'])->name('reports.verify');
    Route::get('/reports/{report}/export/excel', [\App\Http\Controllers\ProblemReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/{report}/export/pdf', [\App\Http\Controllers\ProblemReportController::class, 'exportPdf'])->name('reports.export.pdf');
});

require __DIR__ . '/auth.php';
