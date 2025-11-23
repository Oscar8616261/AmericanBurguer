<div class="py-10"
     style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 50%, #050505 100%);">

    <h2 class="text-6xl font-extrabold text-center mb-10 text-[#ff7a00] drop-shadow-md tracking-wide">
        NUEVA CATEGORÍA
    </h2>

    <div class="max-w-md mx-auto bg-[#181818] border border-black/50 p-6 rounded-2xl shadow-2xl text-white">

        <!-- Nombre -->
        <div class="mb-5">
            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-300">
                Nombre
            </label>
            <input wire:model="nombre"
                   id="nombre"
                   name="nombre"
                   type="text"
                   placeholder="Nombre"
                   class="w-full p-2.5 rounded-lg bg-[#2a2a2a] border border-black/50 text-white
                          placeholder-gray-400 focus:ring-[#ff7a00] focus:border-[#ff7a00]">
        </div>

        <!-- Descripción -->
        <div class="mb-5">
            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-300">
                Descripción
            </label>
            <input wire:model="descripcion"
                   id="descripcion"
                   name="descripcion"
                   type="text"
                   placeholder="Descripción"
                   class="w-full p-2.5 rounded-lg bg-[#2a2a2a] border border-black/50 text-white
                          placeholder-gray-400 focus:ring-[#ff7a00] focus:border-[#ff7a00]">
        </div>

        <!-- Foto -->
        <div class="mb-6">
            <label for="foto" class="block mb-2 text-sm font-medium text-gray-300">
                Foto
            </label>
            <input wire:model="foto"
                   name="foto"
                   type="file"
                   class="w-full p-2.5 rounded-lg bg-[#2a2a2a] border border-black/50 text-white
                          focus:ring-[#ff7a00] focus:border-[#ff7a00]">
        </div>

        <!-- Botones -->
        <div class="flex justify-between gap-3">
            <button wire:click="enviarClick()"
                type="button"
                class="flex-1 bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold py-2.5 rounded-lg shadow-md transition">
                Enviar
            </button>

            <a href="{{ route('categoria.listar') }}"
               class="flex-1 text-center bg-[#d6452f] hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition">
                Cancelar
            </a>
        </div>
    </div>
</div>
