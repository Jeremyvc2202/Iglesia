@extends('layouts.app')

@section('title', 'Editar Anuncio')

@section('content')

    <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-bronze mb-3">Panel interno</p>
    <h1 class="font-display text-3xl text-ink mb-10">Editar anuncio</h1>

    <form action="{{ route('anuncios.update', $anuncio) }}" method="POST" enctype="multipart/form-data" class="max-w-xl">
        @csrf
        @method('PUT')
        @include('anuncios._form')

        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn btn-primary px-6 py-2.5 rounded font-medium text-sm">
                Actualizar anuncio
            </button>
            <a href="{{ route('anuncios.admin') }}" class="btn btn-ghost px-6 py-2.5 rounded text-sm">
                Cancelar
            </a>
        </div>
    </form>

@endsection