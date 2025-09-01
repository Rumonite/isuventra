<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // return Event::orderBy('date', 'desc')->paginate(15);
        return Event::all();
    }
    public function store(Request $r)
    {
        $data = $r->validate([
            'title' => 'required',
            'description' => 'nullable',
            'date' => 'required|date',
            'location' => 'required',
            'capacity' => 'required|integer|min:0'
        ]);
        return Event::create($data);
    }
    public function show(Event $event)
    {
        return $event->loadCount('participations');
    }
    public function update(Request $r, Event $event)
    {
        $data = $r->validate([
            'title' => 'sometimes',
            'description' => 'nullable',
            'date' => 'sometimes|date',
            'location' => 'sometimes',
            'capacity' => 'sometimes|integer|min:0'
        ]);
        $event->update($data);
        return $event;
    }
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->noContent();
    }
}
