<div>
    <h1 class="text-2xl font-bold mb-4">Add Lesson</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <input type="hidden" wire:model="course_id">

        <div>
            <label class="block mb-1">Title</label>
            <input type="text" wire:model="title" class="w-full border rounded px-3 py-2" />
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1">Video File</label>
            <input type="file" wire:model="video" class="w-full border rounded px-3 py-2" />
            @error('video') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

            <div wire:loading wire:target="video" class="text-blue-600 text-sm mt-2">
                Uploading...
            </div>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Save Lesson
        </button>
    </form>
</div>