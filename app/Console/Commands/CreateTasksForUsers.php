<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTasksForUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-tasks-for-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea tareas de ejemplo para usuarios que no tienen';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando tareas para los usuarios...');
        
        $users = \App\Models\User::whereDoesntHave('tasks')->get();
        $created = 0;
        
        foreach ($users as $user) {
            // Crear 3 tareas pendientes
            for ($i = 1; $i <= 3; $i++) {
                \App\Models\Task::create([
                    'user_id' => $user->id,
                    'title' => "Tarea pendiente $i para {$user->name}",
                    'description' => "Esta es una descripción de la tarea pendiente $i",
                    'status' => 'pendiente',
                    'priority' => ['baja', 'media', 'alta'][rand(0, 2)],
                    'due_date' => now()->addDays(rand(1, 14))
                ]);
                $created++;
            }
            
            // Crear 2 tareas completadas
            for ($i = 1; $i <= 2; $i++) {
                \App\Models\Task::create([
                    'user_id' => $user->id,
                    'title' => "Tarea completada $i para {$user->name}",
                    'description' => "Esta es una descripción de la tarea completada $i",
                    'status' => 'completada',
                    'priority' => ['baja', 'media', 'alta'][rand(0, 2)],
                    'due_date' => now()->subDays(rand(1, 7))
                ]);
                $created++;
            }
            
            $this->info("Se crearon 5 tareas para el usuario: {$user->name} ({$user->email})");
        }
        
        $this->info("Total de tareas creadas: $created");
    }
}
