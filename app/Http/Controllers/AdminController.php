<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Event;
use App\Models\Participation;

class AdminController extends Controller
{
    public function dashboard()
    {
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

        $studentsList = Student::all();

        return view('resources\js\Pages\Dashboard.vue', compact(
            'students',
            'events',
            'participations',
            'recentParticipations',
            'topEvents',
            'topStudents',
            'eventParticipationData',
            'studentsList'
        ));
    }
}
