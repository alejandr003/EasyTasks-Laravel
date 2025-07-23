<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuarios_autenticados_pueden_acceder_al_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /** @test */
    public function usuarios_no_autenticados_son_redirigidos_al_login()
    {
        $response = $this->get('/dashboard');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function dashboard_muestra_informacion_del_usuario()
    {
        $user = User::factory()->create(['name' => 'Test User']);
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        
        $response->assertSee('Test User');
    }
}
