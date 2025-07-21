<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreatePreferencesForUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-preferences-for-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea preferencias para todos los usuarios que no las tengan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creando preferencias para los usuarios...');
        
        $users = \App\Models\User::whereDoesntHave('userPreference')->get();
        $created = 0;
        
        foreach ($users as $user) {
            \App\Models\UserPreference::create([
                'user_id' => $user->id,
                'notifications' => true,
                'dark_mode' => false
            ]);
            $created++;
            $this->info("Preferencias creadas para el usuario: {$user->name} ({$user->email})");
        }
        
        $this->info("Total de preferencias creadas: $created");
    }
}
