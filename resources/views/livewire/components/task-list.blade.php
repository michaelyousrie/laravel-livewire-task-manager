{{-- Task List --}}
<section class="mt-4 py-4 rounded-lg">
    <div class="flex justify-between items-center w-full pb-4">
        <h1 class="font-white font-bold text-lg px-4 border-b border-gray-700">Your Task List</h1>
        {{-- Task State Filter --}}
        <select class="px-4 bg-gray-700 border border-gray-500" wire:model='filterTaskStatus' wire:change='filterTasks'>
            <option value="all">All</option>
            <option value="complete">Completed</option>
            <option value="incomplete">InComplete</option>
        </select>
        {{-- /Task State Filter --}}

        {{-- Projects Filter --}}
        @if ($projects->count())
            <select class="px-4 bg-gray-700 border border-gray-500" wire:model='filterProjectName' wire:change='filterTasks'>
                @foreach ($projects as $project)
                    <option value="{{ $project }}">{{ $project }}</option>
                @endforeach
            </select>
        @endif
        {{-- /Projects Filter --}}
    </div>
    {{-- Task List --}}
    @if ($tasks->count())
        <ul class="flex flex-col gap-1 w-full" wire:sortable="updateTaskListPriority">
            @foreach ($tasks as $task)
                <li class="{{ $task->is_done ? 'bg-gray-800' : 'bg-gray-900' }}"
                    wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}"
                >
                    <div class="flex items-center p-4 gap-2 max-w-full text-wrap">
                        {{-- Task Sort Button --}}
                        <span class="hover:cursor-grab" wire:sortable.handle title="Hold & Drag to sort">
                            ☰
                        </span>
                        {{-- /Task Sort Button --}}
                        {{-- Task ID --}}
                        <span class="text-xs text-gray-400 text-light">#{{ $task->id }}</span>
                        {{-- /Task ID --}}
                        <div class="flex-1 flex gap-1 items-center">
                            {{-- Task Body --}}
                            <p class="text-gray-200 text-lg font-medium break-all {{ $task->is_done ? 'line-through text-gray-600' : '' }}">{{ $task->body }}</p>
                            {{-- /Task Body --}}
                            {{-- Task Project --}}
                            <p class="text-xs font-bold text-gray-500">({{ $task->project }})</p>
                            {{-- /Task Project --}}
                        </div>
                        {{-- Task Status --}}
                        <button
                            class="{{ $task->is_done ? 'text-red-500' : 'text-green-500' }} hover:cursor-pointer"
                            wire:click='toggleTask({{ $task->id }})'
                            title="{{ $task->is_done ? 'Mark as Incomplete' : 'Mark as Complete' }}"
                        >
                            @if ($task->is_done)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.498 15.25H4.372c-1.026 0-1.945-.694-2.054-1.715a12.137 12.137 0 0 1-.068-1.285c0-2.848.992-5.464 2.649-7.521C5.287 4.247 5.886 4 6.504 4h4.016a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23h1.294M7.498 15.25c.618 0 .991.724.725 1.282A7.471 7.471 0 0 0 7.5 19.75 2.25 2.25 0 0 0 9.75 22a.75.75 0 0 0 .75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 0 0 2.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384m-10.253 1.5H9.7m8.075-9.75c.01.05.027.1.05.148.593 1.2.925 2.55.925 3.977 0 1.487-.36 2.89-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398-.306.774-1.086 1.227-1.918 1.227h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 0 0 .303-.54"
                                    />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z"
                                    />
                                </svg>
                            @endif
                        </button>
                        {{-- /Task Status --}}
                        {{-- Task Update --}}
                        <button
                            class="{{ $task->is_done ? 'text-yellow-800 hover:cursor-not-allowed' : 'text-yellow-500 hover:cursor-pointer' }}"
                            wire:click='updateTask({{ $task->id }})'
                            @if ($task->is_done) title="You can't update a completed task!" @endif
                            {{ $task->is_done ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                        </button>
                        {{-- /Task Update --}}
                        {{-- Task Delete --}}
                        <button class="text-red-500 hover:cursor-pointer"
                            wire:click='deleteTask({{ $task->id }})'
                            wire:confirm='Are you sure you want to delete this task? This action is irreversible'>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                        {{-- /Task Delete --}}
                    </div>
                    <div class="flex gap-2 w-full justify-between px-4 py-2">
                        {{-- Task Created At Human Form --}}
                        <span class="text-xs font-light text-center flex gap-1" title="Created {{ $task->created_at->diffForHumans() }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-green-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            {{ $task->created_at->diffForHumans() }}
                        </span>
                        {{-- /Task Created At Human Form --}}
                        {{-- Task Updated At Human Form --}}
                        @if ($task->is_done)
                            <span class="text-xs font-light text-center flex gap-1" title="Done {{ $task->done_at->diffForHumans() }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-green-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                {{ $task->done_at->diffForHumans() }}
                            </span>
                        @endif
                        {{-- /Task Updated At Human Form --}}
                    </div>
                </li>
            @endforeach
        </ul>
        {{-- /Task List --}}
    @else
        <div class="w-full text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-12 inline">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
            </svg>
            <p>
                It's lonely in here.. start adding tasks..
            </p>
        </div>
    @endif
</section>
{{-- /Task List --}}
