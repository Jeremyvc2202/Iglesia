@extends('layouts.app')

@section('title', 'Panel Administrativo')

@section('content')

    {{-- CÁLCULO DEL SALUDO TEMPORAL --}}
    @php
        $hora = date('H');
        if ($hora >= 5 && $hora < 12) {
            $saludo = '¡Buenos días!';
        } elseif ($hora >= 12 && $hora < 19) {
            $saludo = '¡Buenas tardes!';
        } else {
            $saludo = '¡Buenas noches!';
        }
    @endphp

    <!-- Encabezado del Panel -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-16">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="w-8 h-px bg-bronze/50"></span>
                <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-bronze font-bold">Panel administrativo</p>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl text-ink text-dynamic-gradient inline-block">Panel de Control</h1>
            
            <p class="text-xs text-ink/50 font-body mt-1.5 flex items-center gap-1.5">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-pine animate-pulse"></span>
                {{ $saludo }} Conectado al sistema de gestión.
            </p>
        </div>
    </div>

    <!-- SECCIÓN 1: CULTOS -->
    <section class="mb-20">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-display text-2xl text-ink">Gestión de Cultos</h2>
            <a href="{{ route('cultos.create') }}"
               class="px-5 py-2.5 rounded-lg font-mono text-[11px] font-bold tracking-widest uppercase text-parchment shadow-md transition-all hover:scale-105"
               style="background: linear-gradient(90deg, #7A2331, #A97C50, #7A2331);">
                  + Nuevo culto
            </a>
        </div>
        
        <div class="bg-parchment2/30 backdrop-blur-sm border border-hairline/60 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[700px]">
                    <thead>
                        <tr class="border-b border-hairline/80 bg-parchment2/50">
                            <th class="px-6 py-5 text-left font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Imagen</th>
                            <th class="px-6 py-5 text-left font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Culto</th>
                            <th class="px-6 py-5 text-left font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Horario</th>
                            <th class="px-6 py-5 text-left font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Estado</th>
                            <th class="px-6 py-5 text-right font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-hairline/50">
                        @php
                            $cultosOrdenados = $cultos->sortBy(function ($culto) {
                                $texto = mb_strtolower($culto->nombre . ' ' . $culto->horario);
                                if (str_contains($texto, 'lunes')) return 1;
                                if (str_contains($texto, 'martes')) return 2;
                                if (str_contains($texto, 'miercoles') || str_contains($texto, 'miércoles')) return 3;
                                if (str_contains($texto, 'jueves')) return 4;
                                if (str_contains($texto, 'viernes')) return 5;
                                if (str_contains($texto, 'sabado') || str_contains($texto, 'sábado')) return 6;
                                if (str_contains($texto, 'domingo')) return 7;
                                return 8;
                            });
                        @endphp

                        @foreach ($cultosOrdenados as $culto)
                            <tr class="hover:bg-parchment/70 transition-colors">
                                <td class="px-6 py-4">
                                    @if ($culto->imagen)
                                        <img src="{{ str_starts_with($culto->imagen, 'http') ? $culto->imagen : asset('storage/' . $culto->imagen) }}" 
                                             alt="Imagen" 
                                             class="w-12 h-12 object-cover rounded-lg border border-hairline/60">
                                    @else
                                        <div class="w-12 h-12 rounded-lg border border-dashed border-hairline/80 bg-parchment2/40 flex items-center justify-center text-ink/20 text-[10px]">--</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-semibold text-ink">{{ $culto->nombre }}</td>
                                <td class="px-6 py-4 text-ink/60 font-mono text-xs">{{ $culto->horario }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('cultos.toggle', $culto) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full border {{ $culto->activo ? 'bg-pine/10 text-pine border-pine/20' : 'bg-ink/5 text-ink/60 border-ink/10' }}">
                                            {{ $culto->activo ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('cultos.edit', $culto) }}" class="text-bronze font-bold text-[11px] hover:underline uppercase inline-block">Editar</a>
                                    
                                    <form action="{{ route('cultos.destroy', $culto) }}" method="POST" class="form-eliminar inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 font-bold text-[11px] hover:underline uppercase">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-hairline/60 bg-parchment2/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="font-mono text-xs text-ink/60">
                    @if(method_exists($cultos, 'firstItem'))
                        Mostrando <span class="font-bold text-ink">{{ $cultos->firstItem() ?? 0 }}-{{ $cultos->lastItem() ?? 0 }}</span> de <span class="font-bold text-ink">{{ $cultos->total() }}</span> registros
                    @else
                        Mostrando <span class="font-bold text-ink">{{ count($cultos) }}</span> registros en total
                    @endif
                </div>
                
                <div class="flex items-center gap-2">
                    @if(method_exists($cultos, 'links'))
                        {!! $cultos->links('vendor.pagination.simple-tailwind') !!}
                    @else
                        <span class="text-xs font-mono text-ink/40 mr-2">Página 1 de 1</span>
                        <button disabled class="p-1.5 rounded-lg border border-hairline/40 text-ink/30 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        <button disabled class="p-1.5 rounded-lg border border-hairline/40 text-ink/30 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <hr class="border-hairline/50 my-20">

    <!-- SECCIÓN 2: ANUNCIOS -->
    <section class="mb-20">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-display text-2xl text-ink">Gestión de Anuncios</h2>
            <a href="{{ route('anuncios.create') }}"
               class="px-5 py-2.5 rounded-lg font-mono text-[11px] font-bold tracking-widest uppercase text-parchment shadow-md transition-all hover:scale-105"
               style="background: linear-gradient(90deg, #7A2331, #A97C50, #7A2331);">
                  + Nuevo anuncio
            </a>
        </div>

        <div class="bg-parchment2/30 backdrop-blur-sm border border-hairline/60 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[700px]">
                    <thead>
                        <tr class="border-b border-hairline/80 bg-parchment2/50">
                            <th class="px-6 py-5 text-left font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Imagen</th>
                            <th class="px-6 py-5 text-left font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Título</th>
                            <th class="px-6 py-5 text-left font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Fecha</th>
                            <th class="px-6 py-5 text-left font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Estado</th>
                            <th class="px-6 py-5 text-right font-mono text-[11px] font-bold uppercase tracking-widest text-ink/60">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-hairline/50">
                        @foreach ($anuncios as $anuncio)
                            <tr class="hover:bg-parchment/70 transition-colors">
                                <td class="px-6 py-4">
                                    @if ($anuncio->imagen)
                                        <img src="{{ str_starts_with($anuncio->imagen, 'http') ? $anuncio->imagen : asset('storage/' . $anuncio->imagen) }}" 
                                             alt="Imagen" 
                                             class="w-12 h-12 object-cover rounded-lg border border-hairline/60">
                                    @else
                                        <div class="w-12 h-12 rounded-lg border border-dashed border-hairline/80 bg-parchment2/40 flex items-center justify-center text-ink/20 text-[10px]">--</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-semibold text-ink">{{ $anuncio->titulo }}</td>
                                <td class="px-6 py-4 text-ink/60 font-mono text-xs">{{ $anuncio->fecha_evento?->format('d/m/Y') ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('anuncios.toggle', $anuncio) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full border {{ $anuncio->activo ? 'bg-pine/10 text-pine border-pine/20' : 'bg-ink/5 text-ink/60 border-ink/10' }}">
                                            {{ $anuncio->activo ? 'Activo' : 'Inactivo' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('anuncios.edit', $anuncio) }}" class="text-bronze font-bold text-[11px] hover:underline uppercase inline-block">Editar</a>
                                    
                                    <form action="{{ route('anuncios.destroy', $anuncio) }}" method="POST" class="form-eliminar inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 font-bold text-[11px] hover:underline uppercase">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-hairline/60 bg-parchment2/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="font-mono text-xs text-ink/60">
                    @if(method_exists($anuncios, 'firstItem'))
                        Mostrando <span class="font-bold text-ink">{{ $anuncios->firstItem() ?? 0 }}-{{ $anuncios->lastItem() ?? 0 }}</span> de <span class="font-bold text-ink">{{ $anuncios->total() }}</span> registros
                    @else
                        Mostrando <span class="font-bold text-ink">{{ count($anuncios) }}</span> registros en total
                    @endif
                </div>
                
                <div class="flex items-center gap-2">
                    @if(method_exists($anuncios, 'links'))
                        {!! $anuncios->links('vendor.pagination.simple-tailwind') !!}
                    @else
                        <span class="text-xs font-mono text-ink/40 mr-2">Página 1 de 1</span>
                        <button disabled class="p-1.5 rounded-lg border border-hairline/40 text-ink/30 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        <button disabled class="p-1.5 rounded-lg border border-hairline/40 text-ink/30 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- CRONOTRIGER DE NOTIFICACIÓN FLOTANTE (ESTILO PUSH/TOAST NATIVO) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" onload="inicializarNotificacion()"></script>
    <script>
        function inicializarNotificacion() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 5000,
                timerProgressBar: true,
                background: '#FAF6F0',
                color: '#241F1A',
                iconColor: '#A97C50',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: '{{ $saludo }}',
                html: '<span style="font-family: inherit; font-size: 12.5px; color: rgba(36,31,26,0.75);">Has ingresado con éxito al Panel de Control.</span>',
                customClass: {
                    popup: 'rounded-xl border border-hairline/60 shadow-2xl p-4',
                    title: 'font-display text-sm font-bold text-ink text-left',
                    htmlContainer: 'text-left mt-0.5'
                }
            });
        }
    </script>

@endsection