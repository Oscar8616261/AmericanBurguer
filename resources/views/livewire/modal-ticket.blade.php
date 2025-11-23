<div>
    @if($show)
        <div id="global-modal-root"
             class="fixed inset-0 bg-black/60 flex items-center justify-center z-[99999]">
            <div class="bg-[#181818] rounded-xl shadow-2xl w-full max-w-3xl border border-black/70 relative p-1">
                <!-- Botón cerrar -->
                <button wire:click="close"
                        class="absolute top-3 right-4 text-gray-300 hover:text-[#ff7a00] text-xl font-bold transition">
                    ✕
                </button>

                {{-- Contenido del ticket (mantengo fondo claro dentro por legibilidad) --}}
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($ventaId)
                        @livewire('ticket-venta', ['ventaId' => $ventaId], key('global-ticket-'.$ventaId))
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
