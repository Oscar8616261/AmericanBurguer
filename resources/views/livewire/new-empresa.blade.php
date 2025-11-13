
<div>
    <h2 class="text-6xl font-bold text-center mb-8">NUEVA EMPRESA</h2>
    <div class="max-w-md mx-auto bg-white p-5 rounded-lg shadow-md dark:bg-gray-800">
        <!-- Nombre -->
        <div class="mb-4">
            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
            <input wire:model="nombre" id="nombre" name="nombre" type="text" placeholder="Nombre"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>

        <!-- Dirección -->
        <div class="mb-4">
            <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
            <input wire:model="direccion" id="direccion" name="direccion" type="text" placeholder="Dirección"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>

        <!-- Lat-Log -->
        <div class="mb-4">
            <label for="latLog" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lat-Long</label>
            <input wire:model="latLog" id="latLog" name="latLog" type="text" placeholder="Lat-Long"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
        </div>

        <!-- Botones -->
        <div class="flex justify-between">
            <button wire:click="enviarClick()" type="button"
                class="text-[#ffffff] bg-[#1b68db] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enviar</button>
            <a href="{{ route('empresa.listar') }}"
                class="text-[#ffffff] bg-[#db1b1b] hover:bg-orange-600 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none focus:ring-4 focus:ring-orange-300 dark:focus:ring-orange-800 dark:bg-orange-500 dark:hover:bg-orange-600 dark:text-white">Cancelar</a>
        </div>
    </div>
</div>