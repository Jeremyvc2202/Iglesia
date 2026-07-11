<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Iglesia El Cordero De Dios En El Perú')</title>

    <!-- Aplica el tema guardado ANTES de pintar la página, para evitar parpadeo -->
    <script>
        (function () {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,500&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        parchment: 'var(--color-bg)',
                        parchment2: 'var(--color-bg2)',
                        ink: 'var(--color-ink)',
                        wine: 'var(--color-wine)',
                        wine2: 'var(--color-wine2)',
                        pine: 'var(--color-pine)',
                        bronze: 'var(--color-bronze)',
                        hairline: 'var(--color-hairline)',
                    },
                    fontFamily: {
                        display: ['Fraunces', 'ui-serif', 'serif'],
                        body: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['"IBM Plex Mono"', 'ui-monospace', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        /* =========================================
           TOKENS DE COLOR — claro / oscuro
           ========================================= */
        :root {
            --color-bg: #F6F1E7;
            --color-bg2: #EFE7D6;
            --color-ink: #241F1A;
            --color-wine: #7A2331;
            --color-wine2: #5C1A25;
            --color-pine: #1F4741;
            --color-bronze: #A97C50;
            --color-hairline: #DCD2BC;

            /* Claymorfismo — sombra doble (luz arriba-izquierda / sombra abajo-derecha) */
            --clay-light: rgba(255, 255, 255, 0.85);
            --clay-dark: rgba(36, 31, 26, 0.14);
            --clay-bg-grad: linear-gradient(150deg, #FCF9F2, #EEE5D2);
        }
        html.dark {
            --color-bg: #17130F;
            --color-bg2: #211B15;
            --color-ink: #F1E9DA;
            --color-wine: #D9647A;
            --color-wine2: #E58198;
            --color-pine: #5FB3A3;
            --color-bronze: #D3A876;
            --color-hairline: #3B3226;

            --clay-light: rgba(255, 255, 255, 0.05);
            --clay-dark: rgba(0, 0, 0, 0.6);
            --clay-bg-grad: linear-gradient(150deg, #241D16, #14100C);
        }

        body { font-family: 'Inter', system-ui, sans-serif; position: relative; }
        .font-display { font-family: 'Fraunces', serif; font-feature-settings: "liga" 1; }

        body, header, footer, aside, nav, main, .btn, .nav-link, img, svg {
            transition: background-color 450ms ease, border-color 450ms ease, color 450ms ease, box-shadow 450ms ease;
        }

        /* =========================================
           FONDO ESPACIAL — resplandores ambientales
           ========================================= */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            z-index: -1;
            background:
                radial-gradient(circle at 15% -8%, color-mix(in srgb, var(--color-wine) 14%, transparent), transparent 55%),
                radial-gradient(circle at 105% 25%, color-mix(in srgb, var(--color-bronze) 14%, transparent), transparent 50%),
                radial-gradient(circle at 50% 115%, color-mix(in srgb, var(--color-pine) 10%, transparent), transparent 55%);
            pointer-events: none;
            transition: background 450ms ease;
        }

        /* =========================================
           ANIMACIONES ESPECTACULARES DE COLOR
           ========================================= */
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .text-dynamic-gradient {
            background: linear-gradient(90deg, var(--color-ink), var(--color-wine), var(--color-bronze), var(--color-wine), var(--color-ink));
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
            animation: gradient-x 6s ease infinite;
        }

        @keyframes color-flow {
            0%, 100% { color: var(--color-ink); }
            50% { color: var(--color-wine); }
        }
        .animate-color-flow {
            animation: color-flow 5s ease-in-out infinite;
        }

        .btn-dynamic-bg {
            background: linear-gradient(90deg, var(--color-wine), var(--color-bronze), var(--color-wine));
            background-size: 200% auto;
            color: #FBF8F2 !important;
            transition: background-position 0.5s, transform 240ms cubic-bezier(.34,1.56,.64,1), box-shadow 240ms ease;
            border: none;
        }
        .btn-dynamic-bg:hover {
            background-position: right center;
            transform: translateY(-2px);
        }
        /* ========================================= */

        .ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.85rem;
            color: var(--color-bronze);
        }
        .ornament::before, .ornament::after {
            content: "";
            height: 1px;
            width: 56px;
            background: var(--color-hairline);
        }

        :focus-visible {
            outline: 2px solid var(--color-wine);
            outline-offset: 2px;
        }

        #site-header {
            transition: box-shadow 350ms cubic-bezier(0.4, 0, 0.2, 1), background-color 350ms ease, backdrop-filter 350ms ease;
        }
        #site-header.is-scrolled {
            background-color: color-mix(in srgb, var(--color-bg) 88%, transparent);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 0 var(--color-hairline), 0 10px 30px -15px rgba(0, 0, 0, 0.18);
        }

        .nav-link {
            position: relative;
            padding-bottom: 4px;
            transition: color 250ms ease;
        }
        .nav-link::after {
            content: "";
            position: absolute;
            left: 0; bottom: 0;
            width: 0%;
            height: 2px;
            background: var(--color-wine);
            transition: width 300ms cubic-bezier(.4,0,.2,1);
        }
        .nav-link:hover::after { width: 100%; }

        .btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 240ms cubic-bezier(.34,1.56,.64,1),
                        box-shadow 240ms cubic-bezier(.34,1.56,.64,1),
                        background-color 200ms ease,
                        border-color 200ms ease,
                        color 200ms ease;
            will-change: transform;
        }
        .btn-primary {
            background-color: var(--color-wine);
            color: #FBF8F2;
        }
        .btn-primary:hover {
            background-color: var(--color-wine2);
            transform: translateY(-2px);
        }
        .btn-primary:active {
            transform: translateY(0px) scale(0.97);
        }
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--color-wine);
            color: var(--color-wine);
        }
        .btn-outline:hover {
            background-color: var(--color-wine);
            color: #FBF8F2;
            transform: translateY(-2px);
        }
        .btn-outline:active {
            transform: translateY(0px) scale(0.97);
        }

        /* =========================================
           CLAYMORFISMO — superficies con sombra doble
           ========================================= */
        .clay-panel {
            background: var(--clay-bg-grad);
            border: 1px solid color-mix(in srgb, var(--color-hairline) 55%, transparent);
            box-shadow: 10px 10px 24px var(--clay-dark), -10px -10px 24px var(--clay-light);
            transition: box-shadow 400ms ease, transform 350ms cubic-bezier(.34,1.56,.64,1), border-color 400ms ease;
        }
        .clay-panel:hover {
            transform: translateY(-4px);
            box-shadow: 14px 14px 32px var(--clay-dark), -14px -14px 32px var(--clay-light);
        }

        .clay-shadow {
            box-shadow: 8px 8px 18px var(--clay-dark), -8px -8px 18px var(--clay-light);
            transition: box-shadow 300ms ease, transform 240ms cubic-bezier(.34,1.56,.64,1);
        }
        .clay-shadow:hover {
            box-shadow: 11px 11px 24px var(--clay-dark), -11px -11px 24px var(--clay-light);
        }
        .clay-shadow:active {
            box-shadow: inset 5px 5px 10px var(--clay-dark), inset -5px -5px 10px var(--clay-light);
            transform: translateY(1px) scale(0.98);
        }

        /* =========================================
           BOTÓN DE TEMA (claro / oscuro) — clay
           ========================================= */
        .theme-toggle {
            position: relative;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            border: 1px solid color-mix(in srgb, var(--color-hairline) 60%, transparent);
            background: var(--clay-bg-grad);
            box-shadow: 5px 5px 12px var(--clay-dark), -5px -5px 12px var(--clay-light);
            transition: box-shadow 300ms ease, transform 240ms cubic-bezier(.34,1.56,.64,1);
        }
        .theme-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 7px 7px 16px var(--clay-dark), -7px -7px 16px var(--clay-light);
        }
        .theme-toggle:active {
            transform: translateY(0) scale(0.94);
            box-shadow: inset 3px 3px 8px var(--clay-dark), inset -3px -3px 8px var(--clay-light);
        }
        .theme-icon {
            position: absolute;
            inset: 0;
            margin: auto;
            width: 1.15rem;
            height: 1.15rem;
            color: var(--color-bronze);
            transition: opacity 450ms cubic-bezier(.16,1,.3,1), transform 450ms cubic-bezier(.16,1,.3,1);
        }
        .theme-icon-sun {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }
        .theme-icon-moon {
            opacity: 0;
            transform: rotate(-90deg) scale(0.4);
        }
        html.dark .theme-icon-sun {
            opacity: 0;
            transform: rotate(90deg) scale(0.4);
        }
        html.dark .theme-icon-moon {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        /* =========================================
           LOGO — placa fija con relieve claymórfico
           ========================================= */
        .logo-plate {
            background-color: #FFFFFF;
            box-shadow: 6px 6px 14px rgba(0,0,0,0.15), -6px -6px 14px rgba(255,255,255,0.65), 0 0 0 1px var(--color-hairline);
            transition: box-shadow 300ms ease, transform 300ms ease;
        }
        .group:hover .logo-plate {
            transform: scale(1.06);
        }

        #mobile-panel {
            transition: transform 450ms cubic-bezier(.16,1,.3,1);
            transform: translateX(100%);
            background: var(--clay-bg-grad);
            box-shadow: -14px 0 34px var(--clay-dark);
            border-left: 1px solid color-mix(in srgb, var(--color-hairline) 55%, transparent);
        }
        #mobile-panel.is-open {
            transform: translateX(0%);
        }
        #mobile-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 350ms ease, backdrop-filter 350ms ease;
        }
        #mobile-overlay.is-open {
            opacity: 1;
            pointer-events: auto;
            backdrop-filter: blur(4px);
        }
        .mobile-link {
            opacity: 0;
            transform: translateX(16px);
            transition: opacity 400ms ease, transform 400ms cubic-bezier(.16,1,.3,1);
        }
        #mobile-panel.is-open .mobile-link {
            opacity: 1;
            transform: translateX(0);
        }
        #mobile-panel.is-open .mobile-link:nth-child(1) { transition-delay: 100ms; }
        #mobile-panel.is-open .mobile-link:nth-child(2) { transition-delay: 160ms; }
        #mobile-panel.is-open .mobile-link:nth-child(3) { transition-delay: 220ms; }
        #mobile-panel.is-open .mobile-link:nth-child(4) { transition-delay: 280ms; }

        .hamburger-line {
            transition: transform 300ms cubic-bezier(.16,1,.3,1), opacity 200ms ease;
            transform-origin: center;
        }
        #menu-toggle[aria-expanded="true"] .line-top { transform: translateY(6px) rotate(45deg); }
        #menu-toggle[aria-expanded="true"] .line-mid { opacity: 0; }
        #menu-toggle[aria-expanded="true"] .line-bot { transform: translateY(-6px) rotate(-45deg); }

        @keyframes fade-up {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fade-up 650ms cubic-bezier(.16,1,.3,1) both; }
        .fade-up-delay-1 { animation-delay: 120ms; }
        .fade-up-delay-2 { animation-delay: 220ms; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
            }
        }
    </style>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    </head>
    <body class="bg-parchment text-ink min-h-screen flex flex-col antialiased selection:bg-wine/10 selection:text-wine">

    <!-- Masthead -->
    <header id="site-header" class="sticky top-0 z-50 bg-parchment/90 border-b border-transparent">
        <div class="max-w-4xl mx-auto px-5 sm:px-8">
            <div class="flex items-center justify-between py-4 sm:py-5">
                <a href="{{ route('anuncios.index') }}" class="flex items-center gap-3.5 group focus-visible:rounded-sm">
                    <span class="logo-plate w-14 h-14 rounded-xl flex items-center justify-center p-2 shrink-0">
                        <img src="{{ asset('img/logo-icon.ico') }}" alt="Logo" class="w-full h-full object-contain">
                    </span>
                    <div class="leading-tight flex items-center">
                        <span class="block font-display text-lg sm:text-xl font-medium tracking-tight text-dynamic-gradient">
                            Iglesia El Cordero de Dios en El Perú
                        </span>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-6 text-sm font-medium tracking-wide">
                    <a href="{{ route('anuncios.index') }}" class="nav-link animate-color-flow hover:text-wine">Anuncios</a>

                    @auth
                        <a href="{{ route('anuncios.admin') }}" class="nav-link animate-color-flow hover:text-wine">Administrar</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn btn-outline clay-shadow px-4 py-1.5 rounded-2xl text-xs font-semibold uppercase tracking-wider">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-dynamic-bg clay-shadow px-5 py-2.5 rounded-2xl text-xs font-semibold uppercase tracking-wider">
                            Acceder
                        </a>
                    @endauth

                    <!-- Botón de tema (escritorio) -->
                    <button id="theme-toggle" type="button" class="theme-toggle" aria-label="Cambiar entre modo claro y oscuro" aria-pressed="false">
                        <svg class="theme-icon theme-icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m15.36 6.36l-1.06-1.06M6.7 6.7 5.64 5.64m12.72 0-1.06 1.06M6.7 17.3l-1.06 1.06M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0Z" />
                        </svg>
                        <svg class="theme-icon theme-icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 008.997-5.998Z" />
                        </svg>
                    </button>
                </nav>

                <div class="md:hidden flex items-center gap-2">
                    <!-- Botón de tema (móvil) -->
                    <button id="theme-toggle-mobile" type="button" class="theme-toggle" aria-label="Cambiar entre modo claro y oscuro" aria-pressed="false">
                        <svg class="theme-icon theme-icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m15.36 6.36l-1.06-1.06M6.7 6.7 5.64 5.64m12.72 0-1.06 1.06M6.7 17.3l-1.06 1.06M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0Z" />
                        </svg>
                        <svg class="theme-icon theme-icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21.752 15.002A9.72 9.72 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 008.997-5.998Z" />
                        </svg>
                    </button>

                    <button id="menu-toggle" class="relative w-10 h-10 flex items-center justify-center text-ink rounded-full hover:bg-parchment2/50 transition-colors" aria-label="Abrir menú" aria-expanded="false">
                        <span class="sr-only">Abrir menú</span>
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <line class="hamburger-line line-top" x1="4" y1="7" x2="20" y2="7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line class="hamburger-line line-mid" x1="4" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line class="hamburger-line line-bot" x1="4" y1="17" x2="20" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="h-px bg-hairline/60"></div>
    </header>

    <div id="mobile-overlay" class="md:hidden fixed inset-0 bg-ink/30 z-40"></div>
    <aside id="mobile-panel" class="md:hidden fixed top-0 right-0 h-full w-[80%] max-w-xs z-50 flex flex-col">
        <div class="flex items-center justify-between px-6 py-5 border-b border-hairline/60">
            <span class="font-display text-xl font-medium text-dynamic-gradient">Navegación</span>
            <button id="mobile-close" class="w-9 h-9 flex items-center justify-center rounded-full text-ink/50 hover:text-wine hover:bg-parchment2/60 transition" aria-label="Cerrar menú">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-6 py-8 space-y-2">
            <a href="{{ route('anuncios.index') }}" class="mobile-link block py-3 text-base font-medium animate-color-flow hover:text-wine border-b border-hairline/40 transition-colors">Anuncios</a>

            @auth
                <a href="{{ route('anuncios.admin') }}" class="mobile-link block py-3 text-base font-medium animate-color-flow hover:text-wine border-b border-hairline/40 transition-colors">Administrar</a>
                <form action="{{ route('logout') }}" method="POST" class="mobile-link pt-6">
                    @csrf
                    <button type="submit" class="btn btn-outline clay-shadow w-full py-3 rounded-2xl text-xs font-semibold uppercase tracking-wider">
                        Salir del panel
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-link btn btn-dynamic-bg clay-shadow w-full py-3 rounded-2xl text-xs font-semibold uppercase tracking-wider mt-6">
                    Acceder
                </a>
            @endauth
        </nav>
    </aside>

    <main class="flex-1 max-w-4xl w-full mx-auto px-5 sm:px-8 py-12 sm:py-16 fade-up">
        @yield('content')
    </main>
    
    <footer class="border-t border-hairline/80 bg-parchment2/10 mt-auto">
        <div class="max-w-4xl mx-auto px-5 sm:px-8 py-8 flex items-center justify-center">
            <span class="text-xs font-medium text-ink/40 tracking-wide text-center">
                &copy; {{ date('Y') }} Iglesia El Cordero de Dios en el Perú. Todos los derechos reservados. | Desarrollado por Jeremy Villacrez.
            </span>
        </div>
    </footer>

    <!-- Lógica Interactiva, Temas y Alertas -->
    <script>
        const header = document.getElementById('site-header');
        const menuToggle = document.getElementById('menu-toggle');
        const mobilePanel = document.getElementById('mobile-panel');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const mobileClose = document.getElementById('mobile-close');

        const onScroll = () => {
            header.classList.toggle('is-scrolled', window.scrollY > 12);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        const openMenu = () => {
            mobilePanel.classList.add('is-open');
            mobileOverlay.classList.add('is-open');
            menuToggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        };
        const closeMenu = () => {
            mobilePanel.classList.remove('is-open');
            mobileOverlay.classList.remove('is-open');
            menuToggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        };

        menuToggle.addEventListener('click', () => {
            mobilePanel.classList.contains('is-open') ? closeMenu() : openMenu();
        });
        mobileClose.addEventListener('click', closeMenu);
        mobileOverlay.addEventListener('click', closeMenu);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeMenu();
        });

        const themeToggle = document.getElementById('theme-toggle');
        const themeToggleMobile = document.getElementById('theme-toggle-mobile');

        function setPressedState() {
            const isDark = document.documentElement.classList.contains('dark');
            [themeToggle, themeToggleMobile].forEach(btn => btn?.setAttribute('aria-pressed', String(isDark)));
        }
        setPressedState();

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            setPressedState();
        }
        themeToggle?.addEventListener('click', toggleTheme);
        themeToggleMobile?.addEventListener('click', toggleTheme);

        @if(session('success') || session('error') || session('warning') || session('info'))
            const isDarkTheme = document.documentElement.classList.contains('dark');
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                background: isDarkTheme ? '#211B15' : '#F6F1E7',
                color: isDarkTheme ? '#F1E9DA' : '#241F1A',
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            @if(session('success'))
                Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
            @endif
            @if(session('error'))
                Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
            @endif
            @if(session('warning'))
                Toast.fire({ icon: 'warning', title: '{{ session('warning') }}' });
            @endif
            @if(session('info'))
                Toast.fire({ icon: 'info', title: '{{ session('info') }}' });
            @endif
        @endif

        document.addEventListener('submit', function (e) {
            if (e.target && e.target.classList.contains('form-eliminar')) {
                e.preventDefault(); 
                const form = e.target;
                const isDark = document.documentElement.classList.contains('dark');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción eliminará el registro permanentemente de la base de datos.",
                    icon: 'warning',
                    iconColor: isDark ? '#D9647A' : '#7A2331',
                    background: isDark ? '#211B15' : '#F6F1E7',
                    color: isDark ? '#F1E9DA' : '#241F1A',
                    showCancelButton: true,
                    confirmButtonColor: '#7A2331',
                    cancelButtonColor: '#A97C50',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); 
                    }
                });
            }
        });
    </script>
</body>
</html>