<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Students') }}
        </h2>
    </x-slot>

<div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl shadow mt-6 border border-gray-200 dark:border-gray-600" style="margin-left: 10%; margin-right: 10%">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Manage Students</h2>

    {{-- Success message --}}
    @if(session('success'))
        <p class="text-green-600 dark:text-green-400">{{ session('success') }}</p>
    @endif

    {{-- Add Student Form --}}
{{-- Add Student Form --}}
<form action="{{ route('students.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-4">
    @csrf
    <input 
        type="text" 
        name="student_id" 
        placeholder="Student ID" 
        required 
        class="border p-2 rounded dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"
    >

    <input 
        type="text" 
        name="name" 
        placeholder="Full Name" 
        required 
        class="border p-2 rounded dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"
    >

    <input 
        type="text" 
        name="course" 
        placeholder="Course (e.g. BSIT)" 
        required 
        class="border p-2 rounded dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"
    >

    <input 
        type="number" 
        name="year_level" 
        placeholder="Year Level (e.g. 1, 2, 3, 4)" 
        required 
        min="1" 
        max="5" 
        class="border p-2 rounded dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"
    >

    <input 
        type="text" 
        name="campus" 
        placeholder="Campus (e.g. Cauayan)" 
        required 
        class="border p-2 rounded dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"
    >

    <button 
        type="submit" 
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded col-span-1 md:col-span-5"
    >
        Add Student
    </button>
</form>


    {{-- Scrollable Student List --}}
    <div class="h-64 overflow-y-auto border border-gray-200 dark:border-gray-600 rounded p-2 bg-gray-50 dark:bg-gray-700">
        <ul class="space-y-2">
            @forelse($studentsList as $student)
                <li class="flex justify-between items-center px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="text-gray-800 dark:text-gray-100">{{ $student->student_id }} - {{ $student->name }} - {{ $student->campus}}</span>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                    </form>
                </li>
            @empty
                <li class="px-3 py-2 text-gray-500 dark:text-gray-400">No students found.</li>
            @endforelse
        </ul>
    </div>
</div>
</x-app-layout>