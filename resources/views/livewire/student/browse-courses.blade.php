<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Available Courses</h1>

    @foreach ($courses as $course)
    <div class="border rounded-lg p-4 mb-4 shadow">
        <h2 class="text-xl font-semibold">{{ $course->title }}</h2>
        <p>{{ $course->description }}</p>
        <p class="text-gray-600">Price: ${{ $course->price ?? 'Free' }}</p>

        @if($course->enrollments->where('user_id', auth()->id())->count())
        <a href="{{ route('student.enrollments') }}"
            class="bg-green-500 text-white px-3 py-1 rounded mt-2 inline-block">
            Continue Course
        </a>
        @else
        <button wire:click="enroll({{ $course->id }})" class="bg-blue-500 text-white px-3 py-1 rounded mt-2">
            Enroll
        </button>
        @endif
    </div>
    @endforeach

    @if (session()->has('success'))
    <div class="mt-4 text-green-600">{{ session('success') }}</div>
    @endif
    @if (session()->has('info'))
    <div class="mt-4 text-blue-600">{{ session('info') }}</div>
    @endif
</div>