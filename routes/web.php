<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\Event;
use App\Models\Participation;
use App\Http\Controllers\{
    StudentController,
    EventController,
    ParticipationController,
    ReportController,
    ProfileController,
    AdminController,
    StudentWebController
};

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/dashboard', function () {
    $students = Student::count();
    $events = Event::count();
    $participations = Participation::count();


    $recentParticipations = Participation::with(['student', 'event'])
        ->orderByDesc('time_in')
        ->limit(10)
        ->get();


    $topEvents = Event::withCount('participations')
        ->orderByDesc('participations_count')
        ->limit(5)
        ->get();


    $topStudents = Student::withCount('participations')
        ->orderByDesc('participations_count')
        ->limit(5)
        ->get();

    $eventParticipationData = Event::withCount('participations')
        ->orderByDesc('participations_count')
        ->limit(10)
        ->get(['title', 'participations_count']);

    return Inertia::render('Dashboard', [
        'students' => $students,
        'events' => $events,
        'participations' => $participations,
        'recentParticipations' => $recentParticipations,
        'topEvents' => $topEvents,
        'topStudents' => $topStudents,
        'eventParticipationData' => $eventParticipationData,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::apiResource('students', StudentController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('participations', ParticipationController::class)->only(['index', 'store', 'update', 'destroy']);

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

Route::resource('admin/students', StudentWebController::class)->only(['store', 'destroy']);

Route::get('/events/{event}/join', function ($eventId) {
    $event = \App\Models\Event::find($eventId);

    if (!$event) {
        abort(404, 'Event not found');
    }

    return view('events.join', compact('event'));
});

Route::post('/events/{event}/participate', function ($eventId, \Illuminate\Http\Request $request) {
    $request->validate([
        'student_id' => 'required|string'
    ]);

    $student = \App\Models\Student::where('student_id', $request->student_id)->first();
    if (!$student) {
        return back()->with('error', 'Student not found. Please check your Student ID.');
    }

    $already = \App\Models\Participation::where('student_id', $student->id)
        ->where('event_id', $eventId)
        ->exists();

    if ($already) {
        return back()->with('error', 'You have already joined this event.');
    }

    \App\Models\Participation::create([
        'student_id' => $student->id,
        'event_id' => $eventId,
        'time_in' => now(),
        'status' => 'registered'
    ]);

    return back()->with('success', 'You have successfully joined the event!');
});
