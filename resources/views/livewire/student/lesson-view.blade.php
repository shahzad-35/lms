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
});
</script>
@endpush