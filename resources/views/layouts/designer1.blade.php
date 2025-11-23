<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AmericanBurguer</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @livewireStyles

    @livewireScripts

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <x-livewire-alert::scripts />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    @php
        // contador de pendientes (consulta simple en la vista)
        $pendientes = \App\Models\VentaModel::where('status', 'pendiente')->count();
    @endphp

    <style>
        /* ==== PALETA PROFESIONAL AMERICAN BURGER (NEGRO + NARANJAS) ==== */
        :root {
            --fondo-oscuro: #1a1a1a;
            --fondo-oscuro-2: #111111;
            --naranja-principal: #ff7a00;
            --naranja-secundario: #ff9d2e;
            --amarillo: #ffcc4d;
            --rojo: #d6452f;
            --verde-whatsapp: #25D366;
            --blanco-base: #ffffff;
            --gris-suave-base: #2a2a2a;

            /* alias de nombres antiguos usados en los estilos */
            --azul-principal: var(--fondo-oscuro);
            --azul-secundario: var(--naranja-principal);
            --azul-oscuro: var(--fondo-oscuro-2);
            --celeste: var(--amarillo);
            --blanco: var(--blanco-base);
            --gris-suave: var(--gris-suave-base);
        }

        /* ==== FONDO GENERAL ==== */
        body {
            background: radial-gradient(circle at top left, #2b2b2b 0%, #161616 40%, #050505 100%);
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: var(--blanco);
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        /* ==== ENCABEZADO ==== */
        header {
            background: linear-gradient(90deg, #050505, var(--naranja-principal));
            padding: 15px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.6);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        header .logo {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, .6));
        }

        /* Título principal */
        .Pizz {
            color: var(--blanco);
            font-weight: 900;
            letter-spacing: 2px;
            text-shadow: 0 3px 8px rgba(0,0,0,0.7);
        }

        /* ==== MENÚ ==== */
        .menu nav a,
        .menu nav button {
            background: var(--naranja-principal);
            color: var(--blanco) !important;
            border-radius: 999px;
            padding: 10px 16px;
            font-weight: 700;
            border: 1px solid rgba(0,0,0,0.35);
            transition: 0.2s ease-in-out;
        }

        .menu nav a:hover,
        .menu nav button:hover {
            background: var(--amarillo);
            color: #1a1a1a !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.7);
        }

        /* Texto de bienvenida */
        .menu nav p {
            background: rgba(0,0,0,0.55);
            color: var(--blanco);
            padding: 6px 12px;
            border-radius: 999px;
        }

        /* Logout más elegante */
        .menu nav form button {
            background: var(--rojo);
            color: var(--blanco);
            border-radius: 999px;
            border: 1px solid rgba(0,0,0,0.4);
        }
        .menu nav form button:hover {
            background: #ff5b47;
        }

        /* ==== CONTENIDO ==== */
        section {
            width: 100%;
            max-width: 100% !important;
            padding: 40px 20px;
            background: linear-gradient(180deg, rgba(0,0,0,0.65), rgba(0,0,0,0.90));
            border-radius: 0;
            margin: 0;
        }

        /* TITULOS */
        h1, h2, h3 {
            color: var(--blanco);
            text-shadow: 0 2px 6px rgba(0,0,0,0.6);
        }

        /* ==== IFRAME MAPA ==== */
        iframe {
            border: 2px solid var(--naranja-principal);
            box-shadow: 0 6px 20px rgba(0,0,0,0.7);
        }

        /* ==== FOOTER ==== */
        footer {
            background: #050505;
            color: var(--blanco);
            padding: 30px;
            border-top: 2px solid rgba(255,255,255,0.06);
            text-align: center;
        }

        footer .fab {
            color: var(--naranja-secundario);
            transition: 0.2s;
        }
        footer .fab:hover {
            color: var(--amarillo);
            transform: translateY(-5px);
        }

        /* ==== SWIPER ==== */
        .swiper-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 26px rgba(0,0,0,0.8);
        }

        /* =========================
        MEJORA DE DISEÑO GLOBAL
        ========================= */
        [class*="flex-auto"].w-32 input[type="search"],
        [class*="flex-auto"].w-32 .w-full,
        [class*="flex-auto"].w-32 button {
            transition: all .18s ease;
        }

        /* ----- BUSCADOR y BOTONES ----- */
        [class*="flex-auto"].w-32 {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Input de búsqueda */
        [class*="flex-auto"].w-32 input[type="search"] {
            width: calc(100% - 160px);
            max-width: 520px;
            min-width: 220px;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(0,0,0,0.6);
            color: var(--blanco);
            box-shadow: 0 6px 18px rgba(0,0,0,0.8);
            outline: none;
        }

        /* Placeholder */
        [class*="flex-auto"].w-32 input[type="search"]::placeholder {
            color: rgba(255,255,255,0.65);
        }

        /* Botón buscar */
        [class*="flex-auto"].w-32 button.bg-\[hsl\(25\,95%\,53%\)\],
        [class*="flex-auto"].w-32 button[wire\\:click] {
            background: linear-gradient(90deg,var(--naranja-principal), var(--naranja-secundario));
            color: #1a1a1a;
            padding: 10px 18px;
            border-radius: 12px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.7);
            border: none;
            font-weight: 700;
        }

        /* Botón Nuevo (rojo) */
        [class*="flex-auto"].w-32 button.bg-\[\#db1b1b\],
        [class*="flex-auto"].w-32 button[data-modal-toggle] {
            background: linear-gradient(180deg,#ff4b3a,var(--rojo));
            color: var(--blanco);
            border: none;
            padding: 10px 14px;
            border-radius: 12px;
        }
        [class*="flex-auto"].w-32 button:hover {
            transform: translateY(-3px);
        }

        /* ----- SECCIÓN DE PRODUCTOS ----- */
        [class*="bg-[#e8e8eb]"],
        .bg-\[\#e8e8eb\],
        [class*="bg-\\[\\#e8e8eb\\]"] {
            background: rgba(26,26,26,0.92);
            padding: 48px 24px;
            border-radius: 14px;
            box-shadow: 0 14px 40px rgba(0,0,0,0.9);
            margin: 28px auto;
            max-width: 1180px;
            border: 1px solid rgba(255,255,255,0.06);
        }

        [class*="bg-[#e8e8eb]"] h2.text-6xl,
        .bg-\[\#e8e8eb\] h2.text-6xl {
            color: var(--amarillo);
            text-shadow: 0 8px 22px rgba(0,0,0,0.9);
            font-size: clamp(1.8rem, 3.2vw, 3.2rem);
            margin-bottom: 8px;
        }

        [class*="bg-[#e8e8eb]"] > .w-full.h-1,
        .bg-\[\#e8e8eb\] > .w-full.h-1 {
            height: 3px;
            background: linear-gradient(90deg,var(--naranja-principal), rgba(255,255,255,0.2));
            opacity: .95;
            margin: 12px auto 28px;
            border-radius: 4px;
            max-width: 95%;
        }

        .container.mx-auto.grid {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* tarjeta producto */
        .shadow-lg.rounded-lg.overflow-hidden {
            background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(255,255,255,1));
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(0,0,0,0.8);
            border: 1px solid rgba(0,0,0,0.15);
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .shadow-lg.rounded-lg.overflow-hidden:hover {
            transform: translateY(-8px) scale(1.008);
            box-shadow: 0 28px 60px rgba(0,0,0,0.9);
        }

        /* imagen producto */
        .bg-white.shadow-lg.rounded-lg.overflow-hidden img,
        .product-card img {
            display: block;
            width: auto;
            max-width: 100%;
            height: 200px !important;
            max-height: 320px;
            object-fit: contain !important;
            background: #f7fafc;
            padding: 12px !important;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            transition: transform .22s ease, box-shadow .22s ease;
            margin: 0 auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            border-radius: 8px;
            margin-top: 12px !important;
            margin-bottom: 12px !important;
        }

        .bg-white.shadow-lg.rounded-lg.overflow-hidden:hover img,
        .product-card:hover img {
            transform: scale(1.03);
            box-shadow: 0 18px 40px rgba(0,0,0,0.10);
        }

        /* cuerpo de tarjeta */
        .shadow-lg.rounded-lg.overflow-hidden .p-4 {
            display: flex !important;
            flex-direction: column;
            gap: 6px !important;
            padding: 12px !important;
            background: transparent;
            min-height: 0 !important;
        }

        /* nombre producto */
        .shadow-lg.rounded-lg.overflow-hidden h3 {
            color: #1a1a1a;
            font-weight: 800;
            letter-spacing: .4px;
            margin: 0 0 4px 0 !important;
            line-height: 1.05 !important;
        }

        /* descripción */
        .shadow-lg.rounded-lg.overflow-hidden p {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.12 !important;
            min-height: 0 !important;
        }

        .shadow-lg.rounded-lg.overflow-hidden p.text-gray-600,
        .shadow-lg.rounded-lg.overflow-hidden p.description {
            margin-bottom: 6px !important;
            line-height: 1.15 !important;
            font-size: .95rem;
            display: -webkit-box !important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* precio y categoría */
        .shadow-lg.rounded-lg.overflow-hidden p.font-bold {
            color: var(--naranja-principal);
            font-size: 1.05rem;
            line-height: 1 !important;
        }

        .shadow-lg.rounded-lg.overflow-hidden p.text-orange-500 {
            color: var(--naranja-secundario);
            font-weight: 800;
            line-height: 1 !important;
        }

        .shadow-lg.rounded-lg.overflow-hidden p.font-bold + p {
            margin-top: 2px !important;
        }

        .shadow-lg.rounded-lg.overflow-hidden .price-category,
        .shadow-lg.rounded-lg.overflow-hidden .flex-col-no-gap {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin-top: 6px;
        }

        .shadow-lg.rounded-lg.overflow-hidden .flex > button {
            padding: 10px;
            border-radius: 10px;
            font-weight: 700;
        }

        .shadow-lg.rounded-lg.overflow-hidden .bg-[#f97316],
        .shadow-lg.rounded-lg.overflow-hidden button.bg-\[\\#f97316\\] {
            background: linear-gradient(90deg,#ff9b59,#f97316);
            color: white;
            border: none;
        }
        .shadow-lg.rounded-lg.overflow-hidden .bg-blue-500,
        .shadow-lg.rounded-lg.overflow-hidden button.bg-blue-500 {
            background: linear-gradient(90deg,var(--naranja-principal),var(--naranja-secundario));
            color: white;
            border: none;
        }
        .shadow-lg.rounded-lg.overflow-hidden .bg-red-500,
        .shadow-lg.rounded-lg.overflow-hidden button.bg-red-500 {
            background: linear-gradient(90deg,#ff4b3a,var(--rojo));
            color: white;
            border: none;
        }

        .shadow-lg.rounded-lg.overflow-hidden .mt-3 {
            margin-top: 8px !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .shadow-lg.rounded-lg.overflow-hidden .flex > button {
                width: 100%;
            }
            [class*="flex-auto"].w-32 input[type="search"] {
                width: 100%;
                max-width: none;
            }
            .bg-white.shadow-lg.rounded-lg.overflow-hidden img,
            .product-card img {
                height: 160px !important;
                padding: 10px !important;
            }
            .shadow-lg.rounded-lg.overflow-hidden .p-4 {
                padding: 10px !important;
                gap: 6px !important;
            }
            .shadow-lg.rounded-lg.overflow-hidden h3 {
                font-size: 1rem;
            }
        }

        /* ----- PAGINACIÓN ----- */
        .pagination, .w-full > nav[role="navigation"], .w-full nav {
            display:flex;
            justify-content:center;
            gap:8px;
            margin: 18px 0 6px;
        }
        .pagination a, .w-full nav a, .w-full nav span {
            padding: 8px 12px;
            border-radius: 10px;
            background: rgba(0,0,0,0.65);
            color: var(--blanco);
            border: 1px solid rgba(255,255,255,0.06);
        }
        .pagination a:hover {
            background: var(--naranja-principal);
            color: #1a1a1a;
            transform: translateY(-2px);
        }

        /* ----- MODALES ----- */
        .fixed.z-10.inset-0.overflow-y-auto,
        .fixed.inset-0.bg-\[\#9b9b9b2d\] {
            backdrop-filter: blur(3px);
        }

        .inline-block.align-bottom.bg-white,
        .bg-\[\#ffffff\].p-6.rounded-lg {
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 36px 80px rgba(0,0,0,0.9);
        }

        .inline-block.align-bottom.bg-white h3,
        .bg-\[\#ffffff\].p-6.rounded-lg h3 {
            color: #1a1a1a;
            font-weight: 800;
        }

        .bg-gray-50 .bg-blue-600,
        button.bg-blue-600 {
            background: linear-gradient(90deg,var(--naranja-principal),var(--naranja-secundario));
            color: white;
            border: none;
            border-radius: 10px;
            padding: .6rem 1rem;
        }

        .bg-gray-50 button.bg-white,
        button.bg-white {
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,0.08);
            color: #1a1a1a;
        }

        /* enlaces / imágenes base */
        a { text-decoration: none; }
        img { display:block; }

        /* Preview imagen en formularios */
        img[src^="/storage/img/"],
        img[alt="Preview"] {
            max-width: 100%;
            height: auto;
            display: block;
            margin-top: 8px;
            border-radius: 6px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        /* BADGE DE PENDIENTES */
        .pendientes-wrapper { position: relative; display: inline-block; }
        .pendientes-badge {
            position: absolute;
            top: -10px;
            right: -8px;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: white;
            background: var(--rojo);
            border-radius: 999px;
            box-shadow: 0 4px 8px rgba(0,0,0,.6);
            border: 2px solid rgba(0,0,0,0.6);
            z-index:50;
            line-height: 1;
        }
        @media (max-width:640px) {
            .pendientes-badge{
                top:-8px;
                right:-6px;
                min-width:18px;
                height:18px;
                font-size:10px;
            }
        }
    </style>

    <header class="font-bold">
        <div class="flex items-center justify-between">
            <!-- Logo a la izquierda -->
            <div class="flex-none w-20">
                <img width="250" src="/img/chiq.png" class="logo" alt="logo-izq">
            </div>
    
            <!-- Título centrado -->
            <div class="flex-1 text-center">
                <a class="Pizz text-white text-6xl" href="{{route('home')}}">AMERICAN BURGUER</a>
            </div>
    
            <!-- Logo a la derecha -->
            <div class="flex-none w-20">
                <img width="250" src="/img/chiq.png" class="logo" alt="logo-der">
            </div>
        </div>
    </header>
    
    
    <!-- buscador y menú -->
    <div class="flex ...">
        <div class="flex-auto w-64 ...">
            <div class="menu">
                <nav class="flex justify-center space-x-1 items-center flex-wrap gap-2">
                    <a href="{{route('ofertas.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">OFERTAS</a>
                    <a href="{{route('categoria.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">CATEGORÍAS</a>

                    @auth('web')
                        <a href="{{route('ventas.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">VENTA</a>
                        <a href="{{route('cliente.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">CLIENTES</a>
                        <a href="{{route('usuarios.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">USUARIOS</a>
                        <a href="{{route('empresa.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">EMPRESA</a>
                        <a href="{{route('producto.create')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">PRODUCTOS</a>

                        <!-- PENDIENTES -->
                        <div class="pendientes-wrapper" aria-hidden="false" style="display:inline-block;">
                            <a href="{{route('pendientes.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">PENDIENTES</a>
                            @if($pendientes > 0)
                                <span class="pendientes-badge" title="{{ $pendientes }} ventas pendientes" aria-label="{{ $pendientes }} ventas pendientes">
                                    {{ $pendientes > 9 ? '9+' : $pendientes }}
                                </span>
                            @endif
                        </div>
                    @endauth
            
                    @if (!Auth::guard('web')->check() && !Auth::guard('clientes')->check())
                        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Login</a>
                    @endif
        
                    @auth('web')
                        <p class="text-black font-bold ml-3">Bienvenido, {{ Auth::guard('web')->user()->nombre }}</p>
                        <form action="{{ route('logout') }}" method="POST" class="inline ml-3">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Cerrar sesión</button>
                        </form>
                    @endauth

                    @auth('clientes')
                        <p class="text-black font-bold ml-3">Bienvenido, {{ Auth::guard('clientes')->user()->nombre }}</p>
                        <form action="{{ route('logout') }}" method="POST" class="inline ml-3">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Cerrar sesión</button>
                        </form>
                    @endauth
                </nav>
            </div>
        </div>
    </div>

    <section>
        @yield('content')
    </section>

    <h2 class="text-6xl font-bold text-center mb-8">NUESTRA UBICACIÓN</h2>
    <div class="flex justify-center px-4 pb-8">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.12345!2d-122.0858482!3d37.4221316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fba5cd6d3456b:0x123abc4567def89!2sGoogleplex!5e0!3m2!1sen!2sus!4v1601234567890!5m2!1sen!2sus" 
            width="100%" 
            height="250" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            class="rounded-md shadow-md">
        </iframe>
    </div>

    @livewire('modal-ticket')
</body>

<footer class="text-white py-10">
    <div class="redes">
        <div class="flex-auto space-x-4">
            <a href="#">
                <i class="fab fa-facebook fa-2x"></i>
            </a>
            <a href="#">
                <i class="fab fa-twitter fa-2x"></i>
            </a>
            <a href="#">
                <i class="fab fa-instagram fa-2x"></i>
            </a>
            <a href="#">
                <i class="fab fa-youtube fa-2x"></i>
            </a>
        </div>
    </div>
</footer>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>

@livewireScripts
@stack('scripts')

</html>
