<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Collection;

class TaskManager extends Component
{
    public string $newTask = '';
    public string $newTaskProject = '';
    public ?int $newTaskPriority = null;

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

        if ($this->newTaskPriority) {
            $this->shiftTaskPriority();
        } else {
            $this->newTaskPriority = (Task::query()->orderBy('priority', 'desc')->first()->priority ?? 0) + 1;
        }

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
            'done_at' => (!$task->done_at ? now() : null) // if the task is being toggled as undone, make the task's done_at = null.
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
        $this->newTaskPriority = $task->priority;
    }

    public function handleUpdateTask()
    {
        $task = Task::query()->find($this->currentlyUpdatingTask);

        $this->shiftTaskPriority();

        $task->update([
            'body' => $this->newTask,
            'project' => $this->newTaskProject,
            'priority' => $this->newTaskPriority
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
        $this->newTaskPriority = null;
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
            // if the filter is complete, set the query = (where 'done_at' != null)
            // else, set the query = (where 'done_at' = null);
            $query->where('done_at', ($this->filterTaskStatus == 'complete' ? "!=" : "="), null);
        }

        $this->tasks = $query->orderBy('priority')->get();
    }

    private function validateTask()
    {
        $this->validate([
            'newTask' => ['required', 'unique:tasks,body','max:300'],
            'newTaskProject' => ['required'],
            'newTaskPriority' => ['numeric', 'min:1', 'max:1264']
        ]);
    }

    private function shiftTaskPriority()
    {
        // update the priority of all tasks that have the same or higher priority than the entered priority to their current priority +1
        // basically, shift priorities by 1 to make space for the new task item.
        foreach(Task::query()->where('priority', '>=', $this->newTaskPriority)->get() as $sameOrHigherPriorityTask) {
            $sameOrHigherPriorityTask->update([
                'priority' => $sameOrHigherPriorityTask->priority + 1
            ]);
        }
    }
}
