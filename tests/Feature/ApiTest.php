<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::before(function () {
            return true;
        });

        $this->user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);
    }

    public function test_login_api()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function test_logout_api()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200);
    }

    public function test_get_auth_user()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/auth/user');

        $response->assertStatus(200);
    }

    public function test_get_users_list()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
    }

    public function test_create_task()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Demo task',
            'status' => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDay()->format('Y-m-d'),
            'assigned_to' => $this->user->id,
        ]);

        $response->assertStatus(201);
    }

    public function test_get_tasks()
    {
        Sanctum::actingAs($this->user);

        Task::factory()->count(3)->create([
            'created_by' => $this->user->id,
            'assigned_to' => $this->user->id,
        ]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);
    }

    public function test_my_tasks()
    {
        Sanctum::actingAs($this->user);

        Task::factory()->count(2)->create([
            'assigned_to' => $this->user->id,
        ]);

        $response = $this->getJson('/api/my-tasks');

        $response->assertStatus(200);
    }

    public function test_update_task()
    {
        Sanctum::actingAs($this->user);

        $task = Task::factory()->create([
            'created_by' => $this->user->id,
            'assigned_to' => $this->user->id,
        ]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Task',
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_task()
    {
        Sanctum::actingAs($this->user);

        $task = Task::factory()->create([
            'created_by' => $this->user->id,
            'assigned_to' => $this->user->id,
        ]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
    }
}
