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
    <div class="main-content" style="margin-left: 250px; width: calc(100% - 250px); background: #f8fafc;">
        <!-- Top Navigation -->
        <div class="bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 fw-bold">Editar tarea</h4>
            <div class="d-flex align-items-center">
                <button class="btn btn-sm me-2 position-relative" style="background: none; border: none;">
                    <i class="bi bi-bell fs-5"></i>
                </button>
                <div class="dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none;">
                        <img src="{{ asset('https://ui-avatars.com/api/?name=' . auth()->user()->name . '&background=4F46E5&color=fff') }}" alt="User" class="rounded-circle" style="width: 36px; height: 36px;">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">Mi perfil</a></li>
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
        
        <!-- Edit Task Form -->
        <div class="p-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ isset($task) ? route('tasks.update', $task->id) : '#' }}" method="POST">
                                @csrf
                                @if(isset($task))
                                    @method('PUT')
                                @endif
                                <div class="mb-3">
                                    <label for="title" class="form-label">Título de la tarea</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $task->title ?? old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">Estado</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                        <option value="pendiente" {{ (isset($task) && $task->status == 'pendiente') || old('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completada" {{ (isset($task) && $task->status == 'completada') || old('status') == 'completada' ? 'selected' : '' }}>Completada</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Prioridad</label>
                                    <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority">
                                        <option value="baja" {{ (isset($task) && $task->priority == 'baja') || old('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                                        <option value="media" {{ (isset($task) && $task->priority == 'media') || old('priority') == 'media' ? 'selected' : '' }}>Media</option>
                                        <option value="alta" {{ (isset($task) && $task->priority == 'alta') || old('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ $task->description ?? old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Fecha límite</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : old('due_date') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('tasks.index') }}" class="btn btn-light">Cancelar</a>
                                    @if(isset($task))
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTaskModal">
                                        Eliminar tarea
                                    </button>
                                    @endif
                                    <button type="submit" class="btn btn-primary" style="background-color: #4F46E5; border-color: #4F46E5;">Actualizar tarea</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($task))
<!-- Delete Task Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteTaskModalLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que quieres eliminar esta tarea? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar tarea</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endif

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
