<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard del usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Total de tareas del usuario
        $totalTasks = Task::where('user_id', Auth::id())->count();
        
        // Tareas completadas
        $completedTasks = Task::where('user_id', Auth::id())
                            ->where('status', 'completada')
                            ->count();
        
        // Tareas pendientes
        $pendingTasks = Task::where('user_id', Auth::id())
                            ->where('status', 'pendiente')
                            ->count();
        
        // Últimas tareas agregadas
        $latestTasks = Task::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
        
        return view('dashboard', compact('totalTasks', 'completedTasks', 'pendingTasks', 'latestTasks'));
    }
}
