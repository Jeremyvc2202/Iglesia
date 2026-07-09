<?php $__env->startSection('title', 'Nuevo Anuncio'); ?>

<?php $__env->startSection('content'); ?>

    <div class="max-w-3xl mx-auto">
        <!-- Encabezado de la sección -->
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-3">
                <span class="w-8 h-px bg-bronze/50"></span>
                <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-bronze font-bold">Panel interno</p>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl text-ink text-dynamic-gradient inline-block mb-2">Nuevo anuncio</h1>
            <p class="text-ink/60 text-sm font-medium">Completa los campos a continuación para publicar un aviso a la congregación.</p>
        </div>

        <!-- Tarjeta del formulario -->
        <div class="bg-parchment2/30 backdrop-blur-sm p-6 sm:p-10 rounded-2xl border border-hairline/60 shadow-[0_4px_24px_rgb(36,31,26,0.04)] relative transition-all duration-500 hover:shadow-[0_4px_30px_rgb(122,35,49,0.06)]">
            
            <form action="<?php echo e(route('anuncios.store')); ?>" method="POST" enctype="multipart/form-data" class="relative z-10">
                <?php echo csrf_field(); ?>
                
                <!-- Aquí se inyectan tus inputs -->
                <div class="space-y-6">
                    <?php echo $__env->make('anuncios._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Botones de Acción -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-12 pt-8 border-t border-hairline/60">
                    <button type="submit" class="btn btn-dynamic-bg w-full sm:w-auto px-8 py-3.5 rounded-lg font-bold text-sm tracking-widest uppercase">
                        Guardar anuncio
                    </button>
                    
                    <a href="<?php echo e(route('anuncios.admin')); ?>" class="btn btn-ghost w-full sm:w-auto px-6 py-3.5 rounded-lg font-semibold text-sm tracking-widest uppercase text-center">
                        Cancelar
                    </a>
                </div>
            </form>
            
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iglesia\resources\views/anuncios/create.blade.php ENDPATH**/ ?>