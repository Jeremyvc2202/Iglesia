
<section class="mt-16 sm:mt-20" aria-label="Versículo destacado">

    <div class="ornament mb-8">
        <span class="font-display text-sm">✝</span>
    </div>

    <div id="versiculo-box" class="max-w-2xl mx-auto text-center px-4">
        <p class="font-mono text-[11px] uppercase tracking-[0.2em] text-bronze mb-6">
            Palabra para hoy
        </p>

        <blockquote>
            <p id="versiculo-texto"
               class="font-display italic text-xl sm:text-2xl leading-relaxed text-ink transition-opacity duration-500 ease-out"
               style="opacity:0; transform: translateY(6px);">
                Cargando...
            </p>
        </blockquote>

        <cite id="versiculo-ref"
              class="block not-italic font-mono text-xs uppercase tracking-[0.15em] text-wine mt-5 transition-opacity duration-500 ease-out"
              style="opacity:0;">
        </cite>

        <div class="w-16 h-px bg-hairline mx-auto mt-8 relative overflow-hidden">
            <div id="versiculo-progreso" class="absolute inset-y-0 left-0 w-0 bg-wine"></div>
        </div>
    </div>

</section>

<style>
    #versiculo-progreso {
        transition: width linear;
    }
    #versiculo-box.is-fading #versiculo-texto,
    #versiculo-box.is-fading #versiculo-ref {
        opacity: 0 !important;
        transform: translateY(6px);
    }
</style>

<script>
(function () {
    const INTERVALO_MS = 15000; // tiempo entre versículos (ms)

    // Versículos de respaldo, por si /data/versiculos.json no carga
    const RESPALDO = [
        { ref: "Filipenses 4:13", text: "Todo lo puedo en Cristo que me fortalece." },
        { ref: "Juan 3:16", text: "Porque de tal manera amó Dios al mundo, que ha dado á su Hijo unigénito, para que todo aquel que en él cree, no se pierda, mas tenga vida eterna." },
        { ref: "Salmos 23:1", text: "Jehová es mi pastor; nada me faltará." },
        { ref: "Proverbios 3:5", text: "Fíate de Jehová de todo tu corazón, y no estribes en tu prudencia." },
        { ref: "Isaías 41:10", text: "No temas, porque yo soy contigo; no te desmayes, que yo soy tu Dios que te esfuerzo." },
    ];

    const box = document.getElementById('versiculo-box');
    const elTexto = document.getElementById('versiculo-texto');
    const elRef = document.getElementById('versiculo-ref');
    const elProgreso = document.getElementById('versiculo-progreso');

    // Solo pausa al pasar el cursor en dispositivos que realmente tienen cursor
    // (evita que un toque en celular deje la rotación "congelada" para siempre)
    const tieneCursorReal = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    let versiculos = [];
    let orden = [];
    let indice = 0;
    let timerCambio = null;
    let pausado = false;

    function barajar(arr) {
        for (let i = arr.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
        return arr;
    }

    function iniciarProgreso() {
        elProgreso.style.transition = 'none';
        elProgreso.style.width = '0%';
        void elProgreso.offsetWidth; // fuerza reflow para reiniciar la animación
        elProgreso.style.transition = `width ${INTERVALO_MS}ms linear`;
        elProgreso.style.width = '100%';
    }

    function mostrarVersiculo(v) {
        elTexto.textContent = `"${v.text}"`;
        elRef.textContent = v.ref;

        requestAnimationFrame(() => {
            box.classList.remove('is-fading');
            elTexto.style.opacity = '1';
            elTexto.style.transform = 'translateY(0)';
            elRef.style.opacity = '1';
            elRef.style.transform = 'translateY(0)';
        });

        iniciarProgreso();
    }

    function siguienteVersiculo() {
        if (pausado || versiculos.length === 0) return;

        box.classList.add('is-fading');

        setTimeout(() => {
            indice = (indice + 1) % orden.length;
            if (indice === 0) barajar(orden);
            mostrarVersiculo(versiculos[orden[indice]]);
        }, 350);
    }

    function programarSiguiente() {
        clearInterval(timerCambio);
        timerCambio = setInterval(siguienteVersiculo, INTERVALO_MS);
    }

    function cargarConjunto(data, esRespaldo) {
        versiculos = data;
        orden = barajar(versiculos.map((_, i) => i));
        indice = 0;
        mostrarVersiculo(versiculos[orden[0]]);
        programarSiguiente();
        if (esRespaldo) {
            console.warn('[versiculos] No se pudo cargar /data/versiculos.json — usando lista de respaldo. Revisa que el archivo exista en public/data/versiculos.json');
        }
    }

    if (tieneCursorReal) {
        box.addEventListener('mouseenter', () => {
            pausado = true;
            elProgreso.style.transition = 'none';
        });
        box.addEventListener('mouseleave', () => {
            pausado = false;
            iniciarProgreso();
        });
    }

    fetch('/data/versiculos.json')
        .then(r => {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json();
        })
        .then(data => {
            if (!Array.isArray(data) || data.length === 0) throw new Error('JSON vacío o inválido');
            cargarConjunto(data, false);
        })
        .catch(err => {
            console.error('[versiculos] Error cargando versiculos.json:', err);
            cargarConjunto(RESPALDO, true);
        });
})();
</script><?php /**PATH C:\laragon\www\iglesia\resources\views/partials/versiculos.blade.php ENDPATH**/ ?>