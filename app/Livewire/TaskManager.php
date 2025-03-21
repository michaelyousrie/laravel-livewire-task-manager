<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Collection;

class TaskManager extends Component
{
    public string $newTask = '';
    public string $newTaskProject = '';

    public string $filterProjectName = 'All Projects';
    public string $filterTaskStatus = 'all';

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

        $lowestPriority = Task::query()->orderBy('priority', 'desc')->first('priority')->priority ?? 0;

        Task::query()
            ->create([
                'body'      => $this->newTask,
                'project'   => $this->newTaskProject,
                'priority'  => $lowestPriority + 1
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
        $this->resetValidation();

        $task = Task::query()->find($taskId);

        $this->currentlyUpdatingTask = $taskId;

        $this->newTask = $task->body;
        $this->newTaskProject = $task->project;
    }

    public function handleUpdateTask()
    {
        $task = Task::query()->find($this->currentlyUpdatingTask);

        $task->update([
            'body' => $this->newTask,
            'project' => $this->newTaskProject,
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

    public function updateTaskListPriority($tasks)
    {
        foreach($tasks as $task) {
            Task::query()->find($task['value'])->update(['priority' => $task['order']]);
        }

        $this->fetchTasks();
    }

    public function filterTasks()
    {
        $this->fetchTasks();
    }

    private function resetForm()
    {
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
        $query = Task::query();

        if ($this->filterProjectName !== 'All Projects') {
            $query->where('project', $this->filterProjectName);
        }

        if ($this->filterTaskStatus !== 'all') {
            $query->where('is_done', ($this->filterTaskStatus == 'complete' ? true : false));
        }

        $this->tasks = $query->orderBy('priority')->get();
    }

    private function validateTask()
    {
        $this->validate([
            'newTask' => ['required', 'unique:tasks,body','max:300'],
            'newTaskProject' => ['required'],
        ]);
    }
}
