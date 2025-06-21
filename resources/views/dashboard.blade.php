@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow p-4 text-center">
        <h2 class="fw-bold mb-3">Bienvenido a tu Dashboard</h2>
        <p class="mb-4">Has iniciado sesión correctamente.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
        </form>
    </div>
</div>
@endsection
