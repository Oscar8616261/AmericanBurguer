<div class="bg-[#e8e8eb] py-10">
  <h2 class="text-6xl font-bold text-center mb-8">NUEVO CLIENTE</h2>

  <div class="max-w-md mx-auto shadow-lg rounded-lg overflow-hidden bg-white p-6">
    <!-- Nombre -->
    <div class="mb-4">
      <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
      <input wire:model="nombre" id="nombre" name="nombre" type="text" placeholder="Nombre"
             class="block w-full px-4 py-2 text-sm rounded-lg border border-gray-300 bg-transparent focus:outline-none focus:border-blue-600 peer" required />
    </div>

    <!-- Apellidos -->
    <div class="mb-4">
      <label for="apellidos" class="block mb-2 text-sm font-medium text-gray-900">Apellidos</label>
      <input wire:model="apellidos" id="apellidos" name="apellidos" type="text" placeholder="Apellidos"
             class="block w-full px-4 py-2 text-sm rounded-lg border border-gray-300 bg-transparent focus:outline-none focus:border-blue-600 peer" required />
    </div>

    <!-- CI -->
    <div class="mb-4">
      <label for="ci" class="block mb-2 text-sm font-medium text-gray-900">CI</label>
      <input wire:model="ci" id="ci" name="ci" type="text" placeholder="CI"
             class="block w-full px-4 py-2 text-sm rounded-lg border border-gray-300 bg-transparent focus:outline-none focus:border-blue-600 peer" required />
    </div>

    <!-- NIT -->
    <div class="mb-4">
      <label for="nit" class="block mb-2 text-sm font-medium text-gray-900">NIT</label>
      <input wire:model="nit" id="nit" name="nit" type="text" placeholder="NIT"
             class="block w-full px-4 py-2 text-sm rounded-lg border border-gray-300 bg-transparent focus:outline-none focus:border-blue-600 peer" required />
    </div>

    <!-- Email -->
    <div class="mb-6">
      <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
      <input wire:model="email" id="email" name="email" type="email" placeholder="Email"
             class="block w-full px-4 py-2 text-sm rounded-lg border border-gray-300 bg-transparent focus:outline-none focus:border-blue-600 peer" required />
    </div>

    <!-- Botones -->
    <div class="flex gap-3">
      <button wire:click="enviarClick()" type="button"
              class="flex-1 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 shadow-sm">
        Enviar
      </button>

      <a href="{{ route('cliente.listar') }}"
         class="flex-1 text-white bg-[#db1b1b] hover:bg-orange-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-sm">
        Cancelar
      </a>
    </div>
  </div>

  <!-- línea inferior -->
  <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mt-8" style="max-width:95%;"></div>
</div>
