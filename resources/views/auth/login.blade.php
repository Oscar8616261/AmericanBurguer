
@extends('layouts.designer1')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-5 rounded shadow">
    <h2 class="text-center text-xl text-blue-700 font-bold mb-4">Iniciar Sesión</h2>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2 text-gray-700" required>
        </div>

        <div class="mb-4">
            <label for="ci" class="block text-gray-700">Cédula de Identidad (CI)</label>
            <input type="password" name="ci" id="ci" class="w-full border rounded px-3 py-2 text-gray-700" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Iniciar Sesión
        </button>
    </form>
</div>
@endsection