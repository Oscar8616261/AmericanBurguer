<div class="bg-[#e8e8eb] py-10">
  <div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
      <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
        <div class="w-full md:max-w-md">
          <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Usuario</label>
          <div class="flex gap-2">
            <input wire:keydown.enter="clickBuscar()" type="search" wire:model="search" class="flex-1 px-4 py-2 border rounded-lg text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nombre, CI, usuario">
            <button wire:click="clickBuscar()" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg">Buscar</button>
          </div>
        </div>
        <div class="flex gap-2">
          <button data-modal-target="default-modal" wire:click="openModal()" data-modal-toggle="default-modal" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 rounded-lg">Nuevo</button>
        </div>
      </div>
    </div>

    <h2 class="text-5xl font-bold text-center mb-4 text-blue-700">USUARIOS</h2>
    <div class="w-full h-1 mx-auto bg-black rounded opacity-70 mb-6" style="max-width:95%;"></div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="min-w-full">
        <thead>
          <tr class="bg-blue-700">
            <th class="text-left px-6 py-3 text-white font-semibold">Nombre</th>
            <th class="text-left px-6 py-3 text-white font-semibold">Apellidos</th>
            <th class="text-left px-6 py-3 text-white font-semibold">C.I.</th>
            <th class="text-left px-6 py-3 text-white font-semibold">Nombre Usuario</th>
            {{-- <th class="text-left px-6 py-3 text-white font-semibold">Contraseña</th> --}}
            <th class="text-left px-6 py-3 text-white font-semibold">Tipo</th>
            <th class="text-left px-6 py-3 text-white font-semibold">Email</th>
            <th class="text-left px-6 py-3 text-white font-semibold">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @forelse ($usuarios as $item)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-900 font-medium">{{$item->nombre}}</td>
            <td class="px-6 py-4 text-gray-900">{{$item->apellidos}}</td>
            <td class="px-6 py-4 text-gray-900">{{$item->ci}}</td>
            <td class="px-6 py-4 text-gray-900">{{$item->nombre_usuario}}</td>
            {{-- <td class="px-6 py-4 text-gray-900">{{$item->contrasena}}</td> --}}
            <td class="px-6 py-4 text-gray-900">{{$item->tipo}}</td>
            <td class="px-6 py-4 text-gray-900"><a href="mailto:{{$item->email}}" class="text-blue-600 hover:underline">{{$item->email}}</a></td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <button wire:click.prevent="editar({{ $item->id_usuario }})" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 py-1.5 rounded">Editar</button>
                <button wire:click.prevent="delete({{ $item->id_usuario }})" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-3 py-1.5 rounded">Borrar</button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center px-6 py-8 text-gray-500">No hay usuarios</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <div class="px-4 py-3">
        {{$usuarios->links()}}
      </div>
    </div>

    @if ($showModal)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-[9999]">
      <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-blue-700 font-bold text-lg">Datos del Usuario</h2>
          <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900">✕</button>
        </div>
        <form class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input wire:model="nombre" type="text" class="w-full px-3 py-2 border rounded text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Apellidos</label>
            <input wire:model="apellidos" type="text" class="w-full px-3 py-2 border rounded text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('apellidos') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">CI</label>
            <input wire:model="ci" type="text" class="w-full px-3 py-2 border rounded text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('ci') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Nombre Usuario</label>
            <input wire:model="nombre_usuario" type="text" class="w-full px-3 py-2 border rounded text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('nombre_usuario') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input wire:model="contrasena" type="password" class="w-full px-3 py-2 border rounded text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('contrasena') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Tipo</label>
            <select wire:model="tipo" class="w-full px-3 py-2 border rounded text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
              <option value="" hidden></option>
              <option value="administrador">Administrador</option>
              <option value="personal">Personal</option>
            </select>
            @error('tipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input wire:model="email" type="email" class="w-full px-3 py-2 border rounded text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
          <div class="flex justify-end gap-3 pt-2">
            <button wire:click="closeModal" type="button" class="px-4 py-2 rounded bg-gray-600 text-white hover:bg-gray-700">Cerrar</button>
            <button wire:click="enviarClick()" type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Guardar</button>
          </div>
        </form>
      </div>
    </div>
    @endif
  </div>
</div>
