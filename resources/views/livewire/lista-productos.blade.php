<div >
    <!-- buscador y menú -->
    <div class="flex ...">
        <div class="flex-auto w-32 ...">
            <input  wire:keydown.enter="clickBuscar()" type="search" wire:model="search" class="w-full max-w-md px-4 py-2 text-sm text-[#000000] border border-[#37383a] rounded-lg bg-[#d1d4da] focus:ring-[#c70606] focus:border-[#c70606] " placeholder="Buscar Producto" />
            <button wire:click="clickBuscar()" class="bg-[hsl(25,95%,53%)]  rounded-xl w-60 p-2 ml-2">buscar</button>
            @auth('web')
            <button  data-modal-target="default-modal" wire:click="openModal()" data-modal-toggle="default-modal"
            class="text-[#ffffff] bg-[#db1b1b] hover:bg-orange-600 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none focus:ring-4 focus:ring-orange-300 dark:focus:ring-orange-800 dark:bg-orange-500 dark:hover:bg-orange-600 dark:text-white">
            Nuevo</button>
            <a href="{{ route('reportes.productos') }}" class="ml-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg text-sm px-5 py-2.5">Reportes</a>
            @endauth 
        </div>
    </div>
    <div class="bg-[#e8e8eb] py-10">
        <h2 class="text-6xl font-bold text-center mb-8">NUESTROS PRODUCTOS</h2>
        <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70"></div>
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($productos as $item)
                <!-- Productos -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="/storage/img/{{$item->foto}}" alt="Producto" class="w-full h-48 object-cover">
                
                    <div class="p-4">
                        <h3 class="font-bold text-xl mb-2">{{$item->nombre}}</h3>
                
                        <div class="flex items-center mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $i <= $item->promedio_estrellas ? 'text-[#ffc82c]' : 'text-[#8492a6]' }}" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.7 5.216a1 1 0 00.95.69h5.462c.969 0 1.371 1.24.588 1.81l-4.412 3.204a1 1 0 00-.363 1.118l1.7 5.216c.3.921-.755 1.688-1.538 1.118L10 15.347l-4.414 3.204c-.783.57-1.838-.197-1.538-1.118l1.7-5.216a1 1 0 00-.363-1.118L.973 10.644c-.783-.57-.38-1.81.588-1.81h5.462a1 1 0 00.95-.69l1.7-5.216z" />
                                </svg>
                            @endfor
                        </div>
                
                        <p class="text-gray-600">{{$item->descripcion}}</p>
                
                        <p class="font-bold text-lg mt-2">Bs {{ $item->precio_mostrar ?? $item->precio }}</p>

                        <p class="text-orange-500 font-bold text-lg">{{$item->categoria->nombre}}</p>
                
                        <div class="flex space-x-2 mt-4">
                            @auth('clientes')
                            <button wire:click.prevent="calificar({{$item->id_producto}})" class="bg-[#f97316] text-white px-4 py-2 rounded hover:bg-[#ff8f3e] w-full">Calificar</button>
                            @endauth
                           
                            @auth('web')
                            <div class="flex space-x-2 mt-4">
                                @auth('clientes')
                                    <button wire:click.prevent="calificar({{$item->id_producto}})"
                                            class="bg-[#f97316] text-white px-4 py-2 rounded hover:bg-[#ff8f3e] w-full">
                                        Calificar
                                    </button>
                                @endauth

                                @auth('web')
                                    <button wire:click.prevent="editar({{$item->id_producto}})"
                                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                                        Editar
                                    </button>

                                    <!-- Aumentar stock (por defecto +1 unidad). -->
                                    <button wire:click.prevent="openIncreaseModal({{$item->id_producto}})" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                                        Aumentar stock
                                    </button>

                                    <!-- Botón Oferta (solo administrador) -->
                                    <button wire:click.prevent="openOfertaModal({{ $item->id_producto }})"
                                            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 w-full">
                                        Oferta
                                    </button>


                                @endauth
                            </div>

                            @endauth
                        </div>
                    </div>
                </div>
                
            @empty
                <p>No hay productos</p>
            @endforelse
            <br>
            <p class="w-full">
                {{$productos->links()}}
            </p>   
        </div>
        <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70"></div>

    </div>
    <div>
        @if($showModal2)
            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
    
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Calificar Producto
                                    </h3>
                                    <div class="mt-2 flex justify-center space-x-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i wire:click="seleccionarEstrella({{ $i }})"
                                               class="fas fa-star cursor-pointer text-3xl"
                                               style="color: {{ $puntuacion >= $i ? '#FFD700' : '#A0A0A0' }};">
                                            </i>
                                        @endfor
                                    </div>
                                    
                                    
                                    @error('puntuacion') 
                                        <span class="text-red-500">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" wire:click="guardarCalificacion"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">
                                Guardar
                            </button>
                            <button type="button" wire:click="closeModal2"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <div>

        @if ($showModal)
        <div class="fixed inset-0 bg-[#9b9b9b2d] bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-[#ffffff] p-6 rounded-lg w-96">
                <div class="flex justify-between items-center">
                    <h2 class="text-blue-700 font-semibold">Detalles del Producto</h2>
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
                <input wire:model="nombre"  type="text" name="floating_nombre" id="floating_nombre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Producto</label>
                @error('nombre')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Descripción -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="descripcion" type="text" name="floating_descripcion" id="floating_descripcion" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_descripcion" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripcion</label>
                @error('descripcion')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            @if ($producto_id)
                <div class="mb-4">
                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Estado</label>
                    <select wire:model="status" id="status" class="w-full p-2 border rounded text-blue-700">
                        <option value="{{ \App\Models\ProductoModel::STATUS_DISPONIBLE }}">Disponible</option>
                        <option value="{{ \App\Models\ProductoModel::STATUS_OFERTA }}">Oferta</option>
                        <option value="{{ \App\Models\ProductoModel::STATUS_FUERA }}">Fuera de stock</option>
                        <option value="{{ \App\Models\ProductoModel::STATUS_BAJA }}">Baja</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Puedes cambiar el estado manualmente o dejar que el sistema lo ajuste según stock/oferta.</p>
                </div>
            @endif

            <!-- Precio -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="precio" type="text" name="floating_precio" id="floating_precio" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_precio" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Precio</label>
                @error('precio')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Cantidad -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="stock" type="number" name="floating_stock" id="floating_stock" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_stock" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cantidad</label>
                @error('stock')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Categoría -->
            <div class="relative z-0 w-full mb-5 group">
                <select wire:model="categoria" id="categoria" name="id_categoria"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" required>
                    <option value="" selected hidden></option>
                    @foreach ($categorias as $item)
                        <option value="{{ $item->id_categoria }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
                <label for="categoria"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Categoría
                </label>
                @error('categoria')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Foto -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="foto" type="file" name="repeat_foto" id="floating_repeat_foto" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_repeat_foto" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Foto</label>
                @error('foto')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            @if ($foto && is_object($foto))
                Foto Preview:
                <img src="{{ $foto->temporaryUrl() }}">
            @else 
                @if ($foto)
                    Foto Preview:
                    <img src="{{ asset('storage/img/' . $foto) }}" alt="Preview">                
                @endif
            @endif
        </form>

                </div>
                <div class="mt-4 flex justify-end">
                    <button wire:click="enviarClick()" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enviar</button>

                    <button wire:click="closeModal" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Cerrar</button>
                </div>
            </div>
        </div>

        @endif
    </div>
        <!-- Modal: Aumentar stock -->
    @if($showIncreaseModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-blue-700 font-semibold mb-4">Aumentar stock</h3>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Cantidad a aumentar</label>
                    <input type="number" min="1" wire:model.defer="increaseAmount" class="w-full p-2 border rounded text-blue-700" />
                    @error('increaseAmount') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button wire:click="increaseStockConfirm" class="bg-green-600 text-white px-4 py-2 rounded">Confirmar</button>
                    <button wire:click="$set('showIncreaseModal', false)" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</button>
                </div>
            </div>
        </div>
    @endif
    <!-- Modal Oferta -->
    @if($showOfertaModal)
    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-blue-700 font-semibold mb-4">Asignar Oferta al Producto</h3>

        <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700">Selecciona una oferta</label>
        <select wire:model="ofertaId" wire:change="calcularPrecio" class="w-full p-2 border rounded text-blue-700">
            <option value="">-- Seleccione --</option>
            @foreach($ofertas as $of)
            <option value="{{ $of->id_oferta }}">
                {{ $of->nombre }} — {{ $of->descuento }}% ({{ \Carbon\Carbon::parse($of->fecha_ini)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($of->fecha_fin)->format('d/m/Y') }})
            </option>
            @endforeach
        </select>
        @error('ofertaId') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        @if($precio_final !== null)
        <div class="mb-3">
            <p class="text-sm font-medium">Precio final con oferta: <span class="font-bold">Bs {{ $precio_final }}</span></p>
        </div>
        @endif

        <div class="flex justify-end space-x-2 mt-4">
        <button wire:click="guardarDetalleOferta" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
        <button wire:click="$set('showOfertaModal', false)" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</button>
        </div>
    </div>
    </div>
    @endif

</div>

