<?php if($errors->any()): ?>
    <div class="mb-8 border border-wine/30 bg-wine/5 text-wine px-4 py-3 text-sm rounded">
        <ul class="list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="space-y-6">
    <div>
        <label class="block text-xs font-mono uppercase tracking-wide text-ink/50 mb-2">Imagen (opcional)</label>

        <?php if(isset($anuncio) && $anuncio->imagen): ?>
            <div class="mb-3 w-full max-w-xs">
                <img src="<?php echo e($anuncio->imagen_url); ?>" alt="Imagen actual del anuncio"
                     class="w-full h-40 object-cover rounded border border-hairline">
                <label class="flex items-center gap-2 mt-2 text-xs text-ink/50 cursor-pointer w-fit">
                    <input type="checkbox" name="eliminar_imagen" value="1" class="w-3.5 h-3.5 accent-wine">
                    Quitar esta imagen
                </label>
            </div>
        <?php endif; ?>

        <label for="imagen-input"
               class="flex flex-col items-center justify-center gap-2 w-full border border-dashed border-hairline rounded-lg py-8 px-4 cursor-pointer hover:border-wine transition-colors duration-200 bg-parchment">
            <svg class="w-6 h-6 text-bronze" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-sm text-ink/60" id="imagen-label">
                <?php echo e(isset($anuncio) && $anuncio->imagen ? 'Cambiar imagen' : 'Haz clic para subir una imagen'); ?>

            </span>
            <span class="text-xs text-ink/35">JPG, PNG o WEBP · máx. 4 MB</span>
            <input id="imagen-input" type="file" name="imagen" accept="image/*" class="hidden">
        </label>

        <img id="imagen-preview" src="" alt="Vista previa" class="hidden mt-3 w-full max-w-xs h-40 object-cover rounded border border-hairline">
    </div>

    <div>
        <label class="block text-xs font-mono uppercase tracking-wide text-ink/50 mb-2">Título</label>
        <input type="text" name="titulo" value="<?php echo e(old('titulo', $anuncio->titulo ?? '')); ?>"
               class="w-full bg-parchment border border-hairline rounded px-4 py-2.5 text-ink placeholder:text-ink/30 focus:outline-none focus:border-wine focus:shadow-[0_0_0_3px_rgba(122,35,49,0.08)] transition-all duration-200"
               placeholder="Ej: Culto especial de Navidad" required>
    </div>

    <div>
        <label class="block text-xs font-mono uppercase tracking-wide text-ink/50 mb-2">Contenido</label>
        <textarea name="contenido" rows="5"
                  class="w-full bg-parchment border border-hairline rounded px-4 py-2.5 text-ink placeholder:text-ink/30 focus:outline-none focus:border-wine focus:shadow-[0_0_0_3px_rgba(122,35,49,0.08)] transition-all duration-200"
                  placeholder="Detalles del anuncio..." required><?php echo e(old('contenido', $anuncio->contenido ?? '')); ?></textarea>
    </div>

    <div>
        <label class="block text-xs font-mono uppercase tracking-wide text-ink/50 mb-2">Fecha del evento (opcional)</label>
        <input type="date" name="fecha_evento"
               value="<?php echo e(old('fecha_evento', isset($anuncio) && $anuncio->fecha_evento ? $anuncio->fecha_evento->format('Y-m-d') : '')); ?>"
               class="w-full sm:w-64 bg-parchment border border-hairline rounded px-4 py-2.5 text-ink focus:outline-none focus:border-wine focus:shadow-[0_0_0_3px_rgba(122,35,49,0.08)] transition-all duration-200">
    </div>

    <label class="flex items-center gap-2.5 cursor-pointer w-fit">
        <input type="checkbox" name="activo" value="1"
               <?php echo e(old('activo', $anuncio->activo ?? true) ? 'checked' : ''); ?>

               class="w-4 h-4 accent-wine">
        <span class="text-sm text-ink/70">Mostrar en la página pública</span>
    </label>
</div>

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
</script><?php /**PATH C:\laragon\www\iglesia\resources\views/anuncios/_form.blade.php ENDPATH**/ ?>