<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">My Enrolled Courses</h1>

    @forelse ($enrollments as $enrollment)
    <div class="border rounded-lg p-4 mb-4 shadow">
        <h2 class="text-xl font-semibold">{{ $enrollment->course->title }}</h2>
        <p>{{ $enrollment->course->description }}</p>
        <a href="{{ route('student.course.show', $enrollment->course->id) }}"
            class="bg-green-500 text-white px-3 py-1 rounded">Start / Continue</a>

    </div>
    @empty
    <p>You are not enrolled in any course yet.</p>
    @endforelse
</div>