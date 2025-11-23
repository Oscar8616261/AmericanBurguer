{{-- resources/views/livewire/ventascrud.blade.php --}}
<div class="bg-[#0A3D91] p-6 min-h-screen text-white">
  <div class="container mx-auto">
    <div class="grid grid-cols-4 gap-6">
      <!-- PANEL CLIENTE / OPERADOR -->
      <div class="bg-white text-black p-4 rounded-lg shadow-lg col-span-1">

        @if(auth()->guard('web')->check())
          <h2 class="text-blue-700 font-semibold mb-3">Datos del Cliente</h2>
        @elseif(auth()->guard('clientes')->check())
          <h2 class="text-blue-700 font-semibold mb-3">Escoja un operador de venta</h2>
        @else
          <h2 class="text-blue-700 font-semibold mb-3">Inicia sesión para continuar</h2>
        @endif

        @if(auth()->guard('web')->check())
          <input wire:model="ciCliente"
                 wire:keydown.enter="buscarCliente"
                 type="text"
                 placeholder="Ingrese CI del Cliente..."
                 class="w-full p-2 border rounded mb-2"/>

          <button wire:click="buscarCliente"
                  class="bg-orange-500 text-[#072C6B] w-full py-2 rounded mb-2 font-bold">
            Buscar Cliente
          </button>

          @error('clienteId')
            <span class="text-red-600 text-sm">{{ $message }}</span>
          @enderror

          @if($clienteId)
            <div class="mt-3">
              <label class="block text-sm font-medium text-gray-700">Nombre y Apellidos</label>
              <input type="text" class="w-full p-2 border rounded" value="{{ $nombre }} {{ $apellidos }}" disabled>
            </div>
          @else
            <p class="text-sm text-gray-500 mt-2">Busca un cliente por CI para cargar sus datos.</p>
          @endif

        @elseif(auth()->guard('clientes')->check())
          <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona un operador</label>
          <select wire:model="selectedAdminId" class="w-full p-2 border rounded mb-2">
            <option value="">-- Selecciona un operador --</option>
            @foreach($admins as $admin)
              <option value="{{ $admin->id_usuario }}">
                {{ $admin->full_name ?? 'Administrador '.$admin->id_usuario }}
              </option>
            @endforeach
          </select>
          @error('selectedAdminId')
            <span class="text-red-600 text-sm">{{ $message }}</span>
          @enderror
          <p class="text-sm text-gray-600">Tu pedido será atendido por el operador que elijas.</p>

        @else
          <p class="text-sm text-gray-500">
            Inicia sesión como <strong>administrador</strong> o <strong>cliente</strong> para realizar ventas o pedidos.
          </p>
        @endif
      </div>

      <!-- SECCIÓN PRODUCTOS -->
      <div class="col-span-3 space-y-4">
        <!-- Categorías + Botones Ofertas / Destacados -->
        <div class="bg-white p-4 rounded-lg shadow-lg text-black">
          <div class="flex gap-3 mb-4">
            <button wire:click="showCategoria"
                    class="px-4 py-2 rounded {{ $viewMode === 'categoria' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-black' }}">
              Categorías
            </button>

            <button wire:click="showOfertas"
                    class="px-4 py-2 rounded {{ $viewMode === 'ofertas' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-black' }}">
              Ofertas
            </button>

            <button wire:click="showDestacados"
                    class="px-4 py-2 rounded {{ $viewMode === 'destacados' ? 'bg-green-600 text-white' : 'bg-gray-200 text-black' }}">
              Destacados
            </button>
          </div>

          @if($viewMode === 'ofertas')
            <p class="text-sm text-gray-500 mb-3">Mostrando todas las ofertas activas.</p>
          @elseif($viewMode === 'destacados')
            <p class="text-sm text-gray-500 mb-3">Mostrando los {{ $limitDestacados }} productos mejor calificados.</p>
          @endif

          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @if($viewMode === 'categoria')
              @forelse ($categorias as $index => $item)
                <div wire:click="prodcutosCategoria({{ $item->id_categoria }})"
                     class="flex items-center rounded-lg shadow cursor-pointer hover:scale-105 transition duration-200 p-2"
                     style="background-color: {{ ['#ffeb3b', '#ff9800', '#8bc34a', '#03a9f4', '#e91e63'][$index % 5] }};">
                  <img class="w-20 h-14 rounded object-cover" src="/storage/img/{{ $item->foto }}">
                  <p class="text-white font-semibold text-lg ml-3">{{ $item->nombre }}</p>
                </div>
              @empty
                <p class="text-gray-500">No hay Categorías</p>
              @endforelse
            @else
              @forelse ($productos as $item)
                <div class="flex items-start p-3 border rounded-lg bg-white">
                  <!-- izquierda: imagen -->
                  <img class="w-16 h-16 rounded-lg object-cover mr-3" src="/storage/img/{{$item->foto}}">

                  <!-- centro: texto -->
                  <div class="flex-1 min-w-0">
                    <p class="font-medium truncate text-black">{{$item->nombre}}</p>
                    <p class="text-gray-500 truncate">{{$item->descripcion}}</p>

                    <p class="text-gray-500 text-sm mt-1">Disponible: {{$item->stock ?? 'N/A'}}</p>

                    <!-- estrellas -->
                    <div class="flex items-center space-x-1 mt-1">
                      @php $avg = intval($item->promedio_estrellas ?? 0); @endphp
                      @for($i = 1; $i <= 5; $i++)
                        @if($i <= $avg)
                          <span class="text-yellow-500">★</span>
                        @else
                          <span class="text-gray-300">★</span>
                        @endif
                      @endfor
                    </div>

                    @php $st = $item->status ?? ''; @endphp
                    @if($st == (App\Models\ProductoModel::STATUS_OFERTA ?? 'oferta'))
                      <span class="inline-block mt-2 text-xs font-bold px-2 py-1 rounded bg-yellow-100 text-yellow-800">Oferta</span>
                    @elseif($st == (App\Models\ProductoModel::STATUS_FUERA ?? 'fuera') || ($item->stock ?? 0) <= 0)
                      <span class="inline-block mt-2 text-xs font-bold px-2 py-1 rounded bg-red-100 text-red-800">Sin stock</span>
                    @elseif($st == (App\Models\ProductoModel::STATUS_DISPONIBLE ?? 'disponible'))
                      <span class="inline-block mt-2 text-xs font-bold px-2 py-1 rounded bg-green-100 text-green-800">Disponible</span>
                    @else
                      @if(!empty($st))
                        <span class="inline-block mt-2 text-xs font-bold px-2 py-1 rounded bg-gray-100 text-gray-800">{{ $st }}</span>
                      @endif
                    @endif
                  </div>

                  <!-- derecha: PRECIOS + botón -->
                  <div class="flex flex-col items-end justify-between ml-3" style="min-width:130px">
                    @if(!empty($item->en_oferta) && $item->en_oferta)
                      <div class="text-right">
                        <p class="text-xs text-gray-500">
                          <span class="line-through">
                            Bs. {{ number_format($item->precio_original ?? $item->precio, 2, '.', ',') }}
                          </span>
                        </p>
                        <p class="text-base font-bold text-red-600">
                          Bs. {{ number_format($item->precio_oferta ?? $item->precio_mostrar ?? $item->precio, 2, '.', ',') }}
                        </p>
                      </div>
                    @else
                      <div class="text-base font-semibold text-black">
                        Bs. {{ number_format($item->precio_mostrar ?? $item->precio, 2, '.', ',') }}
                      </div>
                    @endif

                    @if(($item->stock ?? 0) > 0)
                      <button wire:click="addProducto({{$item->id_producto}})"
                              class="bg-green-600 hover:bg-green-700 w-10 h-10 rounded text-white mt-2">
                        <i class="fas fa-shopping-cart"></i>
                      </button>
                    @else
                      <button disabled
                              class="w-10 h-10 rounded text-white opacity-60 cursor-not-allowed bg-gray-400 mt-2"
                              title="Sin stock">
                        <i class="fas fa-ban"></i>
                      </button>
                    @endif
                  </div>
                </div>
              @empty
                <p class="col-span-2 text-center text-gray-500">No hay Productos</p>
              @endforelse
            @endif
          </div>
        </div>

        <!-- Buscador -->
        <div class="bg-white p-4 rounded-lg shadow-lg text-black">
          @auth('web')
          <div class="flex justify-end mb-3">
            <a href="{{ route('reportes.ventas') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
              Reportes
            </a>
          </div>
          @endauth
          <h2 class="text-blue-700 font-semibold mb-2">Buscar Producto</h2>
          <div class="flex items-center">
            <input type="search" wire:model="searchProducto" wire:keydown.enter="clickBuscar"
                   placeholder="Buscar Producto"
                   class="w-full px-4 py-2 border rounded-lg"/>

            <button wire:click="clickBuscar"
                    class="bg-orange-500 rounded-xl px-4 py-2 ml-3 font-bold">
              Buscar
            </button>
          </div>
          @if(!empty($recomendados))
          <div class="mt-3">
            <p class="text-sm text-gray-500 mb-2">Recomendados</p>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
              @foreach($recomendados as $rec)
                <div class="flex items-center p-2 border rounded-lg bg-white">
                  <img class="w-12 h-12 rounded-lg object-cover mr-2" src="/storage/img/{{$rec->foto}}">
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate text-black">{{$rec->nombre}}</p>
                    <p class="text-xs text-gray-500 truncate">{{$rec->descripcion}}</p>
                  </div>
                  <button wire:click="addProducto({{$rec->id_producto}})" class="bg-green-600 hover:bg-green-700 w-8 h-8 rounded text-white ml-2">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              @endforeach
            </div>
          </div>
          @endif
        </div>

        <!-- Productos (lista principal) -->
        <div class="bg-white grid grid-cols-2 gap-4 rounded-lg shadow-lg p-4 text-black">
          @forelse ($productos as $item)
            <div class="flex items-start p-3 border rounded-lg bg-white">
              <img class="w-16 h-16 rounded-lg object-cover mr-3" src="/storage/img/{{$item->foto}}">

              <div class="flex-1 min-w-0">
                <p class="font-medium truncate text-black">{{$item->nombre}}</p>
                <p class="text-gray-500 truncate">{{$item->descripcion}}</p>
                <p class="text-gray-500">Disponible: {{$item->stock}}</p>

                <!-- estrellas -->
                <div class="mt-2">
                  @php $avg = intval($item->promedio_estrellas ?? 0); @endphp
                  @for($i = 1; $i <= 5; $i++)
                    @if($i <= $avg)
                      <span class="text-yellow-500">★</span>
                    @else
                      <span class="text-gray-300">★</span>
                    @endif
                  @endfor
                </div>

                @php
                  $st = $item->status ?? '';
                @endphp

                @if($st == (App\Models\ProductoModel::STATUS_OFERTA ?? 'oferta'))
                  <span class="inline-block mt-2 text-xs font-bold px-2 py-1 rounded bg-yellow-100 text-yellow-800">Oferta</span>
                @elseif($st == (App\Models\ProductoModel::STATUS_FUERA ?? 'fuera') || ($item->stock ?? 0) <= 0)
                  <span class="inline-block mt-2 text-xs font-bold px-2 py-1 rounded bg-red-100 text-red-800">Sin stock</span>
                @elseif($st == (App\Models\ProductoModel::STATUS_DISPONIBLE ?? 'disponible'))
                  <span class="inline-block mt-2 text-xs font-bold px-2 py-1 rounded bg-green-100 text-green-800">Disponible</span>
                @else
                  @if(!empty($st))
                    <span class="inline-block mt-2 text-xs font-bold px-2 py-1 rounded bg-gray-100 text-gray-800">{{ $st }}</span>
                  @endif
                @endif
              </div>

              <div class="flex flex-col items-end justify-between ml-3" style="min-width:130px">
                @if(!empty($item->en_oferta) && $item->en_oferta)
                  <div class="text-right">
                    <p class="text-xs text-gray-500">
                      <span class="line-through">
                        Bs. {{ number_format($item->precio_original ?? $item->precio, 2, '.', ',') }}
                      </span>
                    </p>
                    <p class="text-base font-bold text-red-600">
                      Bs. {{ number_format($item->precio_oferta ?? $item->precio_mostrar ?? $item->precio, 2, '.', ',') }}
                    </p>
                  </div>
                @else
                  <div class="text-base font-semibold text-black">
                    Bs. {{ number_format($item->precio_mostrar ?? $item->precio, 2, '.', ',') }}
                  </div>
                @endif

                @if(($item->stock ?? 0) > 0)
                  <button wire:click="addProducto({{$item->id_producto}})"
                          class="bg-green-600 hover:bg-green-700 w-10 h-10 rounded text-white mt-2">
                    <i class="fas fa-shopping-cart"></i>
                  </button>
                @else
                  <button disabled
                          class="w-10 h-10 rounded text-white opacity-60 cursor-not-allowed bg-gray-400 mt-2"
                          title="Sin stock">
                    <i class="fas fa-ban"></i>
                  </button>
                @endif
              </div>
            </div>
          @empty
            <p class="col-span-2 text-center text-gray-500">No hay Productos</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- CARRITO Y PAGO -->
    <div class="grid grid-cols-3 gap-4 mt-6">
      <!-- Carrito -->
      <div class="bg-white p-4 rounded-lg shadow-lg col-span-2 text-black">
        <h2 class="text-blue-700 font-semibold mb-3 text-center">Carrito de Compras</h2>

        @forelse ($carrito as $item)
          <div class="flex justify-between items-center border-b py-2">
            <img src="/storage/img/{{$item['producto']['foto']}}" class="rounded-lg w-16 h-16">

            <div class="flex-1 px-4">
              <p class="font-semibold">{{$item['producto']['nombre']}}</p>

              {{-- Estado / Badge --}}
              @php
                $st = $item['producto']['status'] ?? '';
              @endphp

              @if($st == (App\Models\ProductoModel::STATUS_OFERTA ?? 'oferta'))
                <span class="inline-block text-xs font-bold px-2 py-1 rounded bg-yellow-100 text-yellow-800">Oferta</span>
              @elseif($st == (App\Models\ProductoModel::STATUS_FUERA ?? 'fuera') || ($item['producto']['stock'] ?? 0) <= 0)
                <span class="inline-block text-xs font-bold px-2 py-1 rounded bg-red-100 text-red-800">Sin stock</span>
              @elseif($st == (App\Models\ProductoModel::STATUS_DISPONIBLE ?? 'disponible'))
                <span class="inline-block text-xs font-bold px-2 py-1 rounded bg-green-100 text-green-800">Disponible</span>
              @else
                <span class="inline-block text-xs font-bold px-2 py-1 rounded bg-gray-100 text-gray-800">{{ $st }}</span>
              @endif

              <p class="text-gray-600 text-sm mt-1">{{ $item['producto']['descripcion'] ?? '' }}</p>
            </div>

            {{-- Precio del item (usa el precio guardado en el carrito) --}}
            <p class="flex-1 text-center font-semibold">Bs. {{ number_format($item['precio'], 2, '.', ',') }}</p>

            <input disabled value="{{$item['cantidad']}}"
                   class="border bg-gray-300 w-20 rounded text-center">

            <div class="flex space-x-1 ml-3">
              <button wire:click="addProducto({{$item['producto']['id_producto']}})"
                      class="bg-green-600 hover:bg-green-700 w-8 h-8 rounded text-white">+</button>

              <button wire:click="removeProducto({{$item['producto']['id_producto']}})"
                      class="bg-red-600 hover:bg-red-700 w-8 h-8 rounded text-white">-</button>
            </div>
          </div>
        @empty
          <p class="text-center text-gray-500">No hay productos en el carrito.</p>
        @endforelse
      </div>

      <!-- Pago -->
      <div class="bg-white p-4 rounded-lg shadow-lg text-black">
        <h2 class="text-blue-700 font-semibold mb-3">Resumen</h2>

        <p class="text-xl font-bold mb-3">Total: Bs. {{ number_format($total, 2, '.', ',') }}</p>

        <label class="block text-sm font-medium text-gray-700">Tipo de Pago</label>
        <select wire:model="tipoPagoId" class="w-full p-2 border rounded mb-3">
          <option value="">-- Seleccione tipo de pago --</option>
          @foreach ($tiposPago as $pago)
            <option value="{{ $pago->id_pago }}">{{ $pago->nombre }}</option>
          @endforeach
        </select>
        @error('tipoPagoId') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

        @if($tipoPagoId && $tipoPagoId == $efectivoId)
          <label class="block text-sm font-medium text-gray-700">Monto Recibido</label>
          <input type="number" wire:model.defer="montoRecibido"
                 wire:keydown.enter="calculoCambio"
                 wire:change="calculoCambio"
                 class="w-full p-2 border rounded mb-2" min="0" step="0.01">

          <h3 class="text-green-600 font-semibold">Cambio: Bs. {{ number_format($cambio, 2, '.', ',') }}</h3>
        @endif

        @if(auth()->guard('clientes')->check())
          <button wire:click="guardar"
                  class="bg-yellow-500 hover:bg-yellow-600 text-white w-full py-2 rounded mt-4">
            Crear Pedido
          </button>
        @else
          <button wire:click="guardar"
                  class="bg-blue-500 hover:bg-blue-600 text-white w-full py-2 rounded mt-4">
            Pagar
          </button>
        @endif
      </div>
    </div>
  </div>

  {{-- MODAL "También te puede gustar" --}}
  <div
      x-data="{ open: false }"
      x-on:show-suggestions.window="
          open = true;
          clearTimeout(window.suggestionTimeout);
          window.suggestionTimeout = setTimeout(() => { open = false }, 4000);
      "
  >
      <div
          x-show="open"
          x-transition
          class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
          style="display: none;"
      >
          <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-xl text-black">
              <div class="flex justify-between items-center mb-3">
                  <h3 class="text-lg font-semibold text-blue-700">
                      También te puede gustar
                  </h3>
                  <button
                      class="text-gray-500 hover:text-gray-700"
                      @click="open = false"
                  >
                      ✕
                  </button>
              </div>

              @if(!empty($suggestedProducts) && count($suggestedProducts) > 0)
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                      @foreach($suggestedProducts as $sug)
                          <div class="flex items-start p-2 border rounded-lg bg-gray-50">
                              <img
                                  src="/storage/img/{{ $sug['foto'] ?? '' }}"
                                  class="w-14 h-14 rounded-lg object-cover mr-2"
                              >

                              <div class="flex-1 min-w-0">
                                  <p class="font-medium text-sm truncate">
                                      {{ $sug['nombre'] ?? '' }}
                                  </p>
                                  <p class="text-xs text-gray-500 truncate">
                                      {{ $sug['descripcion'] ?? '' }}
                                  </p>

                                  @php
                                      $enOferta = $sug['en_oferta'] ?? false;
                                      $precioOriginal = $sug['precio_original'] ?? 0;
                                      $precioMostrar  = $sug['precio_mostrar'] ?? 0;
                                  @endphp

                                  @if($enOferta)
                                      <div class="mt-1 text-xs">
                                          <span class="line-through text-gray-400">
                                              Bs. {{ number_format($precioOriginal, 2, '.', ',') }}
                                          </span>
                                          <span class="ml-1 font-bold text-red-600">
                                              Bs. {{ number_format($precioMostrar, 2, '.', ',') }}
                                          </span>
                                      </div>
                                  @else
                                      <div class="mt-1 text-sm font-semibold text-gray-800">
                                          Bs. {{ number_format($precioMostrar, 2, '.', ',') }}
                                      </div>
                                  @endif
                              </div>

                              <button
                                  wire:click="addProducto({{ $sug['id_producto'] }})"
                                  class="bg-green-600 hover:bg-green-700 w-9 h-9 rounded-full text-white ml-2 flex items-center justify-center"
                              >
                                  <i class="fas fa-plus"></i>
                              </button>
                          </div>
                      @endforeach
                  </div>
              @else
                  <p class="text-sm text-gray-500">
                      No hay sugerencias en este momento.
                  </p>
              @endif
          </div>
      </div>
  </div>
</div>

{{-- Modal global manejado por ModalTicket en el layout --}}
