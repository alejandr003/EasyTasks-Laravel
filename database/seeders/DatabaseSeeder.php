<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\UserPreference;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario de prueba
        $user = User::factory()->create([
            'name' => 'Usuario Demo',
            'email' => 'demo@example.com',
        ]);
        
        // Crear preferencias para el usuario
        UserPreference::create([
            'user_id' => $user->id,
            'notifications' => true,
            'dark_mode' => false,
        ]);
        
        // Crear tareas para el usuario
        Task::factory()->count(5)->create([
            'user_id' => $user->id,
            'status' => 'completada',
        ]);
        
        Task::factory()->count(3)->create([
            'user_id' => $user->id,
            'status' => 'pendiente',
        ]);
    }
}
