<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportBuilderController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/verifydestroy', 'App\Http\Controllers\PositionController@verifydestroy')->name('verifydestroy');
    Route::resource('positions', 'App\Http\Controllers\PositionController');
    Route::resource('incumbents', 'App\Http\Controllers\IncumbentController');

    Route::get('/reports', [ReportBuilderController::class, 'index'])->name('reports.index');
    Route::get('/reports/{id}/export', [ReportBuilderController::class, 'exportCsv'])->name('reports.export');
    Route::post('/reports/{id}/copy', [ReportBuilderController::class, 'copy'])->name('reports.copy');
    Route::get('/reports/{id}/edit', [ReportBuilderController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{id}', [ReportBuilderController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{id}', [ReportBuilderController::class, 'destroy'])->name('reports.destroy');
    Route::get('/reports/{id}', [ReportBuilderController::class, 'show'])->name('reports.show');
    Route::get('/dumpGridToCsv', [ReportBuilderController::class, 'dumpGridToCsv'])->name('dumpGridToCsv');

    Route::get('/setup', 'App\Http\Controllers\SetupController@show')->name('setup.show');
    Route::post('/uploadfile', 'App\Http\Controllers\UploadFileController@uploadfile')->name('uploadfile');
    Route::post('/update-collapse-status', 'App\Http\Controllers\PositionController@updateCollapseStatus')->name('updateCollapseStatus');
});
