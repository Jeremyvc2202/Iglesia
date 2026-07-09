<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Página de bienvenida para miembros autenticados.
     */
    public function index()
    {
        return view('dashboard');
    }
}
