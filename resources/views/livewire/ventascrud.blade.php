{{-- resources/views/livewire/ventascrud.blade.php --}}
<div class="bg-[#0A3D91] p-6 min-h-screen text-white">
  <div class="container mx-auto">
    <div class="grid grid-cols-4 gap-6">
      <!-- PANEL CLIENTE / OPERADOR -->
      <div class="bg-[#ffffff] text-black p-4 rounded-lg shadow-lg.rounded-lg.overflow-hidden col-span-1">
        @if(auth()->guard('web')->check())
          <h2 class="text-blue-700 font-semibold mb-3">Datos del Cliente</h2>
        @elseif(auth()->guard('clientes')->check())
          <h2 class="text-blue-700 font-semibold mb-3">Escoja un operador de venta</h2>
        @else
          <h2 class="text-blue-700 font-semibold mb-3">Inicia sesión para continuar</h2>
        @endif

        @if(auth()->guard('web')->check())
          <input wire:model.defer="ciCliente" wire:keydown.enter="buscarCliente" type="text"
                 placeholder="Ingrese CI del Cliente..."
                 class="w-full p-2 border rounded mb-2"/>

          <button wire:click="buscarCliente"
                  class="bg-[hsl(25,95%,53%)] text-[#072C6B] w-full py-2 rounded mb-2 font-bold">
            Buscar Cliente
          </button>

          @error('clienteId')
            <span class="error text-red-600 text-sm">{{ $message }}</span>
          @enderror

          @if($clienteId)
            <div class="mt-3 space-y-2">
              <label class="block text-sm font-medium text-gray-700">Nombre</label>
              <input type="text" class="w-full p-2 border rounded" value="{{ $nombre }}" disabled>

              <label class="block text-sm font-medium text-gray-700">Apellidos</label>
              <input type="text" class="w-full p-2 border rounded" value="{{ $apellidos }}" disabled>

              <label class="block text-sm font-medium text-gray-700">NIT</label>
              <input type="text" class="w-full p-2 border rounded" value="{{ $nit }}" disabled>
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
          @error('selectedAdminId') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
          <p class="text-sm text-gray-600">Tu pedido será atendido por el operador que elijas.</p>

        @else
          <p class="text-sm text-gray-500">
            Inicia sesión como <strong>administrador</strong> o <strong>cliente</strong> para realizar ventas o pedidos.
          </p>
        @endif
      </div>

      <!-- SECCIÓN PRODUCTOS -->
      <div class="col-span-3 space-y-4">
        <!-- Categorías -->
        <div class="bg-white p-4 rounded-lg shadow-lg.rounded-lg.overflow-hidden text-black">
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($categorias as $index => $item)
              <div wire:click="prodcutosCategoria({{ $item->id_categoria }})"
                   class="flex items-center rounded-lg shadow cursor-pointer hover:scale-105 transition duration-200 p-2"
                   style="background-color: {{ ['#ffeb3b', '#ff9800', '#8bc34a', '#03a9f4', '#e91e63'][$index % 5] }};">
                <img class="w-20 h-14 rounded object-cover" src="/storage/img/{{ $item->foto }}" alt="{{ $item->nombre }}">
                <p class="text-white font-semibold text-lg ml-3">{{ $item->nombre }}</p>
              </div>
            @empty
              <p class="text-gray-500">No hay Categorías</p>
            @endforelse
          </div>
        </div>

        <!-- Buscador -->
        <div class="bg-white p-4 rounded-lg shadow-lg.rounded-lg.overflow-hidden text-black">
          <h2 class="text-blue-700 font-semibold mb-2">Buscar Producto</h2>
          <div class="flex items-center">
            <div class="flex-auto w-32">
              <input type="search"  wire:model="searchProducto" wire:keydown.enter="clickBuscar"
                     placeholder="Buscar Producto"
                     class="w-full max-w-md px-4 py-2 text-sm border rounded-lg bg-transparent focus:outline-none"/>
            </div>

            <div class="ml-3">
              <button wire:click="clickBuscar"
                      class="bg-[hsl(25,95%,53%)] rounded-xl px-4 py-2 font-bold">
                Buscar
              </button>
            </div>
          </div>
        </div>

        <!-- Lista de Productos -->
        <div class="bg-white grid grid-cols-2 gap-4 rounded-lg shadow-lg.rounded-lg.overflow-hidden p-4 text-black">
          @forelse ($productos as $item)
            <div class="flex items-center space-x-4 p-3 border rounded-lg">
              <div class="shrink-0">
                <img class="product-card img w-16 h-16 rounded-lg object-cover" src="/storage/img/{{$item->foto}}" alt="Producto">
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-black truncate">{{$item->nombre}}</p>
                <p class="text-sm text-gray-500 truncate">{{$item->descripcion}}</p>
                <p class="text-sm text-gray-500">Disponible: {{$item->stock}}</p>
              </div>
              <div class="text-base font-semibold">Bs. {{$item->precio}}</div>
              <div>
                <button wire:click="addProducto({{$item->id_producto}})"
                        class="bg-green-600 hover:bg-green-700 w-10 h-10 rounded text-white">
                  <i class="fas fa-shopping-cart"></i>
                </button>
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
      <div class="bg-white p-4 rounded-lg shadow-lg.rounded-lg.overflow-hidden col-span-2 text-black">
        <h2 class="text-blue-700 font-semibold mb-3 text-center">Carrito de Compras</h2>
        @error('carrito') <span class="text-red-500">{{ $message }}</span> @enderror

        @forelse ($carrito as $item)
          <div class="flex justify-between items-center border-b py-2">
            <img src="/storage/img/{{$item['producto']['foto']}}" alt="" class="rounded-lg w-16 h-16">
            <p class="flex-1 text-center">{{$item['producto']['nombre']}}</p>
            <p class="flex-1 text-center">Bs. {{$item['precio']}}</p>
            <input disabled type="number" step="1" value="{{$item['cantidad']}}" class="border bg-gray-300 w-20 rounded text-center">
            <div class="flex space-x-1">
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
      <div class="bg-white p-4 rounded-lg shadow-lg.rounded-lg.overflow-hidden text-black">
        <h2 class="text-blue-700 font-semibold mb-3">Resumen</h2>
        <p class="text-xl font-bold mb-3">Total: Bs. {{$total}}</p>

        <label class="block text-sm font-medium text-gray-700">Tipo de Pago</label>
        <select wire:model="tipoPago" class="w-full p-2 border rounded mb-3">
          @foreach ($tiposPago as $pago)
            <option value="{{ $pago->nombre }}">{{ $pago->nombre }}</option>
          @endforeach
        </select>

        <input type="hidden" wire:model="tipoPagoId">

        @if($tipoPago == "Efectivo")
          <label class="block text-sm font-medium text-gray-700">Monto Recibido</label>
          <input type="number" wire:keydown="calculoCambio" wire:model.defer="montoRecibido"
                 class="w-full p-2 border rounded mb-2" min="0" step="0.01">
          @error('montoRecibido') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
          <h3 class="text-green-600 font-semibold">Cambio: Bs. {{$cambio}}</h3>
        @endif

        @if(auth()->guard('clientes')->check())
          <button wire:click="guardar" class="bg-yellow-500 hover:bg-yellow-600 text-white w-full py-2 rounded mt-4">
            Crear Pedido
          </button>
        @else
          <button wire:click="guardar" class="bg-blue-500 hover:bg-blue-600 text-white w-full py-2 rounded mt-4">
            Pagar
          </button>
        @endif

        @if(auth()->guard('web')->check())
          <p class="text-xs text-gray-500 mt-2">La venta quedará en estado <strong>confirmado</strong> y se descontará stock.</p>
        @endif
        @if(auth()->guard('clientes')->check())
          <p class="text-xs text-gray-500 mt-2">El pedido quedará en estado <strong>pendiente</strong> y no se descontará stock.</p>
        @endif
      </div>
    </div>
  </div>
</div>
