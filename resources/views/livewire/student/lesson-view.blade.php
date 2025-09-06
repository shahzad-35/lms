<div>
    <h1 class="text-2xl font-bold mb-4">{{ $lesson->title }}</h1>

    <div class="w-96 h-56 overflow-hidden rounded shadow">
        <video id="lesson-player" class="video-js w-full h-full" controls preload="auto">
            <source src="{{ asset('storage/' . $lesson->video_path) }}" type="video/mp4" />
        </video>
    </div>

    <div class="mt-2 text-sm text-gray-700">
        Watched: {{ round(($currentTime / max(1, $lesson->duration)) * 100, 1) }}%
    </div>

    {{-- Bind currentTime to Livewire --}}
    <input type="hidden" wire:model="currentTime">

    {{-- Poll backend every 2s to save --}}
    <div wire:poll.2s="updateWatch"></div>

    {{-- Video.js CSS + JS --}}
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

    <script>
        document.addEventListener('livewire:load', function () {
        var player = videojs('lesson-player');

        // Resume from last position
        player.currentTime(@this.get('currentTime'));

        // Update Livewire property every second
        setInterval(() => {
            @this.set('currentTime', Math.floor(player.currentTime()));
        }, 1000);
    });
    </script>
</div>