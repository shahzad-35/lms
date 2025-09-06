<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'LMS') }}</title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow p-4 flex justify-between">
    <div>
        <a href="/" class="mr-4">Home</a>

        @auth
            @if(auth()->user()->role === 'instructor')
                <a href="{{ route('instructor.courses') }}" class="mr-4">Instructor Courses</a>
            @endif

            @if(auth()->user()->role === 'student')
                <a href="{{ route('student.courses') }}" class="mr-4">Browse Courses</a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="mr-4">Admin Panel</a>
            @endif
        @endauth
    </div>

    <div>
        @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="hover:underline text-red-600">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="mr-4">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>


    <main class="container mx-auto px-4">
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>