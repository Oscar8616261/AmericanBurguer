<div>
  <!-- buscador y acciones -->
  <div class="flex items-center justify-between px-4 py-6">
    <div class="flex-auto w-32"> <!-- coincide con tus selectores -->
      <input
        wire:keydown.enter="clickBuscar()"
        type="search"
        wire:model="search"
        class="w-full max-w-md px-4 py-2 text-sm border rounded-lg bg-transparent placeholder-opacity-75"
        placeholder="Buscar Usuario" />

      <div class="mt-3 md:mt-0 flex flex-wrap items-center gap-2">
        <button
          wire:click="clickBuscar()"
          class="bg-[hsl(25,95%,53%)] rounded-xl w-60 p-2 font-bold">
          buscar
        </button>

        <button
          data-modal-target="default-modal"
          wire:click="openModal()"
          data-modal-toggle="default-modal"
          class="bg-[#db1b1b] rounded-xl p-2 font-bold text-white">
          Nuevo
        </button>
      </div>
    </div>
  </div>

  <!-- Bloque Usuarios -->
  <div class="bg-[#e8e8eb] py-10">
    <h2 class="text-6xl font-bold text-center mb-8">USUARIOS</h2>
    <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mb-6" style="max-width:95%;"></div>

    <div class="container mx-auto overflow-x-auto px-4">
      <table class="min-w-full bg-white border border-gray-300 rounded-lg">
        <thead class="bg-[#f4f4f6]">
          <tr>
            <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Nombre</th>
            <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Apellidos</th>
            <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">C.I.</th>
            <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Nombre Usuario</th>
            <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Contraseña</th>
            <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Tipo</th>
            <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Email</th>
            <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Acciones</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($usuarios as $item)
          <tr class="border-b hover:bg-gray-100">
            <td class="px-6 py-4 text-gray-700">{{$item->nombre}}</td>
            <td class="px-6 py-4 text-gray-700">{{$item->apellidos}}</td>
            <td class="px-6 py-4 text-gray-700">{{$item->ci}}</td>
            <td class="px-6 py-4 text-gray-700">{{$item->nombre_usuario}}</td>
            <td class="px-6 py-4 text-gray-700">{{$item->contrasena}}</td>
            <td class="px-6 py-4 text-gray-700">{{$item->tipo}}</td>
            <td class="px-6 py-4 text-gray-700">{{$item->email}}</td>
            <td class="px-6 py-4 text-gray-700">
              <div class="flex items-center gap-2">
                <button wire:click.prevent="editar({{ $item->id_usuario }})"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded">
                  Editar
                </button>

                <button wire:click.prevent="delete({{ $item->id_usuario }})"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">
                  Borrar
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center px-6 py-4 text-gray-500">No hay usuarios</td>
          </tr>
          @endforelse
        </tbody>
      </table>

      <!-- paginación -->
      <div class="pagination mt-6">
        {{$usuarios->links()}}
      </div>
    </div>

    <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mt-6"></div>
  </div>

  <!-- Modal usuario -->
  @if ($showModal)
  <div class="fixed inset-0 bg-[#9b9b9b2d] bg-opacity-75 flex items-center justify-center z-50">
    <div class="inline-block align-bottom bg-white p-6 rounded-lg w-96">
      <div class="flex justify-between items-center">
        <h2 class="text-blue-700 font-semibold">Datos del Usuario</h2>
        <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="mt-4">
        <form class="max-w-md mx-auto">
          <!-- Nombre -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="nombre" type="text" id="floating_nombre"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_nombre" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Nombre
            </label>
            @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Apellidos -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="apellidos" type="text" id="floating_apellidos"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_apellidos" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Apellidos
            </label>
            @error('apellidos') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- CI -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="ci" type="text" id="floating_ci"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_ci" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              CI
            </label>
            @error('ci') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Nombre Usuario -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="nombre_usuario" type="text" id="floating_nombre_usuario"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_nombre_usuario" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Nombre Usuario
            </label>
            @error('nombre_usuario') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Contraseña -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="contrasena" type="password" id="floating_contrasena"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_contrasena" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Contraseña
            </label>
            @error('contrasena') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Tipo -->
          <div class="relative z-0 w-full mb-5 group">
            <select wire:model="tipo" id="floating_tipo"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                    required>
              <option value="" hidden></option>
              <option value="administrador">Administrador</option>
              <option value="personal">Personal</option>
            </select>
            <label for="floating_tipo" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Tipo
            </label>
            @error('tipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Email -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="email" type="email" id="floating_email"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Email
            </label>
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>
        </form>
      </div>

      <div class="mt-4 flex justify-end gap-3">
        <button wire:click="enviarClick()" type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 font-medium rounded-lg px-5 py-2.5">
          Enviar
        </button>

        <button wire:click="closeModal" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">
          Cerrar
        </button>
      </div>
    </div>
  </div>
  @endif
</div>
