<div>
    <div class="w-xl mx-auto bg-gray-700 border border-gray-500 shadow-lg rounded-lg overflow-hidden mt-16 text-gray-200">
    <div class="px-4 py-2">
        <h1 class="font-bold text-lg">What will you work on today?</h1>
    </div>
    <form class="w-full mx-auto px-4 py-2" wire:submit.prevent='addTask'>
        <div class="flex flex-col border border-gray-500 bg-gray-800 rounded-lg p-4 gap-4">
            {{-- Task Name --}}
            <input
                class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:outline-0"
                type="text"
                placeholder="Task.."
                wire:model='newTask'
                autofocus
                tabindex="1"
            >
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
                    type="text"
                    placeholder="Project.."
                    wire:model='newTaskProject'
                    tabindex="2"
                >
                {{-- /Task Project --}}
                {{-- Task Priority --}}
                <input
                    class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:outline-0"
                    type="number"
                    placeholder="Priority.."
                    wire:model='newTaskPriority'
                    tabindex="3"
                    min="1"
                >
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
            <button
                class="bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600 hover:cursor-pointer text-sm border-4 text-white font-bold py-1 px-2 rounded"
            >
                Create Task
            </button>
            {{-- /Create Task Button --}}
        </div>
    </form>
    {{-- Task List --}}
    <section class="mt-4 py-4 rounded-lg">
        <div class="flex justify-between items-center w-full pb-4">
            <h1 class="font-white font-bold text-lg px-4 border-b border-gray-700">Your Task List</h1>
            {{-- Projects Filter --}}
            @if($projects->count())
            <select class="px-4 bg-gray-700" wire:model='filterProject'>
                @foreach($projects as $project)
                    <option value="{{ $project }}">{{ $project }}</option>
                @endforeach
            </select>
            @endif
            {{-- /Projects Filter --}}
        </div>
        {{-- Task List --}}
        @if ($tasks->count())
        <ul class="flex flex-col gap-1">
            @foreach($tasks as $task)
            <li class="{{ $task->is_done ? 'bg-gray-800' : 'bg-gray-900' }} w-full block">
                <div class="flex items-center p-4 gap-4">
                    <span class="text-xs w-4">#{{ $task->priority }}</span>
                    {{-- Task Is Done Checkbox --}}
                    <input
                        type="checkbox"
                        class="h-4 w-4 border-gray-300 rounded"
                        id="{{ $task->id }}"
                        wire:change='toggleTask({{ $task->id }})'
                        {{ $task->is_done ? 'checked' : '' }}
                    >
                    {{-- /Task Is Done Checkbox --}}
                    {{-- Task Body & Project --}}
                    <label for="{{ $task->id }}" class="ml-3 text-gray-200 flex justify-between w-full">
                        <span class="text-lg font-medium {{ $task->is_done ? 'line-through text-gray-600' : ''}}">{{ $task->body }}</span>
                        <span class="text-md font-light text-gray-500">{{ $task->project }}</span>
                    </label>
                    {{-- /Task Body & Project --}}
                    {{-- Task Created At Human Form --}}
                    <span class="text-xs font-light text-center">{{ $task->created_at->diffForHumans() }}</span>
                    {{-- /Task Created At Human Form --}}
                    {{-- Task Delete --}}
                    <button class="text-red-500 hover:cursor-pointer" wire:click='deleteTask({{ $task->id }})' wire:confirm='Are you sure you want to delete this task? This action is irreversible'>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                          </svg>
                    </button>
                    {{-- /Task Delete --}}
                </div>
            </li>
            @endforeach
        </ul>
        {{-- /Task List --}}
        @else
        <div class="w-full text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 inline">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
              </svg>
            <p>
                It's lonely in here.. start adding tasks..
            </p>
        </div>
        @endif
    </section>
    {{-- /Task List --}}
</div>
</div>
