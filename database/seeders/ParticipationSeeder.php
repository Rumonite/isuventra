<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Participation;
use App\Models\Student;
use App\Models\Event;

class ParticipationSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $events   = Event::all();

        if ($students->isEmpty() || $events->isEmpty()) {
            $this->command->warn('Skipping ParticipationSeeder: no students or events found.');
            return;
        }

        // Generate all possible student-event pairs
        $pairs = [];
        foreach ($students as $student) {
            foreach ($events as $event) {
                $pairs[] = [
                    'student_id' => $student->id,
                    'event_id'   => $event->id,
                ];
            }
        }

        // Shuffle to randomize
        shuffle($pairs);

        // Limit to 100 or however many pairs exist
        $pairs = array_slice($pairs, 0, min(100, count($pairs)));

        foreach ($pairs as $pair) {
            Participation::create([
                'student_id' => $pair['student_id'],
                'event_id'   => $pair['event_id'],
                'status'     => fake()->randomElement(['registered', 'attended', 'missed']),
            ]);
        }
    }
}
