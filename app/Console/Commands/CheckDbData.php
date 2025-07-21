<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckDbData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-db-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica los datos en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Verificando datos en la base de datos:');
        
        $userCount = \App\Models\User::count();
        $taskCount = \App\Models\Task::count();
        $prefCount = \App\Models\UserPreference::count();
        
        $this->info("Usuarios: $userCount");
        $this->info("Tareas: $taskCount");
        $this->info("Preferencias: $prefCount");
        
        $user = \App\Models\User::first();
        if ($user) {
            $this->info("\nDetalles del primer usuario:");
            $this->info("Nombre: {$user->name}");
            $this->info("Email: {$user->email}");
            
            $userTasks = $user->tasks()->count();
            $this->info("Tareas del usuario: $userTasks");
            
            $userPref = $user->userPreference;
            $this->info("Preferencias del usuario: " . ($userPref ? "Configuradas" : "No configuradas"));
            
            if ($userPref) {
                $this->info("Notificaciones: " . ($userPref->notifications ? "Sí" : "No"));
                $this->info("Modo oscuro: " . ($userPref->dark_mode ? "Sí" : "No"));
            }
        }
    }
}
