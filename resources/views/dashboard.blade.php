
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="py-12 bg-gradient-to-br from-blue-50 via-white to-cyan-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-200 dark:border-gray-700 pb-6">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 via-cyan-400 to-green-400 text-white shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5V6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 6v1.5M3 7.5v10.125A2.375 2.375 0 0 0 5.375 20h13.25A2.375 2.375 0 0 0 21 17.625V7.5M3 7.5h18M7.5 10.5h.008v.008H7.5V10.5Zm0 3h.008v.008H7.5V13.5Zm0 3h.008v.008H7.5V16.5Zm3-6h.008v.008H10.5V10.5Zm0 3h.008v.008H10.5V13.5Zm0 3h.008v.008H10.5V16.5Zm3-6h.008v.008H13.5V10.5Zm0 3h.008v.008H13.5V13.5Zm0 3h.008v.008H13.5V16.5Zm3-6h.008v.008H16.5V10.5Zm0 3h.008v.008H16.5V13.5Zm0 3h.008v.008H16.5V16.5Z" />
                                </svg>
                            </span>
                            <h1 class="text-3xl font-extrabold tracking-tight">ISUVENTRA</h1>
                        </div>
                    </div>

                    <!-- Metrics Cards -->

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                        <!-- Students -->
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 transition text-white p-7 rounded-2xl shadow-xl flex flex-col items-center border-2 border-blue-400/30">
                            <span class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118A7.5 7.5 0 0 1 12 17.25a7.5 7.5 0 0 1 7.5 2.868M12 17.25v.008h-.008V17.25H12Z" /></svg></span>
                            <h5 class="text-lg font-semibold mb-1">Total Students</h5>
                            <p class="text-4xl font-extrabold tracking-tight">{{ $students ?? 'N/A' }}</p>
                        </div>
                        <!-- Events -->
                        <div class="bg-gradient-to-br from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 transition text-white p-7 rounded-2xl shadow-xl flex flex-col items-center border-2 border-green-400/30">
                            <span class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" /></svg></span>
                            <h5 class="text-lg font-semibold mb-1">Total Events</h5>
                            <p class="text-4xl font-extrabold tracking-tight">{{ $events ?? 'N/A' }}</p>
                        </div>
                        <!-- Participations -->
                        <div class="bg-gradient-to-br from-cyan-500 to-cyan-700 hover:from-cyan-600 hover:to-cyan-800 transition text-white p-7 rounded-2xl shadow-xl flex flex-col items-center border-2 border-cyan-400/30">
                            <span class="mb-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9A.75.75 0 0 1 6.75 12ZM12 6.75a.75.75 0 0 1 .75.75v9a.75.75 0 0 1-1.5 0v-9a.75.75 0 0 1 .75-.75Z" /></svg></span>
                            <h5 class="text-lg font-semibold mb-1">Total Participations</h5>
                            <p class="text-4xl font-extrabold tracking-tight">{{ $participations ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <!-- Recent Participations -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl shadow p-6 border border-gray-200 dark:border-gray-600">
                            <h5 class="font-semibold text-gray-800 dark:text-gray-100 mb-4 text-lg">Recent Participations</h5>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm border-separate border-spacing-y-2">
                                    <thead>
                                        <tr class="text-left border-b border-gray-300 dark:border-gray-600">
                                            <th class="px-2 py-1">Student</th>
                                            <th class="px-2 py-1">Event</th>
                                            <th class="px-2 py-1">Time In</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentParticipations as $p)
                                            <tr class="hover:bg-blue-100/60 dark:hover:bg-gray-800 transition">
                                                <td class="px-2 py-1">{{ $p->student->name ?? 'N/A' }}</td>
                                                <td class="px-2 py-1">
                                                    @if($p->event)
                                                        <a href="{{ url('/events/' . $p->event->id . '/join') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">
                                                            {{ $p->event->title }}
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="px-2 py-1">{{ $p->time_in }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-gray-400">No recent participations.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Top Events -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl shadow p-6 border border-gray-200 dark:border-gray-600">
                            <h5 class="font-semibold text-gray-800 dark:text-gray-100 mb-4 text-lg">Top Events</h5>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm border-separate border-spacing-y-2">
                                    <thead>
                                        <tr class="text-left border-b border-gray-300 dark:border-gray-600">
                                            <th class="px-2 py-1">Event</th>
                                            <th class="px-2 py-1">Participations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($topEvents as $event)
                                            <tr class="hover:bg-green-100/60 dark:hover:bg-gray-800 transition">
                                                <td class="px-2 py-1">
                                                    <a href="{{ url('/events/' . $event->id . '/join') }}" class="text-green-600 dark:text-green-400 hover:underline font-semibold">
                                                        {{ $event->title }}
                                                    </a>
                                                </td>
                                                <td class="px-2 py-1">{{ $event->participations_count }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-gray-400">No data.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-2xl shadow p-6 border border-gray-200 dark:border-gray-600 mb-10">
                        <h5 class="font-semibold text-gray-800 dark:text-gray-100 mb-4 text-lg">Top Students</h5>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm border-separate border-spacing-y-2">
                                <thead>
                                    <tr class="text-left border-b border-gray-300 dark:border-gray-600">
                                        <th class="px-2 py-1">Student</th>
                                        <th class="px-2 py-1">Participations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topStudents as $student)
                                        <tr class="hover:bg-cyan-100/60 dark:hover:bg-gray-800 transition">
                                            <td class="px-2 py-1">{{ $student->name }}</td>
                                            <td class="px-2 py-1">{{ $student->participations_count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-gray-400">No data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="bg-gradient-to-r from-blue-100 via-cyan-100 to-green-100 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl shadow p-8 border border-gray-200 dark:border-gray-600 flex flex-col items-center">
                        <h5 class="font-semibold text-gray-800 dark:text-gray-100 mb-6 text-lg">Event Participation Chart</h5>
                        <canvas id="eventParticipationChart" height="100" class="max-w-2xl w-full"></canvas>
                    </div>
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

</x-app-layout>
