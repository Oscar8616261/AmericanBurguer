<div>
    @if($show)
    <div id="global-modal-root" class="fixed inset-0 bg-[#00000066] flex items-center justify-center z-[99999]">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl relative">
            <button wire:click="close" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900">✕</button>
            @if($ventaId)
                @livewire('ticket-venta', ['ventaId' => $ventaId], key('global-ticket-'.$ventaId))
            @endif
        </div>
    </div>
    @endif
</div>