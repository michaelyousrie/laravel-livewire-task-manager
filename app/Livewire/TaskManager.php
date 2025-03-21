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

    public function mount()
    {
        $this->fetchProjects();
        $this->fetchTasks();
    }

    public function addTask()
    {
        $this->validate([
            'newTask' => ['required', 'unique:tasks,body'],
            'newTaskProject' => ['required'],
            'newTaskPriority' => ['required', 'numeric', 'min:1', 'max:1000', 'unique:tasks,priority']
        ]);

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

    public function toggleTask()
    {
        // function here
    }

    public function deleteTask()
    {
        // function here
    }

    public function render()
    {
        return view('livewire.task-manager');
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

        $projects = Task::query()->select('project')->distinct()->get()->pluck('project');

        if ($projects->count()) {
            $this->projects = collect(['All Projects', ...$projects]);
        }
    }

    private function fetchTasks()
    {
        $this->tasks = Task::query()->orderBy('priority')->get(['id', 'priority', 'body', 'project', 'is_done', 'created_at']);
    }
}
