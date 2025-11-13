<div>
    <div class="flex ...">
        <div class="flex-auto w-32 ...">
            <input  wire:keydown.enter="clickBuscar()" type="search" wire:model="search" class="w-full max-w-md px-4 py-2 text-sm text-[#000000] border border-[#37383a] rounded-lg bg-[#d1d4da] focus:ring-[#c70606] focus:border-[#c70606] " placeholder="Buscar Oferta" />
            <button wire:click="clickBuscar()" class="bg-[hsl(25,95%,53%)]  rounded-xl w-60 p-2 ml-2">buscar</button>
            @auth('web')
            <button  data-modal-target="default-modal" wire:click="openModal()" data-modal-toggle="default-modal"
            class="text-[#ffffff] bg-[#db1b1b] hover:bg-orange-600 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none focus:ring-4 focus:ring-orange-300 dark:focus:ring-orange-800 dark:bg-orange-500 dark:hover:bg-orange-600 dark:text-white">
            Nuevo</button>      
            @endauth
        </div>
    </div>
    <div class="bg-[#e8e8eb] py-10">
        <h2 class="text-6xl font-bold text-center mb-8">NUESTRAS OFERTAS</h2>
        <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mb-8"></div>
    
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($ofertas as $item)
                <!-- Oferta Card -->
                <div class="relative overflow-hidden bg-white rounded-lg shadow-lg transition-transform transform hover:scale-105">
                    <!-- Imagen -->
                    <img src="/storage/img/{{$item->foto}}" alt="Oferta" class="w-full h-64 object-cover">
    
                    <!-- Nombre de la Promoción -->
                    <div class="absolute top-0 left-0 w-full bg-black bg-opacity-70 text-white text-center py-2 font-bold text-lg">
                        {{ $item->nombre }}
                    </div>
    
                    <!-- Detalles -->
                    <div class="p-6 text-center">
                        <p class="text-gray-700 font-medium text-lg">Descuento: <span class="text-red-500 font-bold">{{ $item->descuento }}%</span></p>
                        <p class="text-gray-600 text-sm mt-2">📅 {{ $item->fecha_ini }} - {{ $item->fecha_fin }}</p>
                    </div>
    
                    <!-- Botones de Acción -->
                    @auth('web')
                    <div class="flex justify-center space-x-4 p-4">
                        <!-- Editar -->
                        <button wire:click.prevent="editar({{ $item->id_oferta }})" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all">
                            Editar
                        </button>
                        <!-- Eliminar -->
                        <button wire:click.prevent="delete({{ $item->id_oferta }})" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-all">
                            Eliminar
                        </button>
                    </div>
                    @endauth
                </div>
            @empty
                <p class="text-gray-500 text-lg text-center col-span-full">No hay ofertas disponibles</p>
            @endforelse
        </div>
    
        <!-- Paginación -->
        <div class="text-center mt-8">
            {{ $ofertas->links() }}
        </div>
    
        <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mt-8"></div>
    </div>
    <div>

        @if ($showModal)
        <div class="fixed inset-0 bg-[#9b9b9b2d] bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-[#ffffff] p-6 rounded-lg w-96">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Detalles de la Oferta</h2>
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
                <label for="floating_nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Oferta</label>
                @error('nombre')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Descuento -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="descuento" type="number" name="floating_descuento" id="floating_descuento" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_descuento" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descuento</label>
                @error('descuento')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Fecha Inicio -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="fecha_ini" type="date" name="floating_fecha_ini" id="floating_fecha_ini" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_fecha_ini" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha Inicio</label>
                @error('fecha_ini')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Fecha Fin -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="fecha_fin" type="date" name="floating_fecha_fin" id="floating_fecha_fin" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_fecha_fin" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha Fin</label>
                @error('fecha_fin')
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
    
</div>
