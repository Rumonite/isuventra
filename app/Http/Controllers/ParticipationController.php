<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participation;

class ParticipationController extends Controller
{
    // "time-in" via QR: client sends {student_id, event_id}
    public function store(Request $r)
    {
        $data = $r->validate([
            'event_id' => 'required|exists:events,id',
            'student_id' => 'required|exists:students,id', // or send student_id string then resolve
            'time_in' => 'nullable|date',
            'status' => 'nullable|string'
        ]);

        // DSA: uniqueness check relies on DB unique index (hash-like O(1) lookup)
        $existing = Participation::where('event_id', $data['event_id'])
            ->where('student_id', $data['student_id'])->first();
        if ($existing) {
            return response()->json(['message' => 'Already signed in'], 409);
        }

        $data['time_in'] = $data['time_in'] ?? now();
        return Participation::create($data);
    }

    // "time-out"
    public function update(Request $r, Participation $participation)
    {
        $data = $r->validate([
            'time_out' => 'nullable|date',
            'status' => 'nullable|string'
        ]);
        if (empty($data['time_out'])) {
            $data['time_out'] = now();
        }
        $participation->update($data);
        return $participation->fresh();
    }

    public function index()
    {
        // return Participation::with(['student', 'event'])->latest()->paginate(20); (for page form)
        return Participation::all();
    }

    public function destroy(Participation $participation)
    {
        $participation->delete();
        return response()->noContent();
    }
}
