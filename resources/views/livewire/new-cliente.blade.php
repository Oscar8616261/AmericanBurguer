<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- FONDO OSCURECIDO -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <!-- MODAL -->
            <div class="relative bg-[#181818] text-white rounded-2xl shadow-2xl border border-black/60 w-full max-w-lg mx-4 z-50 overflow-hidden">
                <!-- HEADER -->
                <div class="px-6 py-4 border-b border-black/50 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-[#ff7a00]">Registro de Cliente</h3>
                    <button wire:click="closeModal" class="text-gray-300 hover:text-[#ff7a00] transition">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- CUERPO -->
                <div class="px-6 py-5">
                    <form wire:submit.prevent="enviarClick" novalidate class="space-y-3">
                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Nombre</label>
                            <input type="text"
                                   wire:model.defer="nombre"
                                   class="w-full border border-black/60 rounded px-3 py-2 bg-[#2a2a2a] text-white placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]" />
                            @error('nombre') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Apellidos</label>
                            <input type="text"
                                   wire:model.defer="apellidos"
                                   class="w-full border border-black/60 rounded px-3 py-2 bg-[#2a2a2a] text-white placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]" />
                            @error('apellidos') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Cédula de Identidad (CI)</label>
                            <input type="text"
                                   wire:model.defer="ci"
                                   class="w-full border border-black/60 rounded px-3 py-2 bg-[#2a2a2a] text-white placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]" />
                            @error('ci') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Dirección</label>
                            <input type="text"
                                   wire:model.defer="direccion"
                                   class="w-full border border-black/60 rounded px-3 py-2 bg-[#2a2a2a] text-white placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]" />
                            @error('direccion') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-1">
                            <label class="block text-sm text-gray-300 mb-1">Correo Electrónico</label>
                            <input type="email"
                                   wire:model.defer="email"
                                   class="w-full border border-black/60 rounded px-3 py-2 bg-[#2a2a2a] text-white placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]" />
                            @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-3 pt-3">
                            <button type="button"
                                    wire:click="closeModal"
                                    class="px-4 py-2 rounded bg-gray-600 hover:bg-gray-700 text-white font-semibold transition">
                                Cancelar
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 rounded bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold shadow-md transition">
                                Registrarme
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
