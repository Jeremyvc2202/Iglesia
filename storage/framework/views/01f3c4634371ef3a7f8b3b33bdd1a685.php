<?php $__env->startSection('title', 'Acceder - Iglesia El Cordero De Dios En El Perú'); ?>

<?php $__env->startSection('content'); ?>

    <div class="max-w-md mx-auto relative group">
        
        <!-- Tarjeta del formulario -->
        <div class="bg-parchment2/40 backdrop-blur-md p-8 sm:p-10 rounded-2xl border border-hairline/80 shadow-[0_8px_30px_rgb(36,31,26,0.06)] relative overflow-hidden transition-all duration-500 hover:shadow-[0_8px_40px_rgb(122,35,49,0.08)]">
            
            <!-- Resplandor decorativo de fondo -->
            <div class="absolute inset-0 bg-gradient-to-br from-wine/5 to-transparent opacity-50 pointer-events-none"></div>

            <div class="text-center mb-10 relative">
                <span class="font-display text-4xl block mb-4 animate-color-flow drop-shadow-sm">✝</span>
                <h1 class="font-display text-3xl sm:text-4xl text-ink mb-2 text-dynamic-gradient">Acceder</h1>
                <p class="text-ink/60 text-sm font-medium">Ingresa con tu cuenta de Administrador</p>
            </div>

            <!-- Manejo de Errores -->
            <?php if($errors->any()): ?>
                <div class="mb-8 border border-wine/30 bg-wine/10 text-wine px-5 py-4 text-sm rounded-lg shadow-inner relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-wine"></div>
                    <div class="flex items-center gap-2 mb-2 font-bold tracking-wide">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        No se pudo acceder
                    </div>
                    <ul class="list-disc list-inside space-y-1 ml-1 text-wine/80">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('login.submit')); ?>" method="POST" class="space-y-6 relative z-10">
                <?php echo csrf_field(); ?>

                <div class="group/input">
                    <label class="block text-xs font-mono uppercase tracking-widest text-ink/50 mb-2 font-semibold transition-colors group-focus-within/input:text-wine">
                        Correo electrónico
                    </label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                           class="w-full bg-parchment/90 border border-hairline rounded-lg px-4 py-3 text-ink placeholder:text-ink/30 focus:outline-none focus:border-wine focus:ring-4 focus:ring-wine/10 transition-all duration-300 shadow-sm"required autofocus>
                </div>

                <div class="group/input relative">
                    <label class="block text-xs font-mono uppercase tracking-widest text-ink/50 mb-2 font-semibold transition-colors group-focus-within/input:text-wine">
                        Contraseña
                    </label>
                    <input type="password" name="password" id="password"
                           class="w-full bg-parchment/90 border border-hairline rounded-lg px-4 py-3 text-ink placeholder:text-ink/30 focus:outline-none focus:border-wine focus:ring-4 focus:ring-wine/10 transition-all duration-300 shadow-sm pr-12">
                    
                    <!-- Botón del ojo -->
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-[38px] text-ink/40 hover:text-wine transition-colors focus:outline-none">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-dynamic-bg w-full px-5 py-3.5 rounded-lg font-bold text-sm tracking-widest uppercase">
                        Ingresar
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-ink/40 mt-8 font-medium tracking-wide">
            ¿No tienes cuenta? <br class="sm:hidden">
            <span class="text-ink/60">Solicítala directamente con la administración.</span>
        </p>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iglesia\resources\views/auth/login.blade.php ENDPATH**/ ?>