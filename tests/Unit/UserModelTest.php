<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_tener_muchas_tareas()
    {
        $user = User::factory()->create();
        
        // Crear tareas para el usuario
        $user->tasks()->createMany([
            [
                'title' => 'Tarea 1',
                'status' => 'pendiente',
                'priority' => 'alta',
            ],
            [
                'title' => 'Tarea 2',
                'status' => 'completada',
                'priority' => 'media',
            ],
        ]);

        $this->assertCount(2, $user->tasks);
    }

    /** @test */
    public function usuario_tiene_atributos_correctos()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ];

        $user = User::factory()->create($userData);

        $this->assertEquals($userData['name'], $user->name);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertTrue(password_verify('password123', $user->password));
    }

    /** @test */
    public function usuario_tiene_campos_fillable_correctos()
    {
        $expectedFillable = [
            'name',
            'email',
            'password',
        ];

        $user = new User();
        
        $this->assertEquals($expectedFillable, $user->getFillable());
    }

    /** @test */
    public function usuario_tiene_campos_hidden_correctos()
    {
        $expectedHidden = [
            'password',
            'remember_token',
        ];

        $user = new User();
        
        $this->assertEquals($expectedHidden, $user->getHidden());
    }

    /** @test */
    public function email_es_unico_en_la_base_de_datos()
    {
        User::factory()->create(['email' => 'test@example.com']);
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        User::factory()->create(['email' => 'test@example.com']);
    }
}
