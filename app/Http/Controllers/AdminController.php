<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Event;
use App\Models\Participation;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
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

        return view('admin.dashboard', compact(
            'students', 'events', 'participations',
            'recentParticipations', 'topEvents', 'topStudents',
            'eventParticipationData'
        ));
    }
}
