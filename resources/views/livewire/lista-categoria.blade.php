<div>
  <!-- buscador y menú -->
  <div class="flex items-center justify-between px-4 py-6">
    <div class="flex-auto w-32">
      <input
        wire:keydown.enter="clickBuscar()"
        type="search"
        wire:model="search"
        class="w-full max-w-md px-4 py-2 text-sm border rounded-lg bg-transparent placeholder-opacity-75"
        placeholder="Buscar Categoria" />

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

  <!-- bloque de categorias -->
  <div class="bg-[#181818] py-10 border border-black/40">
    <h2 class="text-6xl font-extrabold text-center mb-4 text-[#ff7a00] drop-shadow-md">CATEGORIAS</h2>

    <!-- línea separadora -->
    <div class="w-full h-1 mx-auto rounded opacity-90 mb-8"
         style="max-width:95%; background: linear-gradient(90deg,#ff7a00,#ffcc4d);"></div>

    <!-- grid de tarjetas -->
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
      @forelse ($categorias as $item)
      <div class="shadow-lg rounded-lg overflow-hidden bg-white">
        <img src="/storage/img/{{$item->foto}}" alt="{{$item->nombre}}" class="product-card img" />

        <div class="p-4">
          <h3 class="font-bold text-xl mb-2 text-center text-[#1a1a1a]">{{$item->nombre}}</h3>
          <p class="text-gray-600 text-center mb-4">{{$item->descripcion}}</p>

          @auth('web')
          <div class="flex gap-3">
            <button wire:click.prevent="editar({{$item->id_categoria}})"
                    class="bg-[#ff7a00] hover:bg-[#ff9d2e] text-black px-4 py-2 rounded font-semibold flex-1 transition shadow-sm">
              Editar
            </button>

            <button wire:click.prevent="delete({{$item->id_categoria}})"
                    class="bg-[#d6452f] hover:bg-red-700 text-white px-4 py-2 rounded font-semibold flex-1 transition shadow-sm">
              Eliminar
            </button>
          </div>
          @endauth
        </div>
      </div>
      @empty
      <p class="text-center w-full text-gray-200">No hay categorias</p>
      @endforelse
    </div>

    <!-- paginación -->
    <div class="pagination mt-8">
      {{$categorias->links()}}
    </div>

    <div class="w-full h-1 mx-auto rounded opacity-70 mt-10"
         style="max-width:95%; background: linear-gradient(90deg,#ffcc4d,#ff7a00);"></div>
  </div>

  <!-- Modal -->
  @if ($showModal)
  <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="inline-block align-bottom bg-[#181818] text-white p-6 rounded-lg w-96 border border-black/70 shadow-2xl">
      <div class="flex justify-between items-center">
        <h2 class="text-[#ff7a00] font-semibold">Detalles de la Categoría</h2>
        <button wire:click="closeModal" class="text-gray-300 hover:text-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="mt-4">
        <form class="max-w-md mx-auto">
          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="nombre" type="text" id="floating_nombre"
                   class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-500 appearance-none focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                   placeholder=" " required />
            <label for="floating_nombre"
                   class="absolute text-sm text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:text-[#ffcc4d]">
              Categoria
            </label>
            @error('nombre') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
          </div>

          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="descripcion" type="text" id="floating_descripcion"
                   class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-500 appearance-none focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                   placeholder=" " required />
            <label for="floating_descripcion"
                   class="absolute text-sm text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:text-[#ffcc4d]">
              Descripcion
            </label>
            @error('descripcion') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
          </div>

          <div class="relative z-0 w-full mb-5 group">
            <input wire:model="foto" type="file" id="floating_repeat_foto"
                   class="block py-2.5 px-0 w-full text-sm text-gray-200 bg-transparent border-0 border-b-2 border-gray-500 appearance-none focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                   placeholder=" " required />
            <label for="floating_repeat_foto"
                   class="absolute text-sm text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:text-[#ffcc4d]">
              Foto
            </label>
            @error('foto') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
          </div>

          @if ($foto && is_object($foto))
            <div class="mb-4">
              <p class="text-sm font-semibold">Foto Preview:</p>
              <img src="{{ $foto->temporaryUrl() }}" alt="Preview" class="mt-2 rounded-md shadow-md" />
            </div>
          @else
            @if ($foto)
            <div class="mb-4">
              <p class="text-sm font-semibold">Foto Preview:</p>
              <img src="{{ asset('storage/img/' . $foto) }}" alt="Preview" class="mt-2 rounded-md shadow-md" />
            </div>
            @endif
          @endif
        </form>
      </div>

      <div class="mt-4 flex justify-end gap-3">
        <button wire:click="enviarClick()" type="submit"
                class="text-black bg-[#ff7a00] hover:bg-[#ff9d2e] focus:ring-4 focus:ring-[#ff7a00]/40 font-semibold rounded-lg px-5 py-2.5 shadow-md transition">
          Enviar
        </button>

        <button wire:click="closeModal"
                class="bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700">
          Cerrar
        </button>
      </div>
    </div>
  </div>
  @endif
</div>
