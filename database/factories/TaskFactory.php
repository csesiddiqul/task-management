<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'status' => 'pending',
            'priority' => 'medium',
            'due_date' => now()->addDays(3),
            'created_by' => User::factory(),
            'assigned_to' => User::factory(),
        ];
    }
}
