<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Task::factory()->create([
            'priority'  => 1,
            'body'      => "Finish Up Task Manager",
            'project'   => 'Laravel Skills Test Edit - Coalition Technologies',
            'done_at'   => now(),
            'created_at'=> now()
        ]);

        Task::factory()->create([
            'priority'  => 2,
            'body'      => "Get Hired",
            'project'   => 'Coalition Technologies',
            'done_at'   => null,
            'created_at'=> now()
        ]);
    }
}
