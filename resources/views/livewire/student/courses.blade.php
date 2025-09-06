<div>
    <h1 class="text-2xl font-bold mb-4">Available Courses</h1>

    @if (session('message'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
        {{ session('message') }}
    </div>
    @endif

    <div class="grid grid-cols-3 gap-4">
        @foreach ($courses as $course)
        <div class="p-4 border rounded shadow">
            <h2 class="text-xl font-semibold">{{ $course->title }}</h2>
            <p>{{ $course->description }}</p>
            <p class="text-sm text-gray-600">Enrolled: {{ $course->students_count }}</p>

            @if ($user->enrolledCourses->contains($course->id))
            <a href="{{ route('student.course.show', $course->id) }}"
                class="mt-2 inline-block bg-blue-500 text-white px-4 py-1 rounded">
                Continue Course
            </a>
            @else
            <button wire:click="enroll({{ $course->id }})" class="mt-2 bg-green-500 text-white px-4 py-1 rounded">
                Enroll
            </button>
            @endif
        </div>
        @endforeach
    </div>
</div>