<?php

// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Models\Event;
use App\Models\Participation;
use App\Http\Controllers\{StudentController, EventController, ParticipationController, ReportController, ProfileController, AdminController};

//Main Page (Not much design yet)
Route::get('/', function () {
    return view('welcome');
});

// dashboard stats (Required by /admin/dashboard for statistics [too lazy to recode everything in AdminController])
Route::get('/dashboard', function () {
    $students = Student::count();
    $events = Event::count();
    $participations = Participation::count();

    // Recent participations (last 10)
    $recentParticipations = Participation::with(['student', 'event'])
        ->orderByDesc('time_in')
        ->limit(10)
        ->get();

    // Top 5 events by participation count
    $topEvents = Event::withCount('participations')
        ->orderByDesc('participations_count')
        ->limit(5)
        ->get();

    // Top 5 students by participation count
    $topStudents = Student::withCount('participations')
        ->orderByDesc('participations_count')
        ->limit(5)
        ->get();

    // For chart: event titles and participation counts
    $eventParticipationData = Event::withCount('participations')
        ->orderByDesc('participations_count')
        ->limit(10)
        ->get(['title', 'participations_count']);

    return view('dashboard', compact(
        'students',
        'events',
        'participations',
        'recentParticipations',
        'topEvents',
        'topStudents',
        'eventParticipationData'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

//Middleware by Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// API JSON returns
Route::apiResource('students', StudentController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('participations', ParticipationController::class)->only(['index', 'store', 'update', 'destroy']);

// Reports (NOW REDUNDANT, handled in AdminController - sabi ni autocorrect)
// Route::get('reports/participation-per-event', [ReportController::class, 'participationPerEvent']);
// Route::get('reports/campus-percentage', [ReportController::class, 'campusPercentage']);

// /dashboard/ to /admin/dashboard redirect (middleware prot. ofc)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('/dashboard', '/admin/dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// (Only access event id) - NOW REDUNDANT
// Route::get('/events/{event}/join', function ($eventId) {
//     return view('events.join', compact('eventId'));
// });

// Student joins an event
Route::get('/events/{event}/join', function ($eventId) {
    $event = \App\Models\Event::find($eventId);

    if (!$event) {
        abort(404, 'Event not found');
    }

    return view('events.join', compact('event'));
});

// Event participation (form submission)
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
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

// Student CRUD
use App\Http\Controllers\StudentWebController;

Route::resource('admin/students', StudentWebController::class)->only(['store', 'destroy']);
// Route::post('/students', [StudentWebController::class, 'store'])->name('students.store');
// Route::delete('/students/{student}', [StudentWebController::class, 'destroy'])->name('students.destroy');
// Route::get('/dashboard/students', [StudentWebController::class, 'index'])->name('students.index');
