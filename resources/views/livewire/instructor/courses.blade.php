<div>
    <h1 class="text-2xl font-bold mb-4">My Courses</h1>

    <a href="{{ route('instructor.courses.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Create New Course
    </a>

    <div class="mt-6 space-y-4">
        @forelse($courses as $course)
        <div class="p-4 border rounded shadow bg-white">
            <h2 class="text-xl font-semibold">{{ $course->title }}</h2>
            <p class="text-gray-600">{{ $course->description }}</p>
            <div class="mt-2 flex justify-between items-center">
                <span class="text-sm text-gray-500">Price: ${{ $course->price ?? 'Free' }}</span>
                <a href="{{ route('instructor.lessons.create', $course->id) }}" class="text-blue-600 hover:underline">
                    + Add Lesson
                </a>
            </div>
        </div>
        @empty
        <p class="text-gray-500">No courses yet.</p>
        @endforelse
    </div>
</div>