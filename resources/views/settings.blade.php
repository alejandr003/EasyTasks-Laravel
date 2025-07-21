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
                    <a href="{{ route('tasks.index') }}" class="nav-link d-flex align-items-center py-2 px-3" style="color: #666;">
                        <i class="bi bi-list-check me-2"></i> Tareas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings') }}" class="nav-link d-flex align-items-center py-2 px-3 active" style="color: #4F46E5;">
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
            <h4 class="m-0 fw-bold">Configuración</h4>
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
        
        <!-- Settings Content -->
        <div class="p-4">
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
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Información del perfil</h5>
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ auth()->user()->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ auth()->user()->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary" style="background-color: #4F46E5; border-color: #4F46E5;">Guardar cambios</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Cambiar contraseña</h5>
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Contraseña actual</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nueva contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                                <button type="submit" class="btn btn-primary" style="background-color: #4F46E5; border-color: #4F46E5;">Actualizar contraseña</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Preferencias</h5>
                            <form action="{{ route('preferences.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notifications" name="notifications" 
                                        {{ auth()->user()->userPreference && auth()->user()->userPreference->notifications ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notifications">Notificaciones por email</label>
                                </div>
                                <div class="mb-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="dark_mode" name="dark_mode" 
                                        {{ auth()->user()->userPreference && auth()->user()->userPreference->dark_mode ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dark_mode">Modo oscuro</label>
                                </div>
                                <button type="submit" class="btn btn-primary" style="background-color: #4F46E5; border-color: #4F46E5;">Guardar preferencias</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Estadísticas</h5>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Tareas completadas:</span>
                                <span class="badge bg-success">{{ \App\Models\Task::where('user_id', auth()->id())->where('status', 'completada')->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Tareas pendientes:</span>
                                <span class="badge" style="background-color: #fbbf24;">{{ \App\Models\Task::where('user_id', auth()->id())->where('status', 'pendiente')->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Total de tareas:</span>
                                <span class="badge bg-primary">{{ \App\Models\Task::where('user_id', auth()->id())->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
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
