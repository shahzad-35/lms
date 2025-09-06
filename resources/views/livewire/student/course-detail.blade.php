<div class="p-6">
    {{-- Flash messages --}}
    @if(session()->has('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <h1 class="text-2xl font-bold mb-2">{{ $course->title }}</h1>
    <p class="mb-4 text-gray-700">{{ $course->description }}</p>

    <div class="mb-4">
        <span class="text-sm text-gray-500">Price:</span>
        <span class="font-medium">{{ $course->price ? '$'.$course->price : 'Free' }}</span>
    </div>

    @if(!$isEnrolled)
    <div class="mb-6">
        <button wire:click="enroll" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Enroll in course
        </button>
        <span class="text-sm text-gray-500 ml-3">or go back to <a href="{{ route('student.courses') }}"
                class="text-blue-600 underline">Browse Courses</a></span>
    </div>

    <div class="p-4 border rounded bg-yellow-50 text-sm text-gray-700">
        You must enroll to access lessons. After enrolling you will be redirected to <strong>My Enrollments</strong>.
    </div>
    @else
    <div class="mt-4">
        <h2 class="text-xl font-semibold mb-2">Lessons</h2>

        @if($course->lessons->count())
        <ul class="space-y-3">
            @foreach($course->lessons as $lesson)
            <li class="p-3 border rounded flex items-center justify-between bg-white">
                <div>
                    <div class="font-medium">
                        @if($lesson->order) {{ $lesson->order }}. @endif {{ $lesson->title }}
                    </div>
                    <div class="text-sm text-gray-500">
                        Duration: {{ $lesson->duration ? gmdate('H:i:s', $lesson->duration) : '-' }}
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-sm text-gray-600">
                        {{ isset($progress[$lesson->id]) ? $progress[$lesson->id].'%' : '0%' }}
                    </div>

                    <a href="{{ route('student.lessons.view', $lesson->id) }}"
                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                        Start / Continue
                    </a>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-600">No lessons yet. Instructor will add lessons soon.</p>
        @endif
    </div>
    @endif
</div>