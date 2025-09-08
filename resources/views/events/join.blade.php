<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Join Event') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-blue-50 via-white to-cyan-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    
                    <!-- Title Section -->
                    <div class="mb-6 flex items-center gap-3 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 via-cyan-400 to-green-400 text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </span>
                        <h1 class="text-3xl font-extrabold tracking-tight">
                            Join Event: <span class="text-indigo-600 dark:text-indigo-400">{{ $event->title }}</span>
                        </h1>
                    </div>

                    <!-- Messages -->
                    @if(session('success'))
                        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Join Form -->
                    <form action="/events/{{ $event->id }}/participate" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Enter your Student ID
                            </label>
                            <input 
                                type="text" 
                                id="student_id" 
                                name="student_id" 
                                required
                                placeholder="e.g. 2025-1234"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-100"
                            >
                        </div>

                        <div class="flex items-center gap-4">
                            <button 
                                type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition"
                            >
                                Join Event
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
