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

        $pairs = [];
        foreach ($students as $student) {
            foreach ($events as $event) {
                $pairs[] = [
                    'student_id' => $student->id,
                    'event_id'   => $event->id,
                    'time_in'    => $event->date ?? now(), // use event date
                ];
            }
        }

        shuffle($pairs);
        $pairs = array_slice($pairs, 0, min(300, count($pairs)));

        foreach ($pairs as $pair) {
            Participation::factory()->create([
                'student_id' => $pair['student_id'],
                'event_id'   => $pair['event_id'],
                'time_in'    => $pair['time_in'],
                'status'     => fake()->randomElement(['registered', 'attended', 'missed']),
            ]);
        }
    }
}
