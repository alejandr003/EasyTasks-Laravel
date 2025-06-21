@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100" style="background: #f8f9fa;">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%; border-radius: 18px;">
        <div class="text-center mb-4">
            <img src="{{ asset('resources/Assets/logo.png') }}" alt="Logo" class="rounded-circle mb-2" style="width: 60px; height: 60px; background: #4F46E5; padding: 10px;">
            <h3 class="fw-bold mt-2">EasyTasks</h3>
            <div class="text-muted" style="font-size: 15px;">Gestor de Actividades</div>
        </div>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="usuario@ejemplo.com" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background: #4F46E5; border: none;">Enviar enlace de recuperación</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="small" style="color: #4F46E5;">Volver al login</a>
        </div>
    </div>
</div>
@endsection
