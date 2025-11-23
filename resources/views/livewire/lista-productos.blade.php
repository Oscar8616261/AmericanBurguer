<div>
    <!-- buscador y menú -->
    <div class="flex ...">
        <div class="flex-auto w-32 ...">
            <input
                wire:keydown.enter="clickBuscar()"
                type="search"
                wire:model="search"
                class="w-full max-w-md px-4 py-2 text-sm border rounded-lg 
                       text-white bg-[#2a2a2a] border-black/50
                       placeholder-gray-400 focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]"
                placeholder="Buscar Producto" />

            <button
                wire:click="clickBuscar()"
                class="bg-[hsl(25,95%,53%)] rounded-xl w-60 p-2 ml-2 font-bold text-black hover:brightness-110 transition">
                buscar
            </button>

            @auth('web')
            <button
                data-modal-target="default-modal"
                wire:click="openModal()"
                data-modal-toggle="default-modal"
                class="ml-2 text-white bg-[#d6452f] hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-2.5
                       focus:outline-none focus:ring-4 focus:ring-red-500/40">
                Nuevo
            </button>

            <a href="{{ route('reportes.productos') }}"
               class="ml-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg text-sm px-5 py-2.5">
                Reportes
            </a>
            @endauth
        </div>
    </div>

    <div class="bg-[#181818] py-10 border border-black/40">
        <h2 class="text-6xl font-extrabold text-center mb-4 text-[#ff7a00] drop-shadow-md">NUESTROS PRODUCTOS</h2>
        <div class="w-full h-1 mx-auto rounded opacity-90 mb-6"
             style="max-width:95%; background: linear-gradient(90deg,#ff7a00,#ffcc4d);"></div>

        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($productos as $item)
                <!-- Productos -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="/storage/img/{{$item->foto}}" alt="Producto" class="w-full h-48 object-cover">

                    <div class="p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-xl text-[#1a1a1a]">{{$item->nombre}}</h3>

                            {{-- Badge de oferta opcional --}}
                            @if(!empty($item->en_oferta) && $item->en_oferta)
                                <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    EN OFERTA
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6 {{ $i <= $item->promedio_estrellas ? 'text-[#ffc82c]' : 'text-[#8492a6]' }}"
                                     viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.7 5.216a1 1 0 00.95.69h5.462c.969 0 1.371 1.24.588 1.81l-4.412 3.204a1 1 0 00-.363 1.118l1.7 5.216c.3.921-.755 1.688-1.538 1.118L10 15.347l-4.414 3.204c-.783.57-1.838-.197-1.538-1.118l1.7-5.216a1 1 0 00-.363-1.118L.973 10.644c-.783-.57-.38-1.81.588-1.81h5.462a1 1 0 00.95-.69l1.7-5.216z" />
                                </svg>
                            @endfor
                        </div>

                        <p class="text-gray-600">{{$item->descripcion}}</p>

                        {{-- PRECIOS --}}
                        @if(!empty($item->en_oferta) && $item->en_oferta)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <span class="line-through">
                                        Bs {{ number_format($item->precio_original, 2) }}
                                    </span>
                                </p>
                                <p class="font-bold text-lg text-red-600">
                                    Bs {{ number_format($item->precio_oferta, 2) }}
                                </p>
                            </div>
                        @else
                            <p class="font-bold text-lg mt-2 text-[#1a1a1a]">
                                Bs {{ number_format($item->precio_original ?? $item->precio, 2) }}
                            </p>
                        @endif>

                        <p class="text-gray-500">Disponible: {{$item->stock}}</p>

                        <p class="text-[#ff7a00] font-bold text-lg">{{$item->categoria->nombre}}</p>

                        <div class="flex flex-col gap-2 mt-4">
                            @auth('clientes')
                                <button wire:click.prevent="calificar({{$item->id_producto}})"
                                        class="bg-[#ff7a00] text-black px-4 py-2 rounded hover:bg-[#ff9d2e] font-semibold w-full transition">
                                    Calificar
                                </button>
                            @endauth

                            @auth('web')
                                <div class="flex flex-col gap-2 mt-2">
                                    @auth('clientes')
                                        <button wire:click.prevent="calificar({{$item->id_producto}})"
                                                class="bg-[#ff7a00] text-black px-4 py-2 rounded hover:bg-[#ff9d2e] font-semibold w-full transition">
                                            Calificar
                                        </button>
                                    @endauth

                                    @auth('web')
                                        <button wire:click.prevent="editar({{$item->id_producto}})"
                                                class="bg-[#ff7a00] text-black px-4 py-2 rounded hover:bg-[#ff9d2e] font-semibold w-full transition">
                                            Editar
                                        </button>

                                        <!-- Aumentar stock -->
                                        <button wire:click.prevent="openIncreaseModal({{$item->id_producto}})"
                                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-semibold w-full transition">
                                            Aumentar stock
                                        </button>

                                        <!-- Botón Oferta -->
                                        <button wire:click.prevent="openOfertaModal({{ $item->id_producto }})"
                                                class="bg-[#ffcc4d] text-black px-4 py-2 rounded hover:bg-[#ffb938] font-semibold w-full transition">
                                            Oferta
                                        </button>
                                    @endauth
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-200">No hay productos</p>
            @endforelse

            <br>
            <p class="w-full text-center text-white">
                {{$productos->links()}}
            </p>
        </div>

        <div class="w-full h-1 mx-auto rounded opacity-70 mt-4"
             style="max-width:95%; background: linear-gradient(90deg,#ffcc4d,#ff7a00);"></div>
    </div>

    {{-- MODAL CALIFICAR --}}
    <div>
        @if($showModal2)
            <div class="fixed z-50 inset-0 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-black opacity-60"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-[#181818] text-white rounded-lg overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-black/70">
                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-semibold text-[#ff7a00]">
                                        Calificar Producto
                                    </h3>
                                    <div class="mt-4 flex justify-center space-x-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i wire:click="seleccionarEstrella({{ $i }})"
                                               class="fas fa-star cursor-pointer text-3xl"
                                               style="color: {{ $puntuacion >= $i ? '#FFD700' : '#4b4b4b' }};">
                                            </i>
                                        @endfor
                                    </div>

                                    @error('puntuacion')
                                        <span class="text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-[#101010] px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                            <button type="button" wire:click="guardarCalificacion"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-md px-4 py-2 bg-[#ff7a00] text-base font-semibold text-black hover:bg-[#ff9d2e]">
                                Guardar
                            </button>
                            <button type="button" wire:click="closeModal2"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-[#2a2a2a] text-gray-200 hover:bg-[#3a3a3a] sm:mt-0">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- MODAL CREAR/EDITAR PRODUCTO --}}
    <div>
        @if ($showModal)
        <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
            <div class="bg-[#181818] text-white p-6 rounded-lg w-96 border border-black/70 shadow-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-[#ff7a00] font-semibold">Detalles del Producto</h2>
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
                        <!-- Nombre -->
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="nombre"
                                   type="text"
                                   id="floating_nombre"
                                   class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-500
                                          focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                                   placeholder=" " required />
                            <label for="floating_nombre"
                                   class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                          -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                          peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                          peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                Producto
                            </label>
                            @error('nombre')
                                <span class="text-red-400 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="descripcion"
                                   type="text"
                                   id="floating_descripcion"
                                   class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-500
                                          focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                                   placeholder=" " required />
                            <label for="floating_descripcion"
                                   class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                          -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                          peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                          peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                Descripcion
                            </label>
                            @error('descripcion')
                                <span class="text-red-400 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        @if ($producto_id)
                            <div class="mb-4">
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-200">Estado</label>
                                <select wire:model="status" id="status"
                                        class="w-full p-2 border rounded bg-[#2a2a2a] text-white border-black/60
                                               focus:outline-none focus:ring-2 focus:ring-[#ff7a00]">
                                    <option value="{{ \App\Models\ProductoModel::STATUS_DISPONIBLE }}">Disponible</option>
                                    <option value="{{ \App\Models\ProductoModel::STATUS_OFERTA }}">Oferta</option>
                                    <option value="{{ \App\Models\ProductoModel::STATUS_FUERA }}">Fuera de stock</option>
                                    <option value="{{ \App\Models\ProductoModel::STATUS_BAJA }}">Baja</option>
                                </select>
                                <p class="text-xs text-gray-400 mt-1">
                                    Puedes cambiar el estado manualmente o dejar que el sistema lo ajuste según stock/oferta.
                                </p>
                            </div>
                        @endif

                        <!-- Precio -->
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="precio"
                                   type="text"
                                   id="floating_precio"
                                   class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-500
                                          focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                                   placeholder=" " required />
                            <label for="floating_precio"
                                   class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                          -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                          peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                          peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                Precio
                            </label>
                            @error('precio')
                                <span class="text-red-400 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Cantidad -->
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="stock"
                                   type="number"
                                   id="floating_stock"
                                   class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-500
                                          focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                                   placeholder=" " required />
                            <label for="floating_stock"
                                   class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                          -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                          peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                          peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                Cantidad
                            </label>
                            @error('stock')
                                <span class="text-red-400 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Categoría -->
                        <div class="relative z-0 w-full mb-5 group">
                            <select wire:model="categoria" id="categoria" name="id_categoria"
                                    class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-500
                                           focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                                    required>
                                <option value="" selected hidden></option>
                                @foreach ($categorias as $item)
                                    <option class="text-black" value="{{ $item->id_categoria }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="categoria"
                                   class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                          -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                          peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                          peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                Categoría
                            </label>
                            @error('categoria')
                                <span class="text-red-400 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="foto"
                                   type="file"
                                   id="floating_repeat_foto"
                                   class="block py-2.5 px-0 w-full text-sm text-gray-200 bg-transparent border-0 border-b-2 border-gray-500
                                          focus:outline-none focus:ring-0 focus:border-[#ff7a00] peer"
                                   placeholder=" " {{ $producto_id ? '' : 'required' }} />
                            <label for="floating_repeat_foto"
                                   class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                          -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                          peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                          peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                Foto
                            </label>
                            @error('foto')
                                <span class="text-red-400 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        @if ($foto && is_object($foto))
                            <div class="mt-2">
                                <span class="text-sm font-semibold">Foto Preview:</span>
                                <img src="{{ $foto->temporaryUrl() }}" class="mt-1 rounded-md shadow-md">
                            </div>
                        @else
                            @if ($foto)
                                <div class="mt-2">
                                    <span class="text-sm font-semibold">Foto Preview:</span>
                                    <img src="{{ asset('storage/img/' . $foto) }}" alt="Preview" class="mt-1 rounded-md shadow-md">
                                </div>
                            @endif
                        @endif
                    </form>
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <button wire:click="enviarClick()" type="submit"
                            class="flex-1 text-black bg-[#ff7a00] hover:bg-[#ff9d2e] focus:ring-4 focus:outline-none
                                   focus:ring-[#ff7a00]/40 font-semibold rounded-lg text-sm px-5 py-2.5 text-center shadow-md">
                        Enviar
                    </button>
                    <button wire:click="closeModal"
                            class="flex-1 bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Modal: Aumentar stock -->
    @if($showIncreaseModal)
        <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
            <div class="bg-[#181818] rounded-lg p-6 w-96 border border-black/70 shadow-2xl text-white">
                <h3 class="text-[#ff7a00] font-semibold mb-4">Aumentar stock</h3>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-200">Cantidad a aumentar</label>
                    <input type="number" min="1"
                           wire:model.defer="increaseAmount"
                           class="w-full p-2 border rounded bg-[#2a2a2a] text-white border-black/60
                                  focus:outline-none focus:ring-2 focus:ring-[#ff7a00]" />
                    @error('increaseAmount') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button wire:click="increaseStockConfirm"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold">
                        Confirmar
                    </button>
                    <button wire:click="$set('showIncreaseModal', false)"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Oferta -->
    @if($showOfertaModal)
        <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
            <div class="bg-[#181818] rounded-lg p-6 w-96 border border-black/70 shadow-2xl text-white">
                <h3 class="text-[#ff7a00] font-semibold mb-4">Asignar Oferta al Producto</h3>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-200">Selecciona una oferta</label>
                    <select wire:model="ofertaId"
                            wire:change="calcularPrecio"
                            class="w-full p-2 border rounded bg-[#2a2a2a] text-white border-black/60
                                   focus:outline-none focus:ring-2 focus:ring-[#ff7a00]">
                        <option value="">-- Seleccione --</option>
                        @foreach($ofertas as $of)
                            <option class="text-black" value="{{ $of->id_oferta }}">
                                {{ $of->nombre }} — {{ $of->descuento }}%
                                ({{ \Carbon\Carbon::parse($of->fecha_ini)->format('d/m/Y') }}
                                → {{ \Carbon\Carbon::parse($of->fecha_fin)->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('ofertaId') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                </div>

                @if($precio_final !== null)
                <div class="mb-3">
                    <p class="text-sm font-medium">
                        Precio final con oferta:
                        <span class="font-bold text-[#ffcc4d]">Bs {{ $precio_final }}</span>
                    </p>
                </div>
                @endif

                <div class="flex justify-end space-x-2 mt-4">
                    <button wire:click="guardarDetalleOferta"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold">
                        Guardar
                    </button>
                    <button wire:click="$set('showOfertaModal', false)"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
