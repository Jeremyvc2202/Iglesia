@extends('layouts.app')

@section('title', 'Editar Culto')

@section('content')

    <div class="max-w-3xl mx-auto">
        <!-- Encabezado de la sección -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-8 h-px bg-bronze/50"></span>
                <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-bronze font-bold">Panel interno</p>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl text-ink text-dynamic-gradient inline-block mb-2">Editar Culto</h1>
            <p class="text-ink/60 text-sm font-medium">Actualiza la información del culto, reemplaza su imagen o gestiona su visibilidad pública.</p>
        </div>

        <!-- Tarjeta del formulario -->
        <div class="clay-panel p-6 sm:p-10 rounded-3xl relative">
            
            @if ($errors->any())
                <div class="mb-8 border border-wine/30 bg-wine/5 text-wine px-4 py-3 text-sm rounded">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cultos.update', $culto) }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">

                    <!-- Sección de Imagen -->
                    <div>
                        <label class="form-label">Imagen (opcional)</label>

                        <!-- Imagen Guardada Actualmente -->
                        @if ($culto->imagen)
                            <div class="mb-4 w-full max-w-xs">
                                <img src="{{ asset('storage/' . $culto->imagen) }}" alt="Imagen actual del culto"
                                     class="w-full h-40 object-cover rounded-xl border border-hairline shadow-sm">
                                <label class="flex items-center gap-2 mt-2 text-xs text-ink/50 cursor-pointer w-fit">
                                    <input type="checkbox" name="eliminar_imagen" value="1" class="w-3.5 h-3.5 accent-wine">
                                    Quitar esta imagen
                                </label>
                            </div>
                        @endif

                        <!-- Caja de Carga -->
                        <label for="imagen-input"
                               class="flex flex-col items-center justify-center gap-2 w-full border border-dashed border-hairline rounded-xl py-10 px-4 cursor-pointer hover:border-wine hover:bg-parchment2/40 transition-colors duration-200 bg-parchment">
                            <svg class="w-7 h-7 text-bronze" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-ink/60 font-medium text-center" id="imagen-label">
                                {{ $culto->imagen ? 'Cambiar imagen' : 'Haz clic para subir una imagen' }}
                            </span>
                            <span class="text-xs text-ink/40 font-mono">JPG, PNG o WEBP · máx. 4 MB</span>
                            <input id="imagen-input" type="file" name="imagen" accept="image/*" class="hidden">
                        </label>

                        <!-- Vista previa del nuevo archivo seleccionado -->
                        <img id="imagen-preview" src="" alt="Vista previa" class="hidden mt-4 w-full max-w-xs h-40 object-cover rounded-xl border border-hairline shadow-sm">
                    </div>

                    <!-- Nombre del Culto -->
                    <div>
                        <label class="form-label">Nombre del Culto</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $culto->nombre) }}"
                               class="form-input"
                               placeholder="Ej: Culto Dominical" required>
                    </div>

                    <!-- Horario -->
                    <div>
                        <label class="form-label">Horario</label>
                        <input type="text" name="horario" value="{{ old('horario', $culto->horario) }}"
                               class="form-input"
                               placeholder="Ej: 10:00 AM" required>
                    </div>

                    <!-- Mostrar en la página pública (Estado Activo) -->
                    <label class="flex items-center gap-2.5 cursor-pointer w-fit">
                        <input type="checkbox" name="activo" value="1"
                               {{ old('activo', $culto->activo) ? 'checked' : '' }}
                               class="w-4 h-4 accent-wine">
                        <span class="text-sm font-medium text-ink/70">Mostrar en la página pública</span>
                    </label>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-12 pt-8 border-t border-hairline/60">
                    <button type="submit" class="btn btn-dynamic-bg clay-shadow w-full sm:w-auto px-8 py-3.5 rounded-lg font-bold text-sm tracking-widest uppercase">
                        Actualizar culto
                    </button>

                    <a href="{{ route('anuncios.admin') }}" class="btn btn-outline clay-shadow w-full sm:w-auto px-6 py-3.5 rounded-lg font-semibold text-sm tracking-widest uppercase text-center">
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