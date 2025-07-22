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
            <img src="{{ asset('resources/Assets/logo.png') }}" alt="Logo" class="rounded-circle mb-2" style="width: 60px; height: 60px; background: #4F46E5; padding: 10px;">
            <h3 class="fw-bold mt-2">EasyTasks</h3>
            <div class="text-muted" style="font-size: 15px;">Gestor de Actividades</div>
        </div>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

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

        <form method="POST" action="{{ route('password.email') }}">
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
            <button type="submit" class="btn btn-primary w-100" style="background: #4F46E5; border: none;">Enviar enlace de recuperación</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="small" style="color: #4F46E5;">Volver al login</a>
        </div>
    </div>
</div>
@endsection
