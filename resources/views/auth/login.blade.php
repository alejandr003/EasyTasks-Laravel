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
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="usuario@ejemplo.com" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
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
@endsection
