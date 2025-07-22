<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required', 
                'email',
                'max:255'
            ],
            'password' => [
                'required',
                'string'
            ],
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El formato del email no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentar autenticar con límite de intentos
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Limpiar intentos fallidos
            session()->forget('login_attempts');
            
            return redirect()->intended('/dashboard')->with('success', '¡Bienvenido de vuelta!');
        }

        // Contar intentos fallidos
        $attempts = session('login_attempts', 0) + 1;
        session(['login_attempts' => $attempts]);
        
        // Bloquear después de 5 intentos
        if ($attempts >= 5) {
            return back()->withErrors([
                'email' => 'Demasiados intentos fallidos. Intenta más tarde.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
