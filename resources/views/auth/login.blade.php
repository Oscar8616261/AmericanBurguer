@extends('layouts.designer1')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center"
     style="background: radial-gradient(circle at top left, #2b2b2b 0%, #161616 40%, #050505 100%);">

    <div class="w-full max-w-lg bg-[#181818] rounded-2xl shadow-2xl overflow-hidden border border-black/40">

        <!-- HEADER -->
        <div class="bg-[#ff7a00] text-black px-6 py-5">
            <h1 class="text-2xl font-extrabold tracking-wide">American Burger</h1>
            <p class="text-sm opacity-90">Bienvenido, inicia sesión para continuar</p>
        </div>

        <!-- FORMULARIO -->
        <div class="px-6 py-6 text-white">

            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Correo Electrónico</label>
                    <input type="email" name="email" id="email"
                           class="mt-1 w-full px-4 py-2 border rounded-lg bg-[#2a2a2a] text-white placeholder-gray-400 
                           focus:outline-none focus:ring-2 focus:ring-[#ff7a00] border-black/40"
                           required>
                </div>

                <!-- CI -->
                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-300">Cédula de Identidad (CI)</label>
                    <input type="password" name="ci" id="ci"
                           class="mt-1 w-full px-4 py-2 border rounded-lg bg-[#2a2a2a] text-white placeholder-gray-400 
                           focus:outline-none focus:ring-2 focus:ring-[#ff7a00] border-black/40"
                           required>
                </div>

                <!-- BOTÓN -->
                <button type="submit"
                        class="w-full bg-[#ff7a00] hover:bg-[#ff9d2e] transition text-black font-bold py-2.5 rounded-lg shadow-md">
                    Iniciar Sesión
                </button>

                <!-- ENLACE REGISTRARME -->
                <p class="text-center text-gray-300 text-sm mt-2">
                    ¿No tienes una cuenta?
                    <a href="{{ route('cliente.registrar') }}"
                       class="text-[#ffcc4d] hover:text-[#ff9d2e] font-semibold transition underline">
                        Registrarme
                    </a>
                </p>

            </form>
        </div>
    </div>
</div>
@endsection
