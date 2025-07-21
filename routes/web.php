<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación personalizadas
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Ruta para mostrar el formulario de recuperación de contraseña
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// Ruta para enviar el email de recuperación (simulada, solo muestra mensaje)
Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    // Aquí normalmente se enviaría el email
    return back()->with('status', 'Si el correo existe, se ha enviado un enlace de recuperación.');
})->middleware('guest')->name('password.email');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tareas
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
    
    // Configuración
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    
    // Perfil
    Route::put('/profile/update', [SettingsController::class, 'updateProfile'])->name('profile.update');
    
    // Contraseña
    Route::put('/password/update', [SettingsController::class, 'updatePassword'])->name('password.update');
    
    // Preferencias
    Route::put('/preferences/update', [SettingsController::class, 'updatePreferences'])->name('preferences.update');
});
