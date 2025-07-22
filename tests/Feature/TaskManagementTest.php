<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function usuarios_autenticados_pueden_ver_la_lista_de_tareas()
    {
        $this->actingAs($this->user);
        
        Task::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->get('/tasks');
        
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
    }

    /** @test */
    public function usuarios_no_autenticados_no_pueden_ver_tareas()
    {
        $response = $this->get('/tasks');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function usuarios_pueden_ver_formulario_de_crear_tarea()
    {
        $this->actingAs($this->user);

        $response = $this->get('/tasks/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('tasks.create');
    }

    /** @test */
    public function usuarios_pueden_crear_tareas_con_datos_validos()
    {
        $this->actingAs($this->user);

        $taskData = [
            'title' => 'Nueva Tarea de Prueba',
            'description' => 'Esta es una descripción de prueba',
            'status' => 'pendiente',
            'priority' => 'alta',
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ];

        $response = $this->post('/tasks', $taskData);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'title' => 'Nueva Tarea de Prueba',
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function crear_tarea_requiere_titulo()
    {
        $this->actingAs($this->user);

        $response = $this->post('/tasks', [
            'title' => '',
            'status' => 'pendiente',
            'priority' => 'media',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function crear_tarea_requiere_titulo_minimo_3_caracteres()
    {
        $this->actingAs($this->user);

        $response = $this->post('/tasks', [
            'title' => 'AB',
            'status' => 'pendiente',
            'priority' => 'media',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function crear_tarea_requiere_status_valido()
    {
        $this->actingAs($this->user);

        $response = $this->post('/tasks', [
            'title' => 'Tarea de prueba',
            'status' => 'estado_invalido',
            'priority' => 'media',
        ]);

        $response->assertSessionHasErrors('status');
    }

    /** @test */
    public function crear_tarea_requiere_prioridad_valida()
    {
        $this->actingAs($this->user);

        $response = $this->post('/tasks', [
            'title' => 'Tarea de prueba',
            'status' => 'pendiente',
            'priority' => 'prioridad_invalida',
        ]);

        $response->assertSessionHasErrors('priority');
    }

    /** @test */
    public function usuarios_pueden_editar_sus_propias_tareas()
    {
        $this->actingAs($this->user);
        
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Título Original',
        ]);

        $response = $this->get("/tasks/{$task->id}/edit");
        
        $response->assertStatus(200);
        $response->assertViewIs('tasks.edit');
    }

    /** @test */
    public function usuarios_pueden_actualizar_sus_propias_tareas()
    {
        $this->actingAs($this->user);
        
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Título Original',
        ]);

        $updatedData = [
            'title' => 'Título Actualizado',
            'description' => 'Descripción actualizada',
            'status' => 'completada',
            'priority' => 'baja',
        ];

        $response = $this->put("/tasks/{$task->id}", $updatedData);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Título Actualizado',
        ]);
    }

    /** @test */
    public function usuarios_pueden_eliminar_sus_propias_tareas()
    {
        $this->actingAs($this->user);
        
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function usuarios_no_pueden_ver_tareas_de_otros_usuarios()
    {
        $this->actingAs($this->user);
        
        $otherUser = User::factory()->create();
        $otherTask = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->get("/tasks/{$otherTask->id}/edit");
        
        $response->assertStatus(404);
    }

    /** @test */
    public function usuarios_pueden_buscar_tareas()
    {
        $this->actingAs($this->user);
        
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Tarea específica para buscar',
        ]);
        
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Otra tarea diferente',
        ]);

        $response = $this->get('/tasks?search=específica');
        
        $response->assertStatus(200);
        $response->assertSee('Tarea específica para buscar');
        $response->assertDontSee('Otra tarea diferente');
    }

    /** @test */
    public function usuarios_pueden_filtrar_tareas_por_estado()
    {
        $this->actingAs($this->user);
        
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Tarea Pendiente',
            'status' => 'pendiente',
        ]);
        
        Task::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Tarea Completada',
            'status' => 'completada',
        ]);

        $response = $this->get('/tasks?status=pendiente');
        
        $response->assertStatus(200);
        $response->assertSee('Tarea Pendiente');
        $response->assertDontSee('Tarea Completada');
    }

    /** @test */
    public function fecha_limite_no_puede_ser_anterior_a_hoy()
    {
        $this->actingAs($this->user);

        $response = $this->post('/tasks', [
            'title' => 'Tarea con fecha pasada',
            'status' => 'pendiente',
            'priority' => 'media',
            'due_date' => now()->subDays(1)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('due_date');
    }
}
