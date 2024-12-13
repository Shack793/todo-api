<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_todos()
    {
        Todo::factory()->count(3)->create();

        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
                ->assertJsonStructure(['todos'])
                ->assertJsonCount(3, 'todos');
    }

    public function test_can_filter_todos_by_status()
    {
        Todo::factory()->count(2)->create(['status' => 'completed']);
        Todo::factory()->count(3)->create(['status' => 'in-progress']);

        $response = $this->getJson('/api/todos?status=completed');

        $response->assertStatus(200)
                ->assertJsonCount(2, 'todos');
    }

    public function test_can_search_todos()
    {
        Todo::factory()->create(['title' => 'Test Todo']);
        Todo::factory()->create(['details' => 'Test Details']);
        Todo::factory()->create(['title' => 'Another Todo']);

        $response = $this->getJson('/api/todos?search=Test');

        $response->assertStatus(200)
                ->assertJsonCount(2, 'todos');
    }

    public function test_can_sort_todos()
    {
        $first = Todo::factory()->create(['title' => 'A Todo']);
        $second = Todo::factory()->create(['title' => 'B Todo']);

        $response = $this->getJson('/api/todos?sort_by=title&order=asc');

        $response->assertStatus(200)
                ->assertJson([
                    'todos' => [
                        ['id' => $first->id],
                        ['id' => $second->id]
                    ]
                ]);
    }

    public function test_can_create_todo()
    {
        $todoData = [
            'title' => 'New Todo',
            'details' => 'Todo Details',
            'status' => 'not-started'
        ];

        $response = $this->postJson('/api/todos', $todoData);

        $response->assertStatus(201)
                ->assertJson([
                    'message' => 'Todo created successfully',
                    'todo' => $todoData
                ]);

        $this->assertDatabaseHas('todos', $todoData);
    }

    public function test_can_update_todo()
    {
        $todo = Todo::factory()->create();
        $updateData = [
            'title' => 'Updated Todo',
            'details' => 'Updated Details',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/todos/{$todo->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Todo updated successfully',
                    'todo' => $updateData
                ]);

        $this->assertDatabaseHas('todos', $updateData);
    }

    public function test_can_delete_todo()
    {
        $todo = Todo::factory()->create();

        $response = $this->deleteJson("/api/todos/{$todo->id}");

        $response->assertStatus(200)
                ->assertJson(['message' => 'Todo deleted successfully']);

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }

    public function test_validates_required_fields_when_creating_todo()
    {
        $response = $this->postJson('/api/todos', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title', 'status']);
    }

    public function test_validates_status_enum_values()
    {
        $response = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'status' => 'invalid-status'
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['status']);
    }
}
