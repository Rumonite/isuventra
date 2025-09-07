<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{StudentController, EventController, ParticipationController, ReportController};
use App\Models\Participation;
use App\Models\Student;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// API JSON returns
Route::apiResource('students', StudentController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('participations', ParticipationController::class)->only(['index', 'store', 'update', 'destroy']);

// Reports
Route::get('reports/participation-per-event', [ReportController::class, 'participationPerEvent']);
Route::get('reports/campus-percentage', [ReportController::class, 'campusPercentage']);

// Simple frontend test pages
Route::get('/students-frontend', function () {
    return view('students.frontend');
});

Route::get('/events/{event}/join', function ($eventId) {
    return view('events.join', compact('eventId'));
});

// Student joins an event
Route::get('/events/{event}/join', function ($eventId) {
    return view('events.join', compact('eventId'));
});

// Event participation (form submit)
Route::post('/events/{event}/participate', function ($eventId, \Illuminate\Http\Request $request) {
    // validate input
    $request->validate([
        'student_id' => 'required|string'
    ]);

    // find the student by student_id (the string the student enters)
    $student = \App\Models\Student::where('student_id', $request->student_id)->first();
    if (!$student) {
        return back()->with('error', 'Student not found. Please check your Student ID.');
    }

    // check if student already joined this event
    $already = \App\Models\Participation::where('student_id', $student->id)
        ->where('event_id', $eventId)
        ->exists();

    if ($already) {
        return back()->with('error', 'You have already joined this event.');
    }

    // create participation record
    \App\Models\Participation::create([
        'student_id' => $student->id,
        'event_id' => $eventId,
        'time_in' => now(),  // optional: record the timestamp
        'status' => 'registered' // optional
    ]);

    return back()->with('success', 'You have successfully joined the event!');
});

    // Admin Dashboard Route
    use App\Http\Controllers\AdminController;
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
