<div>
  <!-- buscador y acciones -->
  <div class="flex items-center justify-between px-4 py-6">
    <div class="flex-auto w-32"> <!-- hace coincidir tus selectores -->
      <input
        wire:keydown.enter="clickBuscar()"
        type="search"
        wire:model="search"
        class="w-full max-w-md px-4 py-2 text-sm border rounded-lg bg-transparent placeholder-opacity-75"
        placeholder="Buscar Oferta" />

      <div class="mt-3 md:mt-0 flex flex-wrap items-center gap-2">
        <button
          wire:click="clickBuscar()"
          class="bg-[hsl(25,95%,53%)] rounded-xl w-60 p-2 font-bold">
          buscar
        </button>

        @auth('web')
        <button
          data-modal-target="default-modal"
          wire:click="openModal()"
          data-modal-toggle="default-modal"
          class="bg-[#db1b1b] rounded-xl p-2 font-bold text-white">
          Nuevo
        </button>
        @endauth
      </div>
    </div>
  </div>

  <!-- bloque ofertas -->
  <div class="bg-[#e8e8eb] py-10">
    <h2 class="text-6xl font-bold text-center mb-8">NUESTRAS OFERTAS</h2>
    <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mb-8" style="max-width:95%;"></div>

    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
      @forelse ($ofertas as $item)
      <!-- Oferta Card -->
      <div class="shadow-lg rounded-lg overflow-hidden bg-white transition-transform transform hover:translate-y-[-6px] hover:scale-101">
        <!-- Imagen (usa product-card img para tus reglas) -->
        <img src="/storage/img/{{$item->foto}}" alt="{{$item->nombre}}" class="product-card img" />

        <!-- Nombre en overlay -->
        <div class="absolute top-0 left-0 w-full bg-black bg-opacity-70 text-white text-center py-2 font-bold text-lg">
          {{ $item->nombre }}
        </div>

        <!-- Detalles -->
        <div class="p-6 text-center">
          <p class="text-gray-700 font-medium text-lg">
            Descuento: <span class="text-red-500 font-bold">{{ $item->descuento }}%</span>
          </p>
          <p class="text-gray-600 text-sm mt-2">📅 {{ $item->fecha_ini }} - {{ $item->fecha_fin }}</p>
        </div>

        <!-- Botones de acción (autenticado) -->
        @auth('web')
        <div class="flex justify-center gap-3 p-4">
          <button wire:click.prevent="editar({{ $item->id_oferta }})"
                  class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded flex-1">
            Editar
          </button>

          <button wire:click.prevent="delete({{ $item->id_oferta }})"
                  class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded flex-1">
            Eliminar
          </button>
        </div>
        @endauth
      </div>
      @empty
      <p class="text-gray-500 text-lg text-center col-span-full">No hay ofertas disponibles</p>
      @endforelse
    </div>

    <!-- paginación -->
    <div class="text-center mt-8">
      {{ $ofertas->links() }}
    </div>

    <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mt-8"></div>
  </div>

  <!-- Modal -->
  @if ($showModal)
  <div class="fixed inset-0 bg-[#9b9b9b2d] bg-opacity-75 flex items-center justify-center z-50">
    <div class="inline-block align-bottom bg-white p-6 rounded-lg w-96">
      <div class="flex justify-between items-center">
        <h2 class="text-blue-700 font-semibold">Detalles de la Oferta</h2>
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
              Oferta
            </label>
            @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Descuento -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="descuento" type="number" id="floating_descuento"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_descuento" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Descuento
            </label>
            @error('descuento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Fecha Inicio -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="fecha_ini" type="date" id="floating_fecha_ini"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_fecha_ini" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Fecha Inicio
            </label>
            @error('fecha_ini') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Fecha Fin -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="fecha_fin" type="date" id="floating_fecha_fin"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_fecha_fin" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Fecha Fin
            </label>
            @error('fecha_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          <!-- Foto -->
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="foto" type="file" id="floating_repeat_foto"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
                   placeholder=" " required />
            <label for="floating_repeat_foto" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">
              Foto
            </label>
            @error('foto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
          </div>

          @if ($foto && is_object($foto))
          <div class="mb-4">
            <p class="text-sm font-semibold">Foto Preview:</p>
            <img src="{{ $foto->temporaryUrl() }}" alt="Preview" class="mt-2 rounded-md" />
          </div>
          @else
            @if ($foto)
            <div class="mb-4">
              <p class="text-sm font-semibold">Foto Preview:</p>
              <img src="{{ asset('storage/img/' . $foto) }}" alt="Preview" class="mt-2 rounded-md" />
            </div>
            @endif
          @endif
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
