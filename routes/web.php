<?php

use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CultoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Página principal: muestra los anuncios y cultos activos
Route::get('/', [AnuncioController::class, 'index'])->name('anuncios.index');

// Acceso de miembros
Route::get('/acceder', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/acceder', [AuthController::class, 'login'])->name('login.submit');
Route::post('/salir', [AuthController::class, 'logout'])->name('logout');

// Área de miembros
Route::middleware('auth')->group(function () {
    Route::get('/panel', [DashboardController::class, 'index'])->name('dashboard');

    // Administración
    Route::prefix('admin')->group(function () {
        // Gestión de Anuncios
        Route::get('/anuncios', [AnuncioController::class, 'admin'])->name('anuncios.admin');
        Route::get('/anuncios/crear', [AnuncioController::class, 'create'])->name('anuncios.create');
        Route::post('/anuncios', [AnuncioController::class, 'store'])->name('anuncios.store');
        Route::get('/anuncios/{anuncio}/editar', [AnuncioController::class, 'edit'])->name('anuncios.edit');
        Route::put('/anuncios/{anuncio}', [AnuncioController::class, 'update'])->name('anuncios.update');
        Route::delete('/anuncios/{anuncio}', [AnuncioController::class, 'destroy'])->name('anuncios.destroy');
        Route::post('/anuncios/{anuncio}/toggle', [AnuncioController::class, 'toggle'])->name('anuncios.toggle');
        
        // Gestión de Cultos (Idéntico a Anuncios)
        Route::get('/cultos/crear', [CultoController::class, 'create'])->name('cultos.create');
        Route::post('/cultos', [CultoController::class, 'store'])->name('cultos.store');
        Route::get('/cultos/{culto}/editar', [CultoController::class, 'edit'])->name('cultos.edit');
        Route::put('/cultos/{culto}', [CultoController::class, 'update'])->name('cultos.update');
        Route::delete('/cultos/{culto}', [CultoController::class, 'destroy'])->name('cultos.destroy');
        Route::post('/cultos/{culto}/toggle', [CultoController::class, 'toggle'])->name('cultos.toggle');
    });
});

// =========================================================
// RUTA TEMPORAL PARA REPARAR LA BASE DE DATOS EN RENDER
// =========================================================
Route::get('/forzar-migracion-secreta', function() {
    try {
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('migrate', ['--force' => true]);
        
        return "¡Éxito! Caché limpia y base de datos migrada correctamente.";
    } catch (\Exception $e) {
        return "Hubo un error al ejecutar los comandos: " . $e->getMessage();
    }
});