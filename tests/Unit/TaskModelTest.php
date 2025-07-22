<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function task_pertenece_a_un_usuario()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $task->user);
        $this->assertEquals($user->id, $task->user->id);
    }

    /** @test */
    public function task_puede_tener_atributos_correctos()
    {
        $taskData = [
            'title' => 'Mi Tarea de Prueba',
            'description' => 'Esta es la descripción',
            'status' => 'pendiente',
            'priority' => 'alta',
            'due_date' => '2024-12-31',
        ];

        $user = User::factory()->create();
        $task = Task::factory()->create(array_merge($taskData, ['user_id' => $user->id]));

        $this->assertEquals($taskData['title'], $task->title);
        $this->assertEquals($taskData['description'], $task->description);
        $this->assertEquals($taskData['status'], $task->status);
        $this->assertEquals($taskData['priority'], $task->priority);
    }

    /** @test */
    public function task_scope_search_funciona_correctamente()
    {
        $user = User::factory()->create();
        
        $task1 = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Comprar groceries',
        ]);
        
        $task2 = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'Estudiar Laravel',
        ]);

        $results = Task::search('groceries')->get();
        
        $this->assertCount(1, $results);
        $this->assertEquals($task1->id, $results->first()->id);
    }

    /** @test */
    public function task_scope_status_funciona_correctamente()
    {
        $user = User::factory()->create();
        
        Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'pendiente',
        ]);
        
        Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'completada',
        ]);

        $pendingTasks = Task::status('pendiente')->get();
        $completedTasks = Task::status('completada')->get();
        
        $this->assertCount(1, $pendingTasks);
        $this->assertCount(1, $completedTasks);
    }

    /** @test */
    public function task_scope_priority_funciona_correctamente()
    {
        $user = User::factory()->create();
        
        Task::factory()->create([
            'user_id' => $user->id,
            'priority' => 'alta',
        ]);
        
        Task::factory()->create([
            'user_id' => $user->id,
            'priority' => 'baja',
        ]);

        $highPriorityTasks = Task::priority('alta')->get();
        $lowPriorityTasks = Task::priority('baja')->get();
        
        $this->assertCount(1, $highPriorityTasks);
        $this->assertCount(1, $lowPriorityTasks);
    }

    /** @test */
    public function task_puede_ser_marcada_como_completada()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'pendiente',
        ]);

        $task->update(['status' => 'completada']);

        $this->assertEquals('completada', $task->fresh()->status);
    }

    /** @test */
    public function task_tiene_campos_fillable_correctos()
    {
        $expectedFillable = [
            'title',
            'description',
            'status',
            'priority',
            'due_date',
            'user_id'
        ];

        $task = new Task();
        
        $this->assertEquals($expectedFillable, $task->getFillable());
    }
}
