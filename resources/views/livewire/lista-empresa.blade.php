<div>
    <!-- buscador y menú -->
    <div class="flex ...">
        <div class="flex-auto w-32 ...">
            <input  wire:keydown.enter="clickBuscar()" type="search" wire:model="search" class="w-full max-w-md px-4 py-2 text-sm text-[#000000] border border-[#37383a] rounded-lg bg-[#d1d4da] focus:ring-[#c70606] focus:border-[#c70606] " placeholder="Buscar Empresa" />
            <button wire:click="clickBuscar()" class="bg-[hsl(25,95%,53%)]  rounded-xl w-60 p-2 ml-2">buscar</button>
            <button  data-modal-target="default-modal" wire:click="openModal()" data-modal-toggle="default-modal"
            class="text-[#ffffff] bg-[#db1b1b] hover:bg-orange-600 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none focus:ring-4 focus:ring-orange-300 dark:focus:ring-orange-800 dark:bg-orange-500 dark:hover:bg-orange-600 dark:text-white">
            Nuevo</button>      
        </div>
    </div>
    <!-- Título -->
    <div class="bg-[#e8e8eb] py-10">
        <h2 class="text-6xl font-bold text-center mb-8">Empresa</h2>
        <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mb-6"></div>

        <!-- Listado de empresa -->
        <div class="container mx-auto overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-[#f4f4f6]">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Nombre</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Dirección</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Lat-Long</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($empresas as $item)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4 text-gray-700">{{$item->nombre}}</td>
                            <td class="px-6 py-4 text-gray-700">{{$item->direccion}}</td>
                            <td class="px-6 py-4 text-gray-700">{{$item->latLog}}</td>
                            <td class="px-6 py-4 text-gray-700">
                                <!-- Botón Editar -->
                                <button wire:click.prevent="editar({{ $item->id_empresa }})" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                    Editar
                                </button>
                
                                <!-- Botón Borrar -->
                                <button wire:click.prevent="delete({{ $item->id_empresa }})" 
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded ml-2">
                                    Borrar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">No hay Empresas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <br>
        <p class="w-full">
            {{$empresas->links()}}
        </p>
        </div>
        
        <div class="w-full h-1 mx-auto bg-[#000000] rounded opacity-70 mt-6"></div>
    </div>
    <div>

        @if ($showModal)
        <div class="fixed inset-0 bg-[#9b9b9b2d] bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-[#ffffff] p-6 rounded-lg w-96">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Datos de la Empresa</h2>
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
                <label for="floating_nombre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre</label>
                @error('nombre')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Dirección -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="direccion"  type="text" name="floating_direccion" id="floating_direccion" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_direccion" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Dirección</label>
                @error('direccion')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Latitud y Longitud -->
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model="latLog"  type="text" name="floating_latLog" id="floating_latLog" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="floating_latLog" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Latitud y Longitud</label>
                @error('latLog')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            
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

