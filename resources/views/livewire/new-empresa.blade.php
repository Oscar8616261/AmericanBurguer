<div class="py-10"
     style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 60%, #050505 100%);">
    <h2 class="text-4xl md:text-6xl font-extrabold text-center mb-6 text-[#ff7a00] drop-shadow-md">
        NUEVA EMPRESA
    </h2>

    <div class="max-w-md mx-auto bg-white p-6 rounded-2xl shadow-2xl border border-gray-200">
        <!-- Nombre -->
        <div class="mb-4">
            <label for="nombre" class="block mb-2 text-sm font-semibold text-gray-800">
                Nombre
            </label>
            <input
                wire:model="nombre"
                id="nombre"
                name="nombre"
                type="text"
                placeholder="Nombre"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                       focus:ring-[#ff7a00] focus:border-[#ff7a00]
                       block w-full p-2.5"
                required
            />
            @error('nombre')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Dirección -->
        <div class="mb-4">
            <label for="direccion" class="block mb-2 text-sm font-semibold text-gray-800">
                Dirección
            </label>
            <input
                wire:model="direccion"
                id="direccion"
                name="direccion"
                type="text"
                placeholder="Dirección"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                       focus:ring-[#ff7a00] focus:border-[#ff7a00]
                       block w-full p-2.5"
                required
            />
            @error('direccion')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Lat-Log -->
        <div class="mb-6">
            <label for="latLog" class="block mb-2 text-sm font-semibold text-gray-800">
                Lat-Long
            </label>
            <input
                wire:model="latLog"
                id="latLog"
                name="latLog"
                type="text"
                placeholder="Lat-Long"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                       focus:ring-[#ff7a00] focus:border-[#ff7a00]
                       block w-full p-2.5"
                required
            />
            @error('latLog')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Botones -->
        <div class="flex justify-between gap-3">
            <button
                wire:click="enviarClick()"
                type="button"
                class="flex-1 text-black bg-[#ff7a00] hover:bg-[#ff9d2e]
                       focus:ring-4 focus:outline-none focus:ring-[#ff7a00]/40
                       font-semibold rounded-lg text-sm px-5 py-2.5 shadow-md text-center">
                Enviar
            </button>

            <a href="{{ route('empresa.listar') }}"
               class="flex-1 text-white bg-[#d6452f] hover:bg-red-700
                      font-semibold rounded-lg text-sm px-5 py-2.5
                      focus:outline-none focus:ring-4 focus:ring-red-500/40
                      text-center shadow-md">
                Cancelar
            </a>
        </div>
    </div>
</div>
