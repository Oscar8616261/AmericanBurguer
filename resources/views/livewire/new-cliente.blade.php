<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-100 w-full max-w-lg mx-4 z-50 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-blue-700">Registro de Cliente</h3>
                    <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="px-6 py-5">
                    <form wire:submit.prevent="enviarClick" novalidate>
                        <div class="mb-3">
                            <label class="block text-sm text-gray-700">Nombre</label>
                            <input type="text" wire:model.defer="nombre" class="w-full border rounded px-3 py-2 text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-700">Apellidos</label>
                            <input type="text" wire:model.defer="apellidos" class="w-full border rounded px-3 py-2 text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('apellidos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-700">Cédula de Identidad (CI)</label>
                            <input type="text" wire:model.defer="ci" class="w-full border rounded px-3 py-2 text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('ci') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-700">Dirección</label>
                            <input type="text" wire:model.defer="direccion" class="w-full border rounded px-3 py-2 text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700">Correo Electrónico</label>
                            <input type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2 text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-3 pt-1">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 rounded bg-gray-600 text-white hover:bg-gray-700">Cancelar</button>
                            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Registrarme</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif
</div>
