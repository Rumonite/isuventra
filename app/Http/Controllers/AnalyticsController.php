<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function predictAllEventTypes()
    {
        // Step 1: Fetch all event participations grouped by title
        $eventData = DB::table('participations')
            ->join('events', 'participations.event_id', '=', 'events.id')
            ->select('events.title', DB::raw('COUNT(participations.id) as total_participations'))
            ->groupBy('events.title')
            ->get();

        // Step 2: Group data by base event type (e.g. "Roadshow", "Seminar", "Workshop")
        $grouped = [];

        foreach ($eventData as $row) {
            // Extract year from title (e.g. "Roadshow 2023")
            if (preg_match('/\b(19|20)\d{2}\b/', $row->title, $matches)) {
                $year = (int)$matches[0];
                // Remove year from the title to get the event type name
                $eventType = trim(preg_replace('/\b(19|20)\d{2}\b/', '', $row->title));
                $eventType = preg_replace('/\s+/', ' ', $eventType); // Clean extra spaces

                if (!isset($grouped[$eventType])) {
                    $grouped[$eventType] = [];
                }

                $grouped[$eventType][] = [
                    'year' => $year,
                    'total_participations' => $row->total_participations,
                ];
            }
        }

        // Step 3: Compute 3-point moving average for each event type
        $results = [];

        foreach ($grouped as $type => $data) {
            $data = collect($data)->sortBy('year')->values();

            // Skip if not enough data
            if ($data->count() < 3) {
                $results[$type] = [
                    'error' => 'Not enough years for a 3-point moving average.',
                    'history' => $data->values(),
                ];
                continue;
            }

            $counts = $data->pluck('total_participations')->toArray();
            $years  = $data->pluck('year')->toArray();

            $movingAverages = [];
            $window = 3;

            for ($i = $window - 1; $i < count($counts); $i++) {
                $subset = array_slice($counts, $i - $window + 1, $window);
                $avg = array_sum($subset) / $window;
                $movingAverages[$years[$i]] = round($avg, 2);
            }

            // Predict next year using the latest moving average
            $nextYear = end($years) + 1;
            $predicted = end($movingAverages);

            $results[$type] = [
                'history' => $data->values(),
                'moving_average' => $movingAverages,
                'prediction' => [
                    'year' => $nextYear,
                    'predicted_count' => $predicted,
                ],
            ];
        }

        return response()->json($results);
    }
}
