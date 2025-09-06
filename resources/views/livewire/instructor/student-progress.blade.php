<div>
    <h1 class="text-2xl">Progress for {{ $course->title }}</h1>


    <table class="min-w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-2">Student</th>
                <th class="border px-2">Lesson</th>
                <th class="border px-2">Watched (s)</th>
                <th class="border px-2">Completed</th>
            </tr>
        </thead>
        <tbody>
            @foreach($course->lessons as $lesson)
            @foreach($lesson->watchLogs as $log)
            <tr>
                <td class="border px-2">{{ $log->user->name }}</td>
                <td class="border px-2">{{ $lesson->title }}</td>
                <td class="border px-2">{{ $log->watched_seconds }}</td>
                <td class="border px-2">{{ $log->completed ? '✅' : '❌' }}</td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>