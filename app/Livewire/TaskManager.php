<?php

namespace App\Livewire;

use Livewire\Component;

class TaskManager extends Component
{
    public string $newTask = '';
    public string $newTaskProject = '';
    public int $newTaskPriority;
    public string $filterProject = 'all';

    public array $tasks = [];
    public array $projects = [
       'All Projects'
    ];

    public function addTask()
    {
        // function here
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
}
