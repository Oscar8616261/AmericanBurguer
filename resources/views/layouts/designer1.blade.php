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
        /* ==== PALETA PROFESIONAL ==== */
    :root {
        --azul-principal: #0A3D91;
        --azul-secundario: #0F52BA;
        --azul-oscuro: #072C6B;
        --celeste: #4FB6FF;
        --blanco: #ffffff;
        --gris-suave: #e8eef6;
    }

    /* ==== FONDO GENERAL ==== */
    /* FONDO COMPLETO SOLO PARA EL BODY */
    body {
        background: #0A3D91; /* azul sólido profesional */
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        width: 100%;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        color: white; /* texto blanco */
    }


    /* ==== ENCABEZADO ==== */
    header {
        background: linear-gradient(90deg, var(--azul-oscuro), var(--azul-secundario));
        padding: 15px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25);
    }

    header .logo {
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, .4));
    }

    /* Título principal */
    .Pizz {
        color: var(--blanco);
        font-weight: 900;
        letter-spacing: 2px;
        text-shadow: 0 3px 8px rgba(0,0,0,0.4);
    }

    /* ==== MENÚ ==== */
    .menu nav a,
    .menu nav button {
        background: var(--azul-secundario);
        color: var(--blanco) !important;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 700;
        border: 1px solid rgba(255,255,255,0.15);
        transition: 0.2s ease-in-out;
    }

    .menu nav a:hover,
    .menu nav button:hover {
        background: var(--celeste);
        color: var(--azul-oscuro) !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(0,0,0,0.25);
    }

    /* Texto de bienvenida */
    .menu nav p {
        background: rgba(255,255,255,0.15);
        padding: 6px 12px;
        border-radius: 8px;
    }

    /* Logout más elegante */
    .menu nav form button {
        background: #d62828;
        color: var(--blanco);
        border-radius: 10px;
    }
    .menu nav form button:hover {
        background: #ff4545;
    }

    /* ==== CONTENIDO ==== */
    /* Hacer que la sección de contenido ocupe todo el ancho */
    section {
        width: 100%;
        max-width: 100% !important;
        padding: 40px 20px;
        background: var(--azul-principal);/* o el color que tengas */
        border-radius: 0px; /* quitar bordes redondeados si molestan */
        margin: 0;
    }


    /* TITULOS */
    h2, h1, h3 {
        color: var(--blanco);
        text-shadow: 0 2px 6px rgba(0,0,0,0.4);
    }

    /* ==== IFRAME MAPA ==== */
    iframe {
        border: 2px solid var(--celeste);
        box-shadow: 0 6px 20px rgba(0,0,0,0.35);
    }

    /* ==== FOOTER ==== */
    footer {
        background: var(--azul-oscuro);
        color: var(--blanco);
        padding: 30px;
        border-top: 4px solid var(--celeste);
        text-align: center;
    }

    footer .fab {
        color: var(--celeste);
        transition: 0.2s;
    }
    footer .fab:hover {
        color: var(--blanco);
        transform: translateY(-5px);
    }

    /* ==== SWIPER ==== */
    .swiper-container {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 26px rgba(0,0,0,0.3);
    }

    /* =========================
   MEJORA DE DISEÑO GLOBAL
   Pegar al final de tu estilo actual
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

    /* Input de búsqueda (más grande, borde suave, sombra) */
    [class*="flex-auto"].w-32 input[type="search"] {
    width: calc(100% - 160px); /* deja espacio para botones */
    max-width: 520px;
    min-width: 220px;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.06);
    color: var(--blanco);
    box-shadow: 0 6px 18px rgba(3,19,58,0.16);
    outline: none;
    }

    /* Placeholder más suave */
    [class*="flex-auto"].w-32 input[type="search"]::placeholder {
    color: rgba(255,255,255,0.65);
    }

    /* Botón "buscar" */
    [class*="flex-auto"].w-32 button.bg-\[hsl\(25\,95%\,53%\)\],
    [class*="flex-auto"].w-32 button[wire\\:click] {
    background: linear-gradient(90deg,var(--celeste), #ff8f3e);
    color: #072C6B;
    padding: 10px 18px;
    border-radius: 12px;
    box-shadow: 0 8px 22px rgba(11,79,216,0.12);
    border: none;
    font-weight: 700;
    }

    /* Botón Nuevo (rojo) */
    [class*="flex-auto"].w-32 button.bg-\[\#db1b1b\],
    [class*="flex-auto"].w-32 button[data-modal-toggle] {
    background: linear-gradient(180deg,#d62828,#b81717);
    color: var(--blanco);
    border: none;
    padding: 10px 14px;
    border-radius: 12px;
    }
    [class*="flex-auto"].w-32 button:hover { transform: translateY(-3px); }

    /* ----- SECCIÓN DE PRODUCTOS ----- */
    /* Dirigimos al bloque con tu clase bg (compatibilidad con Tailwind-like classes) */
    [class*="bg-[#e8e8eb]"],
    .bg-\[\#e8e8eb\],
    [class*="bg-\\[\\#e8e8eb\\]"] {
    background: rgba(255,255,255,0.06); /* ligeramente translúcido para ver el azul detrás */
    padding: 48px 24px;
    border-radius: 14px;
    box-shadow: 0 14px 40px rgba(2,18,60,0.20);
    margin: 28px auto;
    max-width: 1180px;
    }

    /* Título dentro del bloque */
    [class*="bg-[#e8e8eb]"] h2.text-6xl,
    .bg-\[\#e8e8eb\] h2.text-6xl {
    color: var(--blanco);
    text-shadow: 0 8px 22px rgba(3,19,58,0.45);
    font-size: clamp(1.8rem, 3.2vw, 3.2rem);
    margin-bottom: 8px;
    }

    /* Línea divisoria estilizada */
    [class*="bg-[#e8e8eb]"] > .w-full.h-1,
    .bg-\[\#e8e8eb\] > .w-full.h-1 {
    height: 3px;
    background: linear-gradient(90deg,var(--celeste), rgba(255,255,255,0.18));
    opacity: .95;
    margin: 12px auto 28px;
    border-radius: 4px;
    max-width: 95%;
    }

    /* Grid de productos: cards limpias */
    .container.mx-auto.grid {
    max-width: 1100px;
    margin: 0 auto;
    }

    /* tarjeta producto */
    .shadow-lg.rounded-lg.overflow-hidden {
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.98));
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 18px 40px rgba(3,19,58,0.12);
    border: 1px solid rgba(3,19,58,0.06);
    transition: transform .18s ease, box-shadow .18s ease;
    }

    /* hover tarjeta */
    .shadow-lg.rounded-lg.overflow-hidden:hover {
    transform: translateY(-8px) scale(1.008);
    box-shadow: 0 28px 60px rgba(3,19,58,0.18);
    }

    /* imagen producto */
    .shadow-lg.rounded-lg.overflow-hidden img {
    height: 220px;
    width: 100%;
    object-fit: cover;
    display:block;
    }

    /* cuerpo de tarjeta */
    .shadow-lg.rounded-lg.overflow-hidden .p-4 {
    padding: 18px;
    background: transparent;
    }

    /* nombre producto */
    .shadow-lg.rounded-lg.overflow-hidden h3 {
    color: #072C6B;
    font-weight: 800;
    letter-spacing: .4px;
    margin-bottom: 8px;
    }

    /* descripcion */
    .shadow-lg.rounded-lg.overflow-hidden p.text-gray-600,
    .shadow-lg.rounded-lg.overflow-hidden p {
    color: rgba(3,19,58,0.75);
    font-size: .95rem;
    min-height: 42px;
    }

    /* precio y categoria */
    .shadow-lg.rounded-lg.overflow-hidden p.font-bold {
    color: #0A3D91;
    font-size: 1.05rem;
    }
    .shadow-lg.rounded-lg.overflow-hidden p.text-orange-500 {
    color: #ff8f3e;
    font-weight: 800;
    }

    /* botones dentro de tarjeta */
    .shadow-lg.rounded-lg.overflow-hidden .flex > button {
    padding: 10px;
    border-radius: 10px;
    font-weight: 700;
    }

    /* estilos por tipo de rol (mantener colores) */
    .shadow-lg.rounded-lg.overflow-hidden .bg-[#f97316],
    .shadow-lg.rounded-lg.overflow-hidden button.bg-\[\\#f97316\\] {
    background: linear-gradient(90deg,#ff9b59,#f97316);
    color: white;
    border: none;
    }
    .shadow-lg.rounded-lg.overflow-hidden .bg-blue-500,
    .shadow-lg.rounded-lg.overflow-hidden button.bg-blue-500 {
    background: linear-gradient(90deg,#0f52ba,#0a3d91);
    color: white;
    border: none;
    }
    .shadow-lg.rounded-lg.overflow-hidden .bg-red-500,
    .shadow-lg.rounded-lg.overflow-hidden button.bg-red-500 {
    background: linear-gradient(90deg,#d62828,#b71c1c);
    color: white;
    border: none;
    }

    /* botones a ancho completo en móviles */
    @media (max-width: 768px) {
    .shadow-lg.rounded-lg.overflow-hidden .flex > button { width: 100%; }
    [class*="flex-auto"].w-32 input[type="search"] { width: 100%; max-width: none; }
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
    background: rgba(255,255,255,0.06);
    color: var(--blanco);
    border: 1px solid rgba(255,255,255,0.06);
    }
    .pagination a:hover { background: var(--celeste); color: #072C6B; transform: translateY(-2px); }

    /* ----- MODALES ----- */
    /* overlay */
    .fixed.z-10.inset-0.overflow-y-auto,
    .fixed.inset-0.bg-\[\#9b9b9b2d\] {
    backdrop-filter: blur(3px);
    }

    /* modal dialog general */
    .inline-block.align-bottom.bg-white,
    .bg-\[\#ffffff\].p-6.rounded-lg {
    border-radius: 12px;
    padding: 18px;
    box-shadow: 0 36px 80px rgba(2,18,60,0.28);
    }

    /* cabeceras dentro de modal */
    .inline-block.align-bottom.bg-white h3,
    .bg-\[\#ffffff\].p-6.rounded-lg h3 {
    color: #072C6B;
    font-weight: 800;
    }

    /* botones dentro de modal: primary */
    .bg-gray-50 .bg-blue-600,
    button.bg-blue-600 {
    background: linear-gradient(90deg,#0f52ba,#0a3d91);
    color: white;
    border: none;
    border-radius: 10px;
    padding: .6rem 1rem;
    }

    /* boton cancelar */
    .bg-gray-50 button.bg-white,
    button.bg-white {
    border-radius: 10px;
    border: 1px solid rgba(3,19,58,0.06);
    color: #072C6B;
    }

    /* ----- pequeños ajustes visuales ----- */
    a { text-decoration: none; }
    img { display:block; }

    /* === Imágenes de producto: aspecto limpio y consistente === */

    /* Selector que coincide con tus tarjetas actuales */
    .bg-white.shadow-lg.rounded-lg.overflow-hidden img,
    .product-card img {
    display: block;
    width: auto;               /* que no se estiren horizontalmente */
    max-width: 100%;           /* no salen del contenedor */
    height: 260px;            /* alto uniforme en desktop */
    max-height: 320px;        /* tope por si la imagen es muy alta */
    object-fit: contain;      /* muestra toda la imagen sin recortarla */
    background: #f7fafc;      /* fondo suave detrás de la imagen */
    padding: 18px;            /* espacio alrededor para que "respire" */
    border-bottom: 1px solid rgba(3,19,58,0.04);
    transition: transform .22s ease, box-shadow .22s ease;
    margin: 0 auto;
    box-shadow: 0 8px 20px rgba(3,19,58,0.06);
    border-radius: 8px;
    }

    /* Efecto hover: ligero zoom (no exagerado) */
    .bg-white.shadow-lg.rounded-lg.overflow-hidden:hover img,
    .product-card:hover img {
    transform: scale(1.03);
    box-shadow: 0 18px 40px rgba(3,19,58,0.10);
    }

    /* Versión responsiva para móviles: menos alto */
    @media (max-width: 768px) {
    .bg-white.shadow-lg.rounded-lg.overflow-hidden img,
    .product-card img {
        height: 200px;
        padding: 12px;
    }
    }

    /* Si prefieres que las imágenes se recorten (llenando el área), cambiar object-fit a cover:
    object-fit: cover;
    y quitar padding si no quieres espacio interno.
    */

    /* === Preview de la imagen (en el modal/form) === */
    img[src^="/storage/img/"],
    img[alt="Preview"] {
    max-width: 100%;
    height: auto;
    display: block;
    margin-top: 8px;
    border-radius: 6px;
    box-shadow: 0 8px 20px rgba(3,19,58,0.06);
    }

    /* ======= OVERRIDES PARA TARJETAS: quitar huecos entre nombre / estrellas / descripción / precio / categoría ======= */

    /* Menos padding en el cuerpo de la tarjeta para compactar todo */
    .shadow-lg.rounded-lg.overflow-hidden .p-4 {
    padding: 12px !important;
    }

    /* Nombre: pequeño gap debajo */
    .shadow-lg.rounded-lg.overflow-hidden h3 {
    margin: 0 0 4px 0 !important;
    line-height: 1.05 !important;
    }

    /* Quitar márgenes por defecto en TODOS los párrafos dentro de la tarjeta */
    .shadow-lg.rounded-lg.overflow-hidden p {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.12 !important;
    }

    /* Descripción: permitir hasta 2 líneas pero sin huecos (quita min-height si existe) */
    .shadow-lg.rounded-lg.overflow-hidden p.text-gray-600,
    .shadow-lg.rounded-lg.overflow-hidden p.description {
    margin-bottom: 6px !important;
    min-height: 0 !important;
    line-height: 1.15 !important;
    font-size: .95rem;
    }

    /* Precio y categoría: forzar que estén pegados (sin margen) y con line-height compacto */
    .shadow-lg.rounded-lg.overflow-hidden p.font-bold,
    .shadow-lg.rounded-lg.overflow-hidden p.text-orange-500 {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1 !important;
    }

    /* Si usas <div> para agrupar precio/categoría, asegúrate que no tenga gap grande */
    .shadow-lg.rounded-lg.overflow-hidden .price-category,
    .shadow-lg.rounded-lg.overflow-hidden .flex-col-no-gap {
    display: flex;
    flex-direction: column;
    gap: 2px; /* pequeño espacio entre precio y categoría */
    margin-top: 6px;
    }

    /* Imagen: reducir un poco la altura para dar más espacio al contenido */
    .bg-white.shadow-lg.rounded-lg.overflow-hidden img,
    .shadow-lg.rounded-lg.overflow-hidden img,
    .product-card img {
    height: 200px !important;
    padding: 12px !important;
    object-fit: contain !important;
    }

    /* Botones: mantener separación pero sin empujar el contenido */
    .shadow-lg.rounded-lg.overflow-hidden .mt-3 {
    margin-top: 8px !important;
    }

    /* Responsive: aún más compacto en móvil */
    @media (max-width: 768px) {
    .shadow-lg.rounded-lg.overflow-hidden img { height: 160px !important; padding: 10px !important; }
    .shadow-lg.rounded-lg.overflow-hidden .p-4 { padding: 10px !important; }
    .shadow-lg.rounded-lg.overflow-hidden h3 { font-size: 1rem; }
    }
    /* ====== OVERRIDE FINAL: eliminar ese hueco que queda abajo ====== */

    /* Hacer el contenido de la tarjeta un column flex para controlar gaps */
    .shadow-lg.rounded-lg.overflow-hidden .p-4 {
    display: flex !important;
    flex-direction: column;
    gap: 6px !important;          /* pequeño espacio entre bloques */
    padding: 12px !important;
    min-height: 0 !important;
    }

    /* Eliminar cualquier min-height/margen de párrafos dentro */
    .shadow-lg.rounded-lg.overflow-hidden p {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.12 !important;
    min-height: 0 !important;
    }

    /* Si hay un párrafo de descripción muy largo, limitar a 2 líneas (evita empujar abajo) */
    .shadow-lg.rounded-lg.overflow-hidden p.text-gray-600 {
    display: -webkit-box !important;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    }

    /* Forzar que precio y categoría estén juntos (sin gaps extra) */
    .shadow-lg.rounded-lg.overflow-hidden p.font-bold,
    .shadow-lg.rounded-lg.overflow-hidden p.text-orange-500 {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1 !important;
    }

    /* Si el precio está en un <p> seguido de la categoría, asegurar separación mínima */
    .shadow-lg.rounded-lg.overflow-hidden p.font-bold + p {
    margin-top: 2px !important;
    }

    /* Reducir padding de imagen (si el padding de la imagen empuja contenido) */
    .bg-white.shadow-lg.rounded-lg.overflow-hidden img,
    .shadow-lg.rounded-lg.overflow-hidden img {
    padding: 10px !important;
    height: 180px !important;
    object-fit: contain !important;
    }

    /* Asegurar que el área inferior de la tarjeta no tenga padding extra */
    .shadow-lg.rounded-lg.overflow-hidden {
    padding-bottom: 12px !important;
    }

    /* Móvil: aún más compacto */
    @media (max-width:768px) {
    .bg-white.shadow-lg.rounded-lg.overflow-hidden img { height: 140px !important; padding: 8px !important; }
    .shadow-lg.rounded-lg.overflow-hidden .p-4 { padding: 10px !important; gap: 6px !important; }
    }
    /* ====== AÑADIR ESPACIO ARRIBA DE LA IMAGEN ====== */
    .shadow-lg.rounded-lg.overflow-hidden img {
        margin-top: 12px !important;   /* espacio arriba */
        margin-bottom: 12px !important;/* espacio abajo (ya lo tienes, lo igualo) */
        display: block;
    }

    /* ====== ESTILOS PARA EL BADGE DE PENDIENTES (añadidos) ====== */
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
        background: #ef4444;
        border-radius: 999px;
        box-shadow: 0 4px 8px rgba(0,0,0,.25);
        border: 2px solid rgba(255,255,255,0.12);
        z-index:50;
        line-height: 1;
    }
    @media (max-width:640px) {
        .pendientes-badge{ top:-8px; right:-6px; min-width:18px; height:18px; font-size:10px; }
    }

    </style>

    <header class="bg-[blue] font-bold">
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
                <nav class="flex justify-center space-x-1 items-center">
                    <a href="{{route('ofertas.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">OFERTAS</a>
                    <a href="{{route('categoria.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">CATEGORÍAS</a>


                    
                    @auth('web')
                        <!-- Botones visibles solo para usuarios -->
                        <a href="{{route('ventas.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">VENTA</a>
                        <a href="{{route('cliente.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">CLIENTES</a>
                        <a href="{{route('usuarios.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">USUARIOS</a>
                        <a href="{{route('empresa.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">EMPRESA</a>
                        <a href="{{route('producto.create')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">PRODUCTOS</a>

                        <!-- PENDIENTES: envuelto para poder posicionar badge -->
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
                    <!-- Solo mostrar si NO está autenticado en ninguno de los guards -->
                    <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Login</a>
                @endif
        
                    @auth('web')
                        <!-- Solo mostrar si el usuario está autenticado -->
                        <p class="text-black font-bold ml-3">Bienvenido, {{ Auth::guard('web')->user()->nombre }}</p>
                        <form action="{{ route('logout') }}" method="POST" class="inline ml-3">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Cerrar sesión</button>
                        </form>
                    @endauth
                    @auth('clientes')
                        <!-- Solo mostrar si el cliente está autenticado -->
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
    <div>
       
    </div>
    <section>
        @yield('content')
        
    </section>
    <h2 class="text-6xl font-bold text-center mb-8">NUESTRA UBICACIÓN</h2>
    <div class="flex justify-center">
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
</body>
<footer class="bg-[#253399] text-white py-10">
    <div class="redes">
    <!-- Íconos de redes sociales -->
        <div class="flex-auto" >
            <a href="#" class="text-blue-700 hover:text-blue-400">
                <i class="fab fa-facebook fa-2x"></i>
                </a>
                <a href="#" class="text-blue-400 hover:text-blue-300">
                <i class="fab fa-twitter fa-2x"></i>
                </a>
                <a href="#" class="text-pink-500 hover:text-pink-400">
                <i class="fab fa-instagram fa-2x"></i>
                </a>
                <a href="#" class="text-red-500 hover:text-red-400">
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
