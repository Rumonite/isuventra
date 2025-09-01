<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{StudentController, EventController, ParticipationController, ReportController};

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('students', StudentController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('participations', ParticipationController::class)->only(['index', 'store', 'update', 'destroy']);

// reports
Route::get('reports/participation-per-event', [ReportController::class, 'participationPerEvent']);
Route::get('reports/campus-percentage', [ReportController::class, 'campusPercentage']);
