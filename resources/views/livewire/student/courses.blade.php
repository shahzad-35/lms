<div>
    <h1 class="text-2xl font-bold mb-4">Available Courses</h1>

    @if (session('message'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
        {{ session('message') }}
    </div>
    @endif

    <div class="grid grid-cols-3 gap-4">
        @foreach ($courses as $course)
        <div class="p-4 border rounded shadow bg-white">
            <h2 class="text-xl font-semibold">{{ $course->title }}</h2>
            <p class="text-gray-700">{{ $course->description }}</p>
            <p class="text-sm text-gray-600 mb-2">
                Enrolled: {{ $course->students_count }}
            </p>

            {{-- If already enrolled --}}
            @if ($user->enrolledCourses->contains($course->id))
            <a href="{{ route('student.courses.detail', $course->id) }}"
                class="mt-2 inline-block bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                Continue Course
            </a>

            {{-- Not enrolled yet --}}
            @else
            <a href="{{ route('student.courses.detail', $course->id) }}" class="bg-{{ $course->price > 0 ? 'green' : 'blue' }}-600 
                               text-white px-3 py-1 rounded hover:bg-{{ $course->price > 0 ? 'green' : 'blue' }}-700">
                {{ $course->price > 0 ? 'View & Pay' : 'View & Enroll' }}
            </a>
            @endif
        </div>
        @endforeach
    </div>
</div>