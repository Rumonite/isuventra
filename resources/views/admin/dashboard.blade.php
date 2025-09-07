@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <p class="card-text">{{ $students ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text">{{ $events ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Participations</h5>
                    <p class="card-text">{{ $participations ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">Recent Participations</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Event</th>
                            <th>Time In</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentParticipations as $p)
                            <tr>
                                <td>{{ $p->student->name ?? 'N/A' }}</td>
                                <td>{{ $p->event->title ?? 'N/A' }}</td>
                                <td>{{ $p->time_in }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">No recent participations.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">Top Events</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Participations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topEvents as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->participations_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2">No data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">Top Students</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Participations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topStudents as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->participations_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2">No data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white">Event Participation Chart</div>
            <div class="card-body">
                <canvas id="eventParticipationChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('eventParticipationChart').getContext('2d');
    const eventLabels = @json($eventParticipationData->pluck('title'));
    const eventCounts = @json($eventParticipationData->pluck('participations_count'));
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: eventLabels,
            datasets: [{
                label: 'Participations',
                data: eventCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Top 10 Events by Participation' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
</div>
@endsection
