@extends('layouts.app')

@section('title', 'Anuncios - Iglesia El Cordero De Dios En El Perú')

@section('content')

    <!-- Hero Section (Encabezado) -->
    <section class="mb-16 sm:mb-24 flex flex-col items-center text-center sm:items-start sm:text-left relative">
        <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-bronze mb-4 font-bold flex items-center gap-3">
            <span class="w-8 h-px bg-bronze/50 hidden sm:block"></span>
            Pucallpa · Perú
        </p>
        
        <h1 class="font-display text-5xl sm:text-6xl md:text-7xl leading-[1.1] mb-5 max-w-3xl text-dynamic-gradient text-balance pb-3">
            Conectados como iglesia.
        </h1>
        
        <p class="text-ink/70 text-lg sm:text-xl max-w-2xl leading-relaxed font-body font-medium text-pretty">
            Encuentra los últimos anuncios, actividades, eventos, comunicados y noticias de nuestra congregación.
        </p>
    </section>

    <!-- SECCIÓN: Cultos o Servicios -->
    <section class="mb-16 sm:mb-24">
        <div class="flex items-center gap-4 mb-10 sm:mb-12">
            <h2 class="font-display text-3xl sm:text-4xl text-ink tracking-tight">Cultos o Servicios</h2>
            <div class="h-px bg-gradient-to-r from-hairline to-transparent flex-1 mt-2"></div>
        </div>

        @if ($cultos->isEmpty())
            <div class="text-center py-10 border-2 border-dashed border-hairline/80 bg-parchment2/20 rounded-2xl">
                <p class="font-display text-xl text-ink">No hay cultos programados en este momento.</p>
            </div>
        @else
            {{-- BLOQUE PHP PARA ORDENAR LOS CULTOS PERSONALIZADAMENTE --}}
            @php
                $cultosOrdenados = $cultos->sortBy(function ($culto) {
                    // Convertimos todo a minúsculas combinando el nombre y el horario para buscar el día
                    $texto = mb_strtolower($culto->nombre . ' ' . $culto->horario);

                    if (str_contains($texto, 'martes')) return 1;
                    if (str_contains($texto, 'miercoles') || str_contains($texto, 'miércoles')) return 2;
                    if (str_contains($texto, 'sabado') || str_contains($texto, 'sábado')) return 3;
                    if (str_contains($texto, 'domingo')) return 4;

                    return 5; // Por si hay algún otro día o evento sin día específico
                });
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($cultosOrdenados as $culto)
                    <div class="bg-parchment2/10 backdrop-blur-sm border border-hairline/60 rounded-2xl overflow-hidden hover:border-wine/30 transition-all duration-300 hover:shadow-lg group">
                        @if ($culto->imagen)
                            <div class="h-48 w-full overflow-hidden">
                                <img src="{{ str_starts_with($culto->imagen, 'http') ? $culto->imagen : asset('storage/' . $culto->imagen) }}" 
                                     alt="{{ $culto->nombre }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                        @endif
                        <div class="p-6 text-center">
                            <h3 class="font-display text-xl text-ink mb-2">{{ $culto->nombre }}</h3>
                            <p class="text-wine font-bold font-mono tracking-wider">{{ $culto->horario }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Sección de Anuncios -->
    <section>
        <div class="flex items-center gap-4 mb-10 sm:mb-12">
            <h2 class="font-display text-3xl sm:text-4xl text-ink tracking-tight">Anuncios Recientes</h2>
            <div class="h-px bg-gradient-to-r from-hairline to-transparent flex-1 mt-2"></div>
        </div>

        @if ($anuncios->isEmpty())
            <div class="text-center py-20 sm:py-24 border-2 border-dashed border-hairline/80 bg-parchment2/20 backdrop-blur-sm rounded-2xl flex flex-col items-center justify-center gap-4 transition-all duration-300 hover:bg-parchment2/40 hover:border-bronze/30">
                <span class="text-5xl opacity-40 mb-2 drop-shadow-sm">🕊</span>
                <p class="font-display text-2xl text-ink text-balance">No hay anuncios publicados por el momento.</p>
                <p class="text-base text-ink/60 font-medium font-body max-w-sm text-balance">Vuelve más tarde para enterarte de nuestras novedades y próximos eventos.</p>
            </div>
        @else
            <div class="space-y-8">
                @foreach ($anuncios as $anuncio)
                    <article class="group relative bg-parchment2/10 backdrop-blur-sm border border-hairline/60 p-5 sm:p-8 rounded-3xl transition-all duration-500 hover:bg-parchment2/40 hover:shadow-[0_8px_30px_rgb(122,35,49,0.06)] hover:-translate-y-1">
                        <div class="absolute inset-0 rounded-3xl border-2 border-transparent group-hover:border-wine/10 transition-colors duration-500 pointer-events-none"></div>

                        <div class="grid grid-cols-1 md:grid-cols-[140px_1fr] gap-5 md:gap-10 items-start relative z-10">
                            
                            <!-- Columna Fecha -->
                            <div class="flex flex-row md:flex-col items-center md:items-start justify-between md:justify-start gap-4 pb-4 border-b border-hairline/80 md:pb-0 md:border-b-0 md:border-r md:border-hairline/80 md:pr-8 h-full">
                                @if ($anuncio->fecha_evento)
                                    <div class="font-mono text-wine leading-none flex items-baseline md:flex-col gap-2 group-hover:scale-105 transition-transform duration-300 origin-left">
                                        <span class="block text-4xl sm:text-5xl font-bold tracking-tighter">{{ $anuncio->fecha_evento->format('d') }}</span>
                                        <div class="flex flex-col gap-1 text-right md:text-left">
                                            <span class="text-[10px] sm:text-[11px] uppercase font-bold tracking-widest text-wine/80">
                                                {{ $anuncio->fecha_evento->translatedFormat('l') }}
                                            </span>
                                            <span class="text-[10px] sm:text-[11px] uppercase tracking-widest text-ink/50 font-bold">
                                                {{ $anuncio->fecha_evento->translatedFormat('F Y') }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center justify-center px-4 py-1.5 bg-gradient-to-r from-wine/10 to-bronze/10 text-wine rounded-full font-mono text-[10px] sm:text-[11px] uppercase tracking-widest font-bold border border-wine/20">
                                        Aviso
                                    </span>
                                @endif
                            </div>

                            <!-- Columna Contenido -->
                            <div class="space-y-5">
                                @if ($anuncio->imagen)
                                    <div class="overflow-hidden rounded-2xl border border-hairline/80 shadow-sm transition-all duration-700 group-hover:shadow-[0_8px_24px_rgb(36,31,26,0.08)]">
                                        <img src="{{ str_starts_with($anuncio->imagen, 'http') ? $anuncio->imagen : asset('storage/' . $anuncio->imagen) }}" 
                                             alt="{{ $anuncio->titulo }}"
                                             class="w-full h-auto max-h-[250px] sm:max-h-[350px] object-cover transition-transform duration-[1.5s] group-hover:scale-110">
                                    </div>
                                @endif
                                
                                <div class="space-y-3 pt-1">
                                    <h3 class="font-display text-2xl sm:text-3xl text-ink tracking-tight group-hover:text-wine transition-colors duration-300 text-pretty">
                                        {{ $anuncio->titulo }}
                                    </h3>
                                    <div class="w-12 h-0.5 bg-bronze/30 group-hover:w-24 group-hover:bg-wine/50 transition-all duration-500"></div>
                                    <p class="text-ink/75 leading-relaxed text-base sm:text-lg whitespace-pre-line font-body pt-2 text-pretty">
                                        {{ $anuncio->contenido }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Versículo rotativo -->
    @include('partials.versiculos')

    <!-- Footer Profesional -->
    <footer class="mt-24 pt-16 pb-12 border-t border-hairline/30">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
            
            <div class="space-y-4">
                <h4 class="font-display text-xl text-wine">Contacto</h4>
                <p class="text-ink/60 font-body text-sm leading-relaxed">
                    ¿Tienes dudas o necesitas más información?<br>
                    Estamos aquí para servirte.
                </p>
                <a href="tel:+51 931 226 348" class="block font-mono text-wine hover:text-bronze transition-colors font-bold tracking-wider text-sm">
                    📞 +51 931 226 348
                </a>
            </div>

            <div class="space-y-4">
                <h4 class="font-display text-xl text-wine">Comunidad</h4>
                <p class="text-ink/60 font-body text-sm leading-relaxed">
                    Únete a nuestro grupo oficial de WhatsApp para recibir anuncios en tiempo real.
                </p>
                <a href="https://chat.whatsapp.com/DTuddDKGlFN7WkKOulogf4" target="_blank" 
                   class="inline-block px-6 py-2 bg-wine text-parchment2 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-bronze transition-all hover:scale-105 shadow-md">
                    Unirse al Grupo
                </a>
            </div>

            <div class="space-y-4">
                <h4 class="font-display text-xl text-wine">Ubicación</h4>
                <p class="text-ink/60 font-body text-sm leading-relaxed">
                    Jr. Ejemplo de Calle 123<br>
                    Pucallpa, Ucayali<br>
                    Perú
                </p>
                <a href="https://maps.app.goo.gl/MzNPGLvDYdyYQYKF7" target="_blank" class="text-ink/40 hover:text-wine text-xs font-mono underline underline-offset-4 decoration-wine/30">
                    Ver en el mapa
                </a>
            </div>

        </div>

        <div class="mt-16 text-center border-t border-hairline/20 pt-8">
            <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-bold">
                &copy; {{ date('Y') }} Iglesia El Cordero De Dios En El Perú
            </p>
        </div>
    </footer>

    <!-- ================================================================= -->
    <!-- MÚSICA DE FONDO AUTOMÁTICA E INVISIBLE                            -->
    <!-- ================================================================= -->
    <audio id="bg-music" loop>
        <source src="{{ asset('audio/audio.mp3') }}" type="audio/mpeg">
    </audio>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const music = document.getElementById('bg-music');
            
            // Volumen suave (1.0 es el máximo)
            music.volume = 1.0; 

            // Función para iniciar la reproducción al interactuar
            const iniciarMusica = () => {
                music.play().then(() => {
                    // Removemos los escuchadores para limpiar memoria una vez que ya suena
                    document.removeEventListener('click', iniciarMusica);
                    document.removeEventListener('touchstart', iniciarMusica);
                }).catch(error => {
                    console.log("El navegador bloqueó el inicio automático. Esperando clic...");
                });
            };

            // Escucha el primer clic o toque en la pantalla
            document.addEventListener('click', iniciarMusica);
            document.addEventListener('touchstart', iniciarMusica);
        });
    </script>
    <!-- ================================================================= -->

@endsection