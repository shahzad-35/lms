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

    <input type="hidden" wire:model="currentTime">

    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

    <script>
        const player = document.getElementById('lesson-player');
        player.addEventListener('pause', () => {
        const currentTime = Math.floor(player.currentTime);
        @this.call('updateWatch', currentTime);
    });
    let lastUpdate = 0;

    player.addEventListener('ended', () => {
        const currentTime = Math.floor(player.currentTime);
        @this.call('updateWatch', currentTime);
    });

    //     player.addEventListener('timeupdate', () => {
    //         const currentTime = Math.floor(player.currentTime);
    
    // if (currentTime - lastUpdate >= 2) {
    //     lastUpdate = currentTime;
    //     console.log("Watched seconds:", currentTime);
    //                 @this.call('updateWatch', currentTime);
    // }
    //     });
    </script>
</div>