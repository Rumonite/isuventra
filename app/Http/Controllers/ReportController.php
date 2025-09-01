<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participation;

class ReportController extends Controller
{
    // Report A: participation count per event (sorted desc)
    public function participationPerEvent()
    {
        $events = Event::withCount('participations')->get();
        // DSA: sorting (O(n log n))
        return $events->sortByDesc('participations_count')->values();
    }

    // Report B: percentage of participants by campus
    public function campusPercentage()
    {
        $total = Participation::count();
        if ($total === 0) return [];

        $byCampus = Participation::with('student')->get()
            ->groupBy(fn($p) => $p->student->campus);
        // DSA: hash-based grouping, O(n)
        return $byCampus->map(fn($g) => round(($g->count() / $total) * 100, 2));
    }
}
