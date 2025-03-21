{{-- Task Form --}}
<form class="w-full mx-auto py-4 mt-4" wire:submit.prevent='addUpdateTask'>
    <div class="px-4 py-2">
        <h1 class="font-bold text-lg">{{ $currentlyUpdatingTask ? 'Update Task' : 'Create a new task' }}</h1>
    </div>

    <div class="flex flex-col border border-gray-500 bg-gray-800 rounded-lg p-4 gap-4">
        {{-- Task Name --}}
        <input
            class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:outline-0"
            type="text" placeholder="Task.." wire:model='newTask' autofocus tabindex="1">
        {{-- /Task Name --}}
        {{-- Task Name Error --}}
        @error('newTask')
            <p class="bg-red-400 text-white p-2 font-bold">{{ $message }}</p>
        @enderror
        {{-- /Task Name Error --}}
        <div class="flex gap-4">
            {{-- Task Project --}}
            <input
                class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:outline-0"
                type="text" placeholder="Project.." wire:model='newTaskProject' tabindex="2">
            {{-- /Task Project --}}
            {{-- Task Priority --}}
            <input
                class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:outline-0"
                type="number" placeholder="Priority..(optional)" wire:model='newTaskPriority' tabindex="3" min="1">
            {{-- /Task Priority --}}
        </div>
        {{-- Task Project Error --}}
        @error('newTaskProject')
            <p class="bg-red-400 text-white p-2 font-bold">{{ $message }}</p>
        @enderror
        {{-- /Task Project Error --}}
        {{-- Task Priority Error --}}
        @error('newTaskPriority')
            <p class="bg-red-400 text-white p-2 font-bold">{{ $message }}</p>
        @enderror
        {{-- /Task Priority Error --}}
        {{-- Create Task Button --}}
        <button type="submit"
            class="{{ $currentlyUpdatingTask ? 'bg-green-900 hover:bg-green-950 border-none' : 'bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600' }} transition-colors hover:cursor-pointer text-sm border-4 text-white font-bold py-1 px-2 rounded">
            @if ($currentlyUpdatingTask)
                Update Task
            @else
                Create Task
            @endif
        </button>
        {{-- /Create Task Button --}}
        @if ($currentlyUpdatingTask)
            {{-- Create Task Button --}}
            <button type="button"
                class="bg-red-900 hover:bg-red-950 transition-colors hover:cursor-pointer text-sm text-white font-bold py-1 px-2 rounded"
                wire:click='cancelTaskUpdate'>
                Cancel Update
            </button>
            {{-- /Create Task Button --}}
        @endif
    </div>
</form>
{{-- /Task Form --}}
