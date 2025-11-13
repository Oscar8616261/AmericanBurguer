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
    <style>
        .Pizz {
            font-size: 7ch;
            text-align: center;
        }
        .redes {
            text-align: center;
        }
    </style>
    <header class="bg-[blue] font-bold">
        <div class="flex items-center justify-between">
            <!-- Logo a la izquierda -->
            <div class="flex-none w-20">
                <img width="250" src="/img/pizzalogo.webp" class="logo">
            </div>
    
            <!-- Título centrado -->
            <div class="flex-1 text-center">
                <a class="Pizz text-white" href="{{route('home')}}">AMERICAN BURGUER</a>
            </div>
    
            <!-- Logo a la derecha -->
            <div class="flex-none w-20">
                <img width="250" src="/img/pizzalogo.webp" class="logo">
            </div>
        </div>
    </header>
    
    
    <!-- buscador y menú -->
    <div class="flex ...">
        
        <div class="flex-auto w-64 ...">
            <div class="menu">
                <nav class="flex justify-center space-x-1">
                    <a href="{{route('ofertas.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">OFERTAS</a>
                    <a href="{{route('categoria.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">CATEGORÍAS</a>


                    
                    @auth('web')
                        <!-- Botones visibles solo para usuarios -->
                        <a href="{{route('ventas.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">VENTA</a>
                        <a href="{{route('cliente.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">CLIENTES</a>
                        <a href="{{route('usuarios.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">USUARIOS</a>
                        <a href="{{route('empresa.listar')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">EMPRESA</a>
                        <a href="{{route('producto.create')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">PRODUCTOS</a>
                        <a href="{{route('pendientes.index')}}" class="bg-[#f97316] font-bold px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">PENDIENTES</a>
                    @endauth
            
                    @if (!Auth::guard('web')->check() && !Auth::guard('clientes')->check())
                    <!-- Solo mostrar si NO está autenticado en ninguno de los guards -->
                    <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Login</a>
                @endif
        
                    @auth('web')
                        <!-- Solo mostrar si el usuario está autenticado -->
                        <p class="text-black font-bold">Bienvenido, {{ Auth::guard('web')->user()->nombre }}</p>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Cerrar sesión</button>
                        </form>
                    @endauth
                    @auth('clientes')
                        <!-- Solo mostrar si el cliente está autenticado -->
                        <p class="text-black font-bold">Bienvenido, {{ Auth::guard('clientes')->user()->nombre }}</p>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
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
<footer class="bg-[#ffbb2a] text-white py-10">
    <div class="redes">
    <!-- Íconos de redes sociales -->
        <div class="flex-auto" >
            <a href="#" class="text-blue-500 hover:text-blue-400">
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