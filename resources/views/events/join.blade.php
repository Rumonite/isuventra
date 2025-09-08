<!DOCTYPE html>
<html>
<head>
    <title>Join Event</title>
</head>
<body>
    <h1>Join Event: {{ $event->title }}</h1>

    {{-- Show success or error messages --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    {{-- Join form --}}
    <form action="/events/{{ $event->id }}/participate" method="POST">
        @csrf
        <label for="student_id">Enter your Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
        <button type="submit">Join Event</button>
    </form>
</body>
</html>
