@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-white shadow-sm" style="width: 250px; min-height: 100vh; position: fixed; left: 0;">
        <div class="p-3 border-bottom d-flex align-items-center">
            <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 30px; height: 30px;" class="me-2">
            <span class="fw-bold fs-5">EasyTasks</span>
        </div>
        <div class="p-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center py-2 px-3 active" style="color: #4F46E5;">
                        <i class="bi bi-house-door me-2"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}" class="nav-link d-flex align-items-center py-2 px-3" style="color: #666;">
                        <i class="bi bi-list-check me-2"></i> Tareas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings') }}" class="nav-link d-flex align-items-center py-2 px-3" style="color: #666;">
                        <i class="bi bi-gear me-2"></i> Configuración
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" style="margin-left: 250px; width: calc(100% - 250px); background: #f8fafc;">
        <!-- Top Navigation -->
        <div class="bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 fw-bold">Gestor de Tareas</h4>
            <div class="d-flex align-items-center">
                <a href="{{ route('tasks.index') }}?status=pendiente" class="btn btn-sm me-2 position-relative" style="background: none; border: none;" title="Ver tareas pendientes">
                    <i class="bi bi-bell fs-5"></i>
                    @if($pendingTasks > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $pendingTasks > 9 ? '9+' : $pendingTasks }}
                        </span>
                    @endif
                </a>
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none;">
                        <img src="{{ asset('https://ui-avatars.com/api/?name=' . auth()->user()->name . '&background=4F46E5&color=fff') }}" alt="User" class="rounded-circle" style="width: 36px; height: 36px;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('settings') }}">Mi perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Dashboard Content -->
        <div class="p-4">
            <!-- Mensajes de alerta -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Stat Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="text-muted mb-1 small">Total de tareas</p>
                            <h3 class="fw-bold mb-0">{{ $totalTasks }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="text-muted mb-1 small">Tareas completadas</p>
                            <h3 class="fw-bold mb-0">{{ $completedTasks }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <p class="text-muted mb-1 small">Tareas pendientes</p>
                            <h3 class="fw-bold mb-0">{{ $pendingTasks }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Latest Tasks -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Últimas Tareas</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($latestTasks as $task)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-decoration-none text-dark">{{ $task->title }}</a>
                                    <span class="ms-2 badge {{ $task->status == 'completada' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $task->status == 'completada' ? 'Completada' : 'Pendiente' }}
                                    </span>
                                </div>
                                <div class="d-flex">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-light me-1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light" 
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item px-0">No hay tareas registradas</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="text-end">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="background-color: #4F46E5; border-color: #4F46E5;">Nueva tarea</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    body {
        background-color: #f8fafc;
    }
    .nav-link.active {
        background-color: rgba(79, 70, 229, 0.1);
        border-radius: 6px;
    }
    .nav-link:hover {
        background-color: rgba(79, 70, 229, 0.05);
        border-radius: 6px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-dismiss para las alertas después de 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush
