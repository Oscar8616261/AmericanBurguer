
@extends('layouts.designer1')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center bg-gradient-to-br from-[#0A3D91] via-[#1A4FB3] to-[#0A3D91] p-6">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-blue-700 text-white px-6 py-5">
            <h1 class="text-2xl font-extrabold tracking-wide">American Burger</h1>
            <p class="text-sm opacity-90">Bienvenido, inicia sesión para continuar</p>
        </div>

        <div class="px-6 py-6">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="mt-1 w-full px-4 py-2 border rounded-lg text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-700">Cédula de Identidad (CI)</label>
                    <input type="password" name="ci" id="ci" class="mt-1 w-full px-4 py-2 border rounded-lg text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg">Iniciar Sesión</button>
                    <a href="{{ route('cliente.registrar') }}" class="flex-1 text-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-lg">Registrarme</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection