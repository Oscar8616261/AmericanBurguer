<div class="py-10"
     style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 60%, #050505 100%);">

    <h2 class="text-6xl font-extrabold text-center mb-10 text-[#ff7a00] tracking-wide drop-shadow-md">
        NUEVO PRODUCTO
    </h2>

    <div class="max-w-md mx-auto bg-[#181818] p-6 rounded-2xl shadow-2xl border border-black/60 text-white">

        <!-- Nombre -->
        <div class="mb-5">
            <label for="nombre" class="block mb-1 text-sm font-medium text-gray-300">Nombre</label>
            <input wire:model="nombre" id="nombre" name="nombre" type="text" placeholder="Nombre"
                   class="w-full p-2.5 rounded-lg bg-[#2a2a2a] text-white border border-black/60
                          placeholder-gray-400 focus:ring-[#ff7a00] focus:border-[#ff7a00]">
        </div>

        <!-- Descripción -->
        <div class="mb-5">
            <label for="descripcion" class="block mb-1 text-sm font-medium text-gray-300">Descripción</label>
            <input wire:model="descripcion" id="descripcion" name="descripcion" type="text" placeholder="Descripción"
                   class="w-full p-2.5 rounded-lg bg-[#2a2a2a] text-white border border-black/60
                          placeholder-gray-400 focus:ring-[#ff7a00] focus:border-[#ff7a00]">
        </div>

        <!-- Precio -->
        <div class="mb-5">
            <label for="precio" class="block mb-1 text-sm font-medium text-gray-300">Precio</label>
            <input wire:model="precio" id="precio" name="precio" type="text" placeholder="Precio"
                   class="w-full p-2.5 rounded-lg bg-[#2a2a2a] text-white border border-black/60
                          placeholder-gray-400 focus:ring-[#ff7a00] focus:border-[#ff7a00]">
        </div>

        <!-- Cantidad -->
        <div class="mb-5">
            <label for="stock" class="block mb-1 text-sm font-medium text-gray-300">Cantidad</label>
            <input wire:model="stock" id="stock" name="stock" type="number" placeholder="Cantidad"
                   class="w-full p-2.5 rounded-lg bg-[#2a2a2a] text-white border border-black/60
                          placeholder-gray-400 focus:ring-[#ff7a00] focus:border-[#ff7a00]">
        </div>

        <!-- Categoría -->
        <div class="mb-5">
            <label for="categoria" class="block mb-1 text-sm font-medium text-gray-300">Categoría</label>
            <select wire:model="categoria" id="categoria" name="id_categoria"
                    class="w-full p-2.5 rounded-lg bg-[#2a2a2a] text-white border border-black/60
                           focus:ring-[#ff7a00] focus:border-[#ff7a00]">

                <option value="" hidden>Seleccione una categoría</option>
                @foreach ($categorias as $item)
                    <option value="{{ $item->id_categoria }}">{{ $item->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Foto -->
        <div class="mb-6">
            <label for="foto" class="block mb-1 text-sm font-medium text-gray-300">Foto</label>
            <input wire:model="foto" name="foto" type="file"
                   class="w-full p-2.5 rounded-lg bg-[#2a2a2a] text-white border border-black/60
                          focus:ring-[#ff7a00] focus:border-[#ff7a00]">
        </div>

        <!-- Botones -->
        <div class="flex justify-between gap-3">
            <button wire:click="enviarClick()" type="button"
                    class="flex-1 py-2.5 rounded-lg bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold shadow-md transition">
                Enviar
            </button>

            <a href="{{ route('home') }}"
               class="flex-1 py-2.5 rounded-lg text-center bg-[#d6452f] hover:bg-red-700 text-white font-semibold shadow-md transition">
                Cancelar
            </a>
        </div>
    </div>
</div>
