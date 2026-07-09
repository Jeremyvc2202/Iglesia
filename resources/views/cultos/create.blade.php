@extends('layouts.app')

@section('title', 'Nuevo Culto')

@section('content')

    <div class="max-w-3xl mx-auto">
        <!-- Encabezado de la sección -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-8 h-px bg-bronze/50"></span>
                <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-bronze font-bold">Panel interno</p>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl text-ink text-dynamic-gradient inline-block mb-2">Nuevo Culto</h1>
            <p class="text-ink/60 text-sm font-medium">Completa los campos a continuación para registrar un nuevo horario de culto con su respectiva imagen.</p>
        </div>

        <!-- Tarjeta del formulario -->
        <div class="bg-parchment2/30 backdrop-blur-sm p-6 sm:p-10 rounded-2xl border border-hairline/60 shadow-[0_4px_24px_rgb(36,31,26,0.04)] relative transition-all duration-500 hover:shadow-[0_4px_30px_rgb(122,35,49,0.06)]">
            
            @if ($errors->any())
                <div class="mb-8 border border-wine/30 bg-wine/5 text-wine px-4 py-3 text-sm rounded">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cultos.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                @csrf
                
                <div class="space-y-6">
                    <!-- Zona de Carga de Imagen -->
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wide text-ink/50 mb-2">Imagen Representativa (opcional)</label>

                        <label for="imagen-input"
                               class="flex flex-col items-center justify-center gap-2 w-full border border-dashed border-hairline rounded-lg py-8 px-4 cursor-pointer hover:border-wine transition-colors duration-200 bg-parchment">
                            <svg class="w-6 h-6 text-bronze" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-ink/60" id="imagen-label">
                                Haz clic para subir una imagen
                            </span>
                            <span class="text-xs text-ink/35">JPG, PNG o WEBP · máx. 4 MB</span>
                            <input id="imagen-input" type="file" name="imagen" accept="image/*" class="hidden">
                        </label>

                        <!-- Vista previa dinámica -->
                        <img id="imagen-preview" src="" alt="Vista previa" class="hidden mt-3 w-full max-w-xs h-40 object-cover rounded border border-hairline">
                    </div>

                    <!-- Nombre del Culto -->
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wide text-ink/50 mb-2">Nombre del Culto</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                               class="w-full bg-parchment border border-hairline rounded px-4 py-2.5 text-ink placeholder:text-ink/30 focus:outline-none focus:border-wine focus:shadow-[0_0_0_3px_rgba(122,35,49,0.08)] transition-all duration-200"
                               placeholder="Ej: Culto Dominical de Adoración" required>
                    </div>

                    <!-- Horario -->
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wide text-ink/50 mb-2">Horario</label>
                        <input type="text" name="horario" value="{{ old('horario') }}"
                               class="w-full bg-parchment border border-hairline rounded px-4 py-2.5 text-ink placeholder:text-ink/30 focus:outline-none focus:border-wine focus:shadow-[0_0_0_3px_rgba(122,35,49,0.08)] transition-all duration-200"
                               placeholder="Ej: Domingos - 10:00 AM" required>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-12 pt-8 border-t border-hairline/60">
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-lg font-bold text-sm tracking-widest uppercase shadow-md transition-all hover:scale-105" style="background: linear-gradient(90deg, #7A2331, #A97C50, #7A2331); color: #f4f1eb;">
                        Guardar culto
                    </button>
                    
                    <a href="{{ route('anuncios.admin') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-lg font-semibold text-sm tracking-widest uppercase text-center border border-hairline/80 text-ink/70 hover:bg-parchment hover:text-ink transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
            
        </div>
    </div>

    <!-- Script de Vista Previa -->
    <script>
        const imagenInput = document.getElementById('imagen-input');
        const imagenPreview = document.getElementById('imagen-preview');
        const imagenLabel = document.getElementById('imagen-label');

        imagenInput.addEventListener('change', () => {
            const file = imagenInput.files[0];
            if (!file) return;

            imagenLabel.textContent = file.name;

            const reader = new FileReader();
            reader.onload = (e) => {
                imagenPreview.src = e.target.result;
                imagenPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    </script>

@endsection