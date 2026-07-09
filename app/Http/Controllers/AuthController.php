<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de acceso.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('anuncios.admin');
        }

        return view('auth.login');
    }

    /**
     * Procesa el intento de acceso.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('anuncios.admin'));
        }

        return back()->withErrors([
            'email' => 'Correo o Contraseña incorrecta.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del vocal.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('anuncios.index');
    }
}