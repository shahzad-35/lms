<div>
    <h1 class="text-2xl font-bold mb-4">Create Course</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block mb-1">Title</label>
            <input type="text" wire:model="title" class="w-full border rounded px-3 py-2" />
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1">Description</label>
            <textarea wire:model="description" class="w-full border rounded px-3 py-2"></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1">Price (optional)</label>
            <input type="number" wire:model="price" class="w-full border rounded px-3 py-2" />
            @error('price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Save Course
        </button>
    </form>
</div>