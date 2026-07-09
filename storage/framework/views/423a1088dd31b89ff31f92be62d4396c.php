<?php $__env->startSection('title', 'Editar Anuncio'); ?>

<?php $__env->startSection('content'); ?>

    <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-bronze mb-3">Panel interno</p>
    <h1 class="font-display text-3xl text-ink mb-10">Editar anuncio</h1>

    <form action="<?php echo e(route('anuncios.update', $anuncio)); ?>" method="POST" enctype="multipart/form-data" class="max-w-xl">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('anuncios._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn btn-primary px-6 py-2.5 rounded font-medium text-sm">
                Actualizar anuncio
            </button>
            <a href="<?php echo e(route('anuncios.admin')); ?>" class="btn btn-ghost px-6 py-2.5 rounded text-sm">
                Cancelar
            </a>
        </div>
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iglesia\resources\views/anuncios/edit.blade.php ENDPATH**/ ?>