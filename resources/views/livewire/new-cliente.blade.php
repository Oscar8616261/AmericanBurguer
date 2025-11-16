<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- overlay -->
            <div class="absolute inset-0 bg-black opacity-50" wire:click="closeModal"></div>

            <!-- modal -->
            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4 z-50 overflow-hidden">
                <div class="p-4 border-b flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Registro de Cliente</h3>
                    <button wire:click="closeModal" class="text-gray-600 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    <form wire:submit.prevent="enviarClick" novalidate>
                        <div class="mb-3">
                            <label class="block text-sm text-gray-700">Nombre</label>
                            <input type="text" wire:model.defer="nombre" class="w-full border rounded px-3 py-2" />
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-700">Apellidos</label>
                            <input type="text" wire:model.defer="apellidos" class="w-full border rounded px-3 py-2" />
                            @error('apellidos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-700">Cédula de Identidad (CI)</label>
                            <input type="text" wire:model.defer="ci" class="w-full border rounded px-3 py-2" />
                            @error('ci') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm text-gray-700">Dirección</label>
                            <input type="text" wire:model.defer="direccion" class="w-full border rounded px-3 py-2" />
                            @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm text-gray-700">Correo Electrónico</label>
                            <input type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2" />
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 rounded border hover:bg-gray-50">Cancelar</button>
                            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Registrarme</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Listener JS simple para mostrar notificaciones del componente -->
        <script>
            window.addEventListener('notify', event => {
                // Puedes cambiar alert por una toast personalizada si quieres
                alert(event.detail.message);
            });
        </script>
    @endif
</div>
