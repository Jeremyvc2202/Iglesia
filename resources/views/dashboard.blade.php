@extends('layouts.app')

@section('title', 'Mi cuenta - Iglesia El Cordero De Dios En El Perú.')

@section('content')

    <div class="max-w-lg mx-auto text-center bg-navy2 border border-gold/20 rounded-xl p-8">
        <span class="text-gold text-3xl">✝</span>
        <h1 class="font-serif text-2xl text-gold mt-3 mb-2">
            ¡Bienvenido(a), {{ auth()->user()->name }}!
        </h1>
        <p class="text-gray-400 text-sm">
            Has ingresado como miembro de la iglesia. Pronto agregaremos aquí contenido exclusivo para la congregación.
        </p>
    </div>

@endsection
