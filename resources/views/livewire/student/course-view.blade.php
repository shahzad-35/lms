<div>
    <h1 class="text-2xl font-bold">{{ $course->title }}</h1>
    <p>{{ $course->description }}</p>


    <ul class="mt-4">
        @foreach($course->lessons as $lesson)
        <li>
            <a href="{{ route('student.lessons.view', $lesson->id) }}" class="text-blue-500">{{ $lesson->title }}</a>
        </li>
        @endforeach
    </ul>
</div>