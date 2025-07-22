@extends('layouts.app')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-custom px-3" style="min-height: 48px; padding-top: 4px; padding-bottom: 4px;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="navbar-logo" style="width:32px; height:32px;">
                <span class="fw-bold" style="color:#22223B; font-size: 18px;">EasyTask</span>
            </a>
        </div>
    </nav>
<div class="container d-flex align-items-center justify-content-center min-vh-100" style="background: #f8f9fa;">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%; border-radius: 18px;">
        <div class="text-center mb-4">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="rounded-circle mb-2" style="width: 60px; height: 60px; background: #4F46E5; padding: 10px;">
            <h3 class="fw-bold mt-2">EasyTasks</h3>
            <div class="text-muted" style="font-size: 15px;">Gestor de Actividades</div>
        </div>
        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" 
                       value="{{ old('email') }}" 
                       placeholder="usuario@ejemplo.com" 
                       required autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" 
                           placeholder="Tu contraseña" 
                           required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background: #4F46E5; border: none;">Iniciar Sesión</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="small" style="color: #4F46E5;">Crear cuenta</a>
        </div>
        
        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="small" style="color: #4F46E5;">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>

<script>
    // Script para mostrar/ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.className = 'fas fa-eye-slash';
        } else {
            passwordField.type = 'password';
            eyeIcon.className = 'fas fa-eye';
        }
    });
</script>
@endsection
