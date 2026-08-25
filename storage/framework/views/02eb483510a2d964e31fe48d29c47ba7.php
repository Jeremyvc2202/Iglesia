

<?php $__env->startSection('title', 'Nuevo Culto'); ?>

<?php $__env->startSection('content'); ?>

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
        <div class="clay-panel p-6 sm:p-10 rounded-3xl relative">
            
            <?php if($errors->any()): ?>
                <div class="mb-8 border border-wine/30 bg-wine/5 text-wine px-4 py-3 text-sm rounded">
                    <ul class="list-disc list-inside space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('cultos.store')); ?>" method="POST" enctype="multipart/form-data" class="relative z-10">
                <?php echo csrf_field(); ?>
                
                <div class="space-y-6">
                    <!-- Zona de Carga de Imagen -->
                    <div>
                        <label class="form-label">Imagen (opcional)</label>

                        <label for="imagen-input"
                               class="flex flex-col items-center justify-center gap-2 w-full border border-dashed border-hairline rounded-xl py-10 px-4 cursor-pointer hover:border-wine hover:bg-parchment2/40 transition-colors duration-200 bg-parchment">
                            <svg class="w-7 h-7 text-bronze" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-ink/60 font-medium text-center" id="imagen-label">
                                Haz clic para subir una imagen
                            </span>
                            <span class="text-xs text-ink/40 font-mono">JPG, PNG o WEBP · máx. 4 MB</span>
                            <input id="imagen-input" type="file" name="imagen" accept="image/*" class="hidden">
                        </label>

                        <!-- Vista previa dinámica -->
                        <img id="imagen-preview" src="" alt="Vista previa" class="hidden mt-4 w-full max-w-xs h-40 object-cover rounded-xl border border-hairline shadow-sm">
                    </div>

                    <!-- Nombre del Culto -->
                    <div>
                        <label class="form-label">Nombre del Culto</label>
                        <input type="text" name="nombre" value="<?php echo e(old('nombre')); ?>"
                               class="form-input"
                               placeholder="Ej: Culto Dominical de Adoración" required>
                    </div>

                    <!-- Horario -->
                    <div>
                        <label class="form-label">Horario</label>
                        <input type="text" name="horario" value="<?php echo e(old('horario')); ?>"
                               class="form-input"
                               placeholder="Ej: Domingos - 10:00 AM" required>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-12 pt-8 border-t border-hairline/60">
                    <button type="submit" class="btn btn-dynamic-bg clay-shadow w-full sm:w-auto px-8 py-3.5 rounded-lg font-bold text-sm tracking-widest uppercase">
                        Guardar culto
                    </button>

                    <a href="<?php echo e(route('anuncios.admin')); ?>" class="btn btn-outline clay-shadow w-full sm:w-auto px-6 py-3.5 rounded-lg font-semibold text-sm tracking-widest uppercase text-center">
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iglesia\resources\views/cultos/create.blade.php ENDPATH**/ ?>