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
                    <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center py-2 px-3" style="color: #666;">
                        <i class="bi bi-house-door me-2"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}" class="nav-link d-flex align-items-center py-2 px-3 active" style="color: #4F46E5;">
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
    <div class="main-content" style="margin-left: 250px; width: calc(100% - 250px); background: #f8fafc; min-height: 100vh;">
        <!-- Top Navigation -->
        <div class="bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 fw-bold">Todas las tareas</h4>
            <div class="d-flex align-items-center">
                <a href="{{ route('tasks.index') }}?status=pendiente" class="btn btn-sm me-2 position-relative" style="background: none; border: none;" title="Ver tareas pendientes">
                    <i class="bi bi-bell fs-5"></i>
                    @php
                        $pendingCount = \App\Models\Task::where('user_id', auth()->id())->where('status', 'pendiente')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $pendingCount > 9 ? '9+' : $pendingCount }}
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
        
        <!-- Tasks List -->
        <div class="p-4" style="height: 100vh; padding-bottom: 2rem !important;">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap">
                <form action="{{ route('tasks.search') }}" method="GET" class="input-group mb-3 mb-md-0" style="max-width: 400px;">
                    <input type="text" name="search" class="form-control" placeholder="Buscar tareas" value="{{ request('search') }}">
                    <button class="btn btn-light border" type="submit"><i class="bi bi-search"></i></button>
                </form>
                
                <div class="d-flex gap-2">
                    <div class="dropdown me-2">
                        <button class="btn btn-light dropdown-toggle" type="button" id="statusFilter" data-bs-toggle="dropdown" aria-expanded="false">
                            Estado: {{ request('status') ? (request('status') == 'completada' ? 'Completadas' : 'Pendientes') : 'Todos' }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="statusFilter">
                            <li><a class="dropdown-item" href="{{ route('tasks.index') }}">Todos</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.index', ['status' => 'pendiente', 'search' => request('search'), 'priority' => request('priority')]) }}">Pendientes</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.index', ['status' => 'completada', 'search' => request('search'), 'priority' => request('priority')]) }}">Completadas</a></li>
                        </ul>
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="priorityFilter" data-bs-toggle="dropdown" aria-expanded="false">
                            Prioridad: {{ request('priority') ? ucfirst(request('priority')) : 'Todas' }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="priorityFilter">
                            <li><a class="dropdown-item" href="{{ route('tasks.index', ['status' => request('status'), 'search' => request('search')]) }}">Todas</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.index', ['priority' => 'baja', 'status' => request('status'), 'search' => request('search')]) }}">Baja</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.index', ['priority' => 'media', 'status' => request('status'), 'search' => request('search')]) }}">Media</a></li>
                            <li><a class="dropdown-item" href="{{ route('tasks.index', ['priority' => 'alta', 'status' => request('status'), 'search' => request('search')]) }}">Alta</a></li>
                        </ul>
                    </div>
                    
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="background-color: #4F46E5; border-color: #4F46E5;">
                        Nueva tarea
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm tasks-container">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Título</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Prioridad</th>
                                    <th scope="col">Fecha límite</th>
                                    <th scope="col" class="text-center" style="width: 300px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>
                                        @if($task->status == 'completada')
                                        <span class="badge bg-success">Completada</span>
                                        @else
                                        <span class="badge" style="background-color: #fbbf24;">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->priority == 'alta')
                                            <span class="badge bg-danger">Alta</span>
                                        @elseif($task->priority == 'media')
                                            <span class="badge bg-warning text-dark">Media</span>
                                        @else
                                            <span class="badge bg-info text-dark">Baja</span>
                                        @endif
                                    </td>
                                    <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center align-items-center flex-wrap">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-action btn-secondary dropdown-toggle" type="button" id="statusDropdown{{ $task->id }}" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="true">
                                                    Estado
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="statusDropdown{{ $task->id }}">
                                                    <li>
                                                        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="title" value="{{ $task->title }}">
                                                            <input type="hidden" name="description" value="{{ $task->description }}">
                                                            <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                            <input type="hidden" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                                                            <input type="hidden" name="status" value="completada">
                                                            <button type="submit" class="dropdown-item {{ $task->status == 'completada' ? 'active' : '' }}">
                                                                Completada
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="title" value="{{ $task->title }}">
                                                            <input type="hidden" name="description" value="{{ $task->description }}">
                                                            <input type="hidden" name="priority" value="{{ $task->priority }}">
                                                            <input type="hidden" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                                                            <input type="hidden" name="status" value="pendiente">
                                                            <button type="submit" class="dropdown-item {{ $task->status == 'pendiente' ? 'active' : '' }}">
                                                                Pendiente
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary btn-action">
                                                Editar
                                            </a>
                                            
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-action">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No hay tareas disponibles.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($tasks->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $tasks->withQueryString()->links() }}
                </div>
            @endif
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
    .pagination .page-item.active .page-link {
        background-color: #4F46E5;
        border-color: #4F46E5;
    }
    .pagination .page-link {
        color: #4F46E5;
    }
    .btn-action {
        min-width: 80px;
        padding: 6px 12px;
        font-size: 0.875rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        white-space: nowrap;
        text-align: center;
    }
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .dropdown-item.active {
        background-color: #e9ecef;
        font-weight: bold;
    }
    .card {
        min-height: 85vh;
        height: 85vh;
    }
    .table-responsive {
        min-height: 80vh;
        height: 80vh;
        overflow-y: auto;
    }
    .dropdown-menu {
        z-index: 1050;
    }
    .table tbody tr {
        height: 60px;
    }
    .table tbody td {
        vertical-align: middle;
        padding: 12px 8px;
    }
    .table {
        height: 100%;
    }
    .table tbody {
        height: 100%;
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    .card-body {
        padding: 0 !important;
        height: 100%;
    }
    .tasks-container {
        height: calc(100vh - 200px);
        min-height: 600px;
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
