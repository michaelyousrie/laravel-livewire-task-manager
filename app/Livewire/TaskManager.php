<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Collection;

class TaskManager extends Component
{
    public ?int $newTaskPriority = null;
    public string $newTask = '';
    public string $newTaskProject = '';

    public string $filterProject = 'all';

    public Collection $tasks;
    public Collection $projects;

    public ?int $currentlyUpdatingTask = null;

    public function mount()
    {
        $this->fetchProjects();
        $this->fetchTasks();
    }

    public function render()
    {
        return view('livewire.task-manager');
    }

    public function addUpdateTask()
    {
        if ($this->currentlyUpdatingTask) {
            return $this->handleUpdateTask();
        }

        $this->validateTask();

        Task::query()
            ->create([
                'body'      => $this->newTask,
                'project'   => $this->newTaskProject,
                'priority'  => $this->newTaskPriority
            ]);

        $this->resetForm();

        $this->fetchProjects();

        $this->fetchTasks();
    }

    public function toggleTask(int $taskId)
    {
        $task = Task::query()->find($taskId);
        $task->update([
            'is_done' => !$task->is_done,
            'done_at' => now()
        ]);

        $this->fetchTasks();
    }

    public function deleteTask(int $taskId)
    {
        Task::query()->find($taskId)->delete();

        $this->fetchProjects();
        $this->fetchTasks();
    }

    public function updateTask(int $taskId)
    {
        $task = Task::query()->find($taskId);

        $this->currentlyUpdatingTask = $taskId;

        $this->newTask = $task->body;
        $this->newTaskPriority = $task->priority;
        $this->newTaskProject = $task->project;
    }

    public function handleUpdateTask()
    {
        $task = Task::query()->find($this->currentlyUpdatingTask);

        $task->update([
            'body' => $this->newTask,
            'project' => $this->newTaskProject,
            'priority' => $this->newTaskPriority,
        ]);

        $this->resetForm();
        $this->fetchProjects();
        $this->fetchTasks();
        $this->cancelTaskUpdate();
    }

    public function cancelTaskUpdate()
    {
        $this->resetForm();
        $this->currentlyUpdatingTask = null;
    }

    private function resetForm()
    {
        $this->newTaskPriority = null;
        $this->newTask = '';
        $this->newTaskProject = '';
    }

    private function fetchProjects()
    {
        $this->projects = collect();

        $projects = Task::query()->distinct()->get('project')->pluck('project');

        if ($projects->count()) {
            $this->projects = collect(['All Projects', ...$projects]);
        }
    }

    private function fetchTasks()
    {
        $this->tasks = Task::query()->orderBy('priority')->get();
    }

    private function validateTask()
    {
        $this->validate([
            'newTask' => ['required', 'unique:tasks,body'],
            'newTaskProject' => ['required'],
            'newTaskPriority' => ['required', 'numeric', 'min:1', 'max:1000', 'unique:tasks,priority']
        ]);
    }
}
