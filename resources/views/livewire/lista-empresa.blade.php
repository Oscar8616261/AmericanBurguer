<div>
    <!-- buscador y menú -->
    <div class="flex ...">
        <div class="flex-auto w-32 ...">
            <input
                wire:keydown.enter="clickBuscar()"
                type="search"
                wire:model="search"
                class="w-full max-w-md px-4 py-2 text-sm border rounded-lg
                       bg-[#2a2a2a] text-white border-black/60
                       placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]"
                placeholder="Buscar Empresa" />

            <button
                wire:click="clickBuscar()"
                class="bg-[hsl(25,95%,53%)] rounded-xl w-60 p-2 ml-2 font-semibold text-black hover:brightness-110 transition">
                buscar
            </button>

            <button
                data-modal-target="default-modal"
                wire:click="openModal()"
                data-modal-toggle="default-modal"
                class="ml-2 text-white bg-[#d6452f] hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-2.5
                       focus:outline-none focus:ring-4 focus:ring-red-500/40">
                Nuevo
            </button>
        </div>
    </div>

    <!-- Título + tabla -->
    <div class="py-10"
         style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 60%, #050505 100%);">
        <h2 class="text-6xl font-extrabold text-center mb-4 text-[#ff7a00] drop-shadow-md uppercase">
            Empresa
        </h2>

        <div class="w-full h-1 mx-auto rounded opacity-90 mb-6"
             style="max-width:95%; background: linear-gradient(90deg,#ff7a00,#ffcc4d);"></div>

        <!-- Listado de empresa -->
        <div class="container mx-auto overflow-x-auto px-4">
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 p-4">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-[#1a1a1a] text-white text-sm">
                            <th class="text-left px-6 py-3 font-semibold border-b border-gray-700">Nombre</th>
                            <th class="text-left px-6 py-3 font-semibold border-b border-gray-700">Dirección</th>
                            <th class="text-left px-6 py-3 font-semibold border-b border-gray-700">Lat-Long</th>
                            <th class="text-left px-6 py-3 font-semibold border-b border-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($empresas as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-800">{{ $item->nombre }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $item->direccion }}</td>
                                <td class="px-6 py-4 text-gray-800">{{ $item->latLog }}</td>
                                <td class="px-6 py-4 text-gray-800">
                                    <!-- Botón Editar -->
                                    <button
                                        wire:click.prevent="editar({{ $item->id_empresa }})"
                                        class="bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold py-1 px-3 rounded-lg shadow-sm transition">
                                        Editar
                                    </button>

                                    <!-- Botón Borrar -->
                                    <button
                                        wire:click.prevent="delete({{ $item->id_empresa }})"
                                        class="bg-[#d6452f] hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-lg ml-2 shadow-sm transition">
                                        Borrar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center px-6 py-4 text-gray-500">
                                    No hay Empresas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $empresas->links() }}
                </div>
            </div>

            <div class="w-full h-1 mx-auto rounded opacity-70 mt-6"
                 style="max-width:95%; background: linear-gradient(90deg,#ffcc4d,#ff7a00);"></div>
        </div>
    </div>

    <div>
        @if ($showModal)
            <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
                <div class="bg-[#181818] text-white p-6 rounded-2xl w-96 border border-black/70 shadow-2xl">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-[#ff7a00]">Datos de la Empresa</h2>
                        <button wire:click="closeModal" class="text-gray-300 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mt-4">
                        <form class="max-w-md mx-auto space-y-4">
                            <!-- Nombre -->
                            <div class="relative z-0 w-full group">
                                <input
                                    wire:model="nombre"
                                    type="text"
                                    id="floating_nombre"
                                    class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2
                                           border-gray-500 appearance-none focus:outline-none focus:border-[#ff7a00] peer"
                                    placeholder=" "
                                    required />
                                <label for="floating_nombre"
                                       class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                              -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                              peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                              peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                    Nombre
                                </label>
                                @error('nombre')
                                    <span class="text-red-400 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Dirección -->
                            <div class="relative z-0 w-full group">
                                <input
                                    wire:model="direccion"
                                    type="text"
                                    id="floating_direccion"
                                    class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2
                                           border-gray-500 appearance-none focus:outline-none focus:border-[#ff7a00] peer"
                                    placeholder=" "
                                    required />
                                <label for="floating_direccion"
                                       class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                              -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                              peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                              peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                    Dirección
                                </label>
                                @error('direccion')
                                    <span class="text-red-400 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Latitud y Longitud -->
                            <div class="relative z-0 w-full group">
                                <input
                                    wire:model="latLog"
                                    type="text"
                                    id="floating_latLog"
                                    class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2
                                           border-gray-500 appearance-none focus:outline-none focus:border-[#ff7a00] peer"
                                    placeholder=" "
                                    required />
                                <label for="floating_latLog"
                                       class="peer-focus:font-medium absolute text-sm text-gray-300 duration-300 transform
                                              -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                              peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                                              peer-focus:scale-75 peer-focus:-translate-y-6 peer-focus:text-[#ffcc4d]">
                                    Latitud y Longitud
                                </label>
                                @error('latLog')
                                    <span class="text-red-400 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>

                    <div class="mt-5 flex justify-end gap-3">
                        <button
                            wire:click="enviarClick()"
                            type="submit"
                            class="flex-1 text-black bg-[#ff7a00] hover:bg-[#ff9d2e] focus:ring-4 focus:outline-none
                                   focus:ring-[#ff7a00]/40 font-semibold rounded-lg text-sm px-5 py-2.5 text-center shadow-md">
                            Enviar
                        </button>

                        <button
                            wire:click="closeModal"
                            class="flex-1 bg-gray-600 text-white py-2.5 px-4 rounded-lg hover:bg-gray-700 shadow-md">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
