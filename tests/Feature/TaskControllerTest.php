<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_tasks_with_correct_structure()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'tasks' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'status',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                    'per_page',
                    'total',
                    'current_page',
                ],
            ]);
    }

    public function test_returns_empty_list_when_no_tasks_exist()
    {
        $response = $this->getJson('/api/v1/tasks');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'tasks' => [],
                    'per_page' => 10,
                    'total' => 0,
                    'current_page' => 1,
                ],
            ]);
    }

    public function test_returns_a_paginated_list_of_tasks()
    {
        Task::factory()->count(15)->create();

        $response = $this->getJson('/api/v1/tasks');

        $this->assertCount(10, $response->json('data.tasks'));
        $this->assertEquals(15, $response->json('data.total'));
        $this->assertEquals(1, $response->json('data.current_page'));
    }

    public function test_returns_paginated_tasks_for_second_page()
    {
        Task::factory()->count(15)->create();

        $response = $this->getJson('/api/v1/tasks?page=2');

        $response->assertStatus(200);
        $this->assertCount(5, $response->json('data.tasks'));
        $this->assertEquals(2, $response->json('data.current_page'));
    }

    public function test_creates_a_task_successfully()
    {
        $payload = [
            'title' => 'New Task',
            'description' => 'This is a new task',
            'status' => 1,
        ];

        $response = $this->postJson('/api/v1/tasks', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Task created successfully.',
                'data' => $payload,
            ]);

        $this->assertDatabaseHas('tasks', $payload);
    }

    public function test_requires_title()
    {
        $payload = [
            'description' => 'Missing title test',
            'status' => 1,
        ];

        $response = $this->postJson('/api/v1/tasks', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_requires_description()
    {
        $payload = [
            'title' => 'Task without description',
            'status' => 1,
        ];

        $response = $this->postJson('/api/v1/tasks', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
    }

    public function test_requires_status()
    {
        $payload = [
            'title' => 'Task without status',
            'description' => 'Some description',
        ];

        $response = $this->postJson('/api/v1/tasks', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }

    public function test_rejects_invalid_status()
    {
        $payload = [
            'title' => 'Task with invalid status',
            'description' => 'Some description',
            'status' => 99,
        ];

        $response = $this->postJson('/api/v1/tasks', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }
}
