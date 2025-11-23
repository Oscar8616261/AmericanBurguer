<div class="py-10"
     style="background: radial-gradient(circle at top left, #2b2b2b 0%, #161616 40%, #050505 100%);">
  <div class="container mx-auto px-4">

    {{-- BUSCADOR + BOTÓN NUEVO --}}
    <div class="bg-[#181818] rounded-lg shadow-lg p-4 mb-6 border border-black/40 text-white">
      <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
        <div class="w-full md:max-w-md">
          <label class="block text-sm font-medium text-gray-300 mb-1">Buscar Cliente</label>
          <div class="flex gap-2">
            <input
              wire:keydown.enter="clickBuscar()"
              type="search"
              wire:model="search"
              class="flex-1 px-4 py-2 border rounded-lg text-white bg-[#2a2a2a] placeholder-gray-400
                     focus:outline-none focus:ring-2 focus:ring-[#ff7a00] border-black/50"
              placeholder="Nombre, CI">
            <button
              wire:click="clickBuscar()"
              class="bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold px-4 py-2 rounded-lg shadow-md transition">
              Buscar
            </button>
          </div>
        </div>

        <div class="flex gap-2">
          <button
            data-modal-target="default-modal"
            wire:click="openModal()"
            data-modal-toggle="default-modal"
            class="bg-[#d6452f] hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition">
            Nuevo
          </button>
        </div>
      </div>
    </div>

    {{-- TÍTULO --}}
    <h2 class="text-5xl font-extrabold text-center mb-4 text-[#ff7a00] drop-shadow-md">CLIENTES</h2>
    <div class="w-full h-1 mx-auto rounded opacity-90 mb-6"
         style="max-width:95%; background: linear-gradient(90deg,#ff7a00,#ffcc4d);"></div>

    {{-- TABLA --}}
    <div class="bg-white rounded-lg shadow overflow-hidden border border-black/10">
      <table class="min-w-full">
        <thead>
          <tr class="bg-[#1a1a1a]">
            <th class="text-left px-6 py-3 text-white font-semibold">Nombre</th>
            <th class="text-left px-6 py-3 text-white font-semibold">Apellidos</th>
            <th class="text-left px-6 py-3 text-white font-semibold">C.I.</th>
            <th class="text-left px-6 py-3 text-white font-semibold">Dirección</th>
            <th class="text-left px-6 py-3 text-white font-semibold">Email</th>
            <th class="text-left px-6 py-3 text-white font-semibold">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse ($clientes as $item)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-900 font-medium">{{$item->nombre}}</td>
            <td class="px-6 py-4 text-gray-900">{{$item->apellidos}}</td>
            <td class="px-6 py-4 text-gray-900">{{$item->ci}}</td>
            <td class="px-6 py-4 text-gray-900">{{$item->direccion}}</td>
            <td class="px-6 py-4 text-gray-900">
              <a href="mailto:{{$item->email}}"
                 class="text-[#ff7a00] hover:text-[#ff9d2e] hover:underline">
                {{$item->email}}
              </a>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <button
                  wire:click.prevent="editar({{ $item->id_cliente }})"
                  class="bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold px-3 py-1.5 rounded shadow-sm transition">
                  <i class="fas fa-edit mr-1"></i> Editar
                </button>
                <button
                  wire:click.prevent="delete({{ $item->id_cliente }})"
                  class="bg-[#d6452f] hover:bg-red-700 text-white font-semibold px-3 py-1.5 rounded shadow-sm transition">
                  <i class="fas fa-trash-alt mr-1"></i> Borrar
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center px-6 py-8 text-gray-500">No hay clientes</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <div class="px-4 py-3 bg-white border-t border-gray-100">
        {{$clientes->links()}}
      </div>
    </div>

    {{-- MODAL --}}
    @if ($showModal)
    <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-[9999]">
      <div class="bg-[#181818] rounded-xl shadow-2xl w-full max-w-lg p-6 border border-black/60 text-white">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-[#ff7a00] font-bold text-lg">Datos del Cliente</h2>
          <button wire:click="closeModal" class="text-gray-300 hover:text-white text-xl leading-none">✕</button>
        </div>
        <form class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-200">Nombre</label>
            <input
              wire:model="nombre"
              type="text"
              class="w-full px-3 py-2 border rounded bg-[#2a2a2a] text-white
                     focus:outline-none focus:ring-2 focus:ring-[#ff7a00] border-black/60"
              required>
            @error('nombre') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-200">Apellidos</label>
            <input
              wire:model="apellidos"
              type="text"
              class="w-full px-3 py-2 border rounded bg-[#2a2a2a] text-white
                     focus:outline-none focus:ring-2 focus:ring-[#ff7a00] border-black/60"
              required>
            @error('apellidos') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-200">CI</label>
            <input
              wire:model="ci"
              type="text"
              class="w-full px-3 py-2 border rounded bg-[#2a2a2a] text-white
                     focus:outline-none focus:ring-2 focus:ring-[#ff7a00] border-black/60"
              required>
            @error('ci') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-200">Dirección</label>
            <input
              wire:model="direccion"
              type="text"
              class="w-full px-3 py-2 border rounded bg-[#2a2a2a] text-white
                     focus:outline-none focus:ring-2 focus:ring-[#ff7a00] border-black/60"
              required>
            @error('direccion') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-200">Email</label>
            <input
              wire:model="email"
              type="email"
              class="w-full px-3 py-2 border rounded bg-[#2a2a2a] text-white
                     focus:outline-none focus:ring-2 focus:ring-[#ff7a00] border-black/60"
              required>
            @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
          </div>

          <div class="flex justify-end gap-3 pt-2">
            <button
              wire:click="closeModal"
              type="button"
              class="px-4 py-2 rounded bg-gray-600 text-white hover:bg-gray-700">
              Cerrar
            </button>
            <button
              wire:click="enviarClick()"
              type="submit"
              class="px-4 py-2 rounded bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold shadow-md transition">
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
    @endif
  </div>
</div>
