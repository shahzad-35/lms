<div>
    <h2 class="text-xl font-semibold mb-4">{{ $lesson->title }}</h2>


    <video id="lesson-player" class="video-js vjs-default-skin w-full" controls preload="auto" data-setup='{}'>
        <source src="{{ Storage::url($lesson->video_path) }}" type="video/mp4">
    </video>
</div>


@push('scripts')
<script>
    document.addEventListener('livewire:navigated', () => {
if (window.player) {
window.player.dispose();
}
window.player = videojs('lesson-player');


// Event listeners
const userId = {{ auth()->id() }};
const lessonId = {{ $lesson->id }};


function sendProgress(eventType, currentTime, duration) {
fetch("/api/watch-log", {
method: "POST",
headers: {
"Content-Type": "application/json",
"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
},
body: JSON.stringify({
user_id: userId,
lesson_id: lessonId,
current_time: currentTime,
duration: duration,
event: eventType
})
});
}


window.player.on('play', () => sendProgress('play', window.player.currentTime(), window.player.duration()));
window.player.on('pause', () => sendProgress('pause', window.player.currentTime(), window.player.duration()));
window.player.on('seeked', () => sendProgress('seek', window.player.currentTime(), window.player.duration()));
window.player.on('ended', () => sendProgress('ended', window.player.currentTime(), window.player.duration()));
});
</script>
@endpush