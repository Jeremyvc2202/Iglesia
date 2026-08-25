@extends('layouts.app')

@section('title', 'Mi cuenta - Iglesia El Cordero De Dios En El Perú.')

@section('content')

    <div class="max-w-lg mx-auto text-center clay-panel rounded-3xl p-8 sm:p-10">
        <div class="ornament mb-6">
            <span class="font-display text-2xl">✝</span>
        </div>
        <h1 class="font-display text-3xl text-dynamic-gradient mb-3">
            ¡Bienvenido(a), {{ auth()->user()->name }}!
        </h1>
        <p class="text-ink/60 text-sm leading-relaxed max-w-sm mx-auto">
            Has ingresado como miembro de la iglesia. Pronto agregaremos aquí contenido exclusivo para la congregación.
        </p>
    </div>

@endsection
