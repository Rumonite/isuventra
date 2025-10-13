<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function predictAllEventTypes()
    {
        // Fetch all event participations grouped by title
        $eventData = DB::table('participations')
            ->join('events', 'participations.event_id', '=', 'events.id')
            ->select('events.title', DB::raw('COUNT(participations.id) as total_participations'))
            ->groupBy('events.title')
            ->get();

        // Group data by base event type (e.g. "Roadshow", "Seminar", "Workshop")
        $grouped = [];

        foreach ($eventData as $row) {
            if (preg_match('/\b(19|20)\d{2}\b/', $row->title, $matches)) {
                $year = (int)$matches[0];
                $eventType = trim(preg_replace('/\b(19|20)\d{2}\b/', '', $row->title));
                $eventType = preg_replace('/\s+/', ' ', $eventType);

                $grouped[$eventType][] = [
                    'year' => $year,
                    'total_participations' => $row->total_participations,
                ];
            }
        }

        // Compute 3-point moving average with forward prediction
        $results = [];

        foreach ($grouped as $type => $data) {
            $data = collect($data)->sortBy('year')->values();

            if ($data->count() < 3) {
                $results[$type] = [
                    'error' => 'Not enough years for a 3-point moving average.',
                    'history' => $data->values(),
                ];
                continue;
            }

            $counts = $data->pluck('total_participations')->toArray();
            $years  = $data->pluck('year')->toArray();

            $window = 3;
            $movingAverages = [];

            // Compute moving averages for existing data
            for ($i = $window - 1; $i < count($counts); $i++) {
                $subset = array_slice($counts, $i - $window + 1, $window);
                $avg = array_sum($subset) / $window;
                $movingAverages[$years[$i]] = round($avg, 2);
            }

            // Predict 4 future years iteratively using previous predictions
            $futurePredictions = [];
            $currentCounts = $counts;

            $lastYear = end($years);

            for ($i = 1; $i <= 4; $i++) {
                // Take last 3 values (can include previously predicted ones)
                $recent = array_slice($currentCounts, -3);
                $predicted = round(array_sum($recent) / 3, 2);
                $futureYear = $lastYear + $i;

                $futurePredictions[] = [
                    'year' => $futureYear,
                    'predicted_count' => $predicted,
                ];

                // Append prediction to the rolling window
                $currentCounts[] = $predicted;
            }

            $results[$type] = [
                'history' => $data->values(),
                'moving_average' => $movingAverages,
                'predictions' => $futurePredictions,
            ];
        }

        return response()->json($results);
    }
}
