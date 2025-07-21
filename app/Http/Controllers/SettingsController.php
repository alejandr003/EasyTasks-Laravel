<?php

namespace App\Http\Controllers;

use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SettingsController extends Controller
{
    /**
     * Muestra la página de configuración.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('settings');
    }

    /**
     * Actualiza la información del perfil del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('settings')->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Actualiza la contraseña del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('settings')->with('success', 'Contraseña actualizada exitosamente.');
    }

    /**
     * Actualiza las preferencias del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePreferences(Request $request)
    {
        $preferences = [
            'notifications' => $request->has('notifications'),
            'dark_mode' => $request->has('dark_mode'),
        ];

        // Buscar o crear las preferencias del usuario
        UserPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            $preferences
        );

        return redirect()->route('settings')->with('success', 'Preferencias actualizadas exitosamente.');
    }
}
