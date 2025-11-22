<div class="p-4 relative" wire:poll.3000ms="loadVentasPendientes">
    {{-- CAMPANITA: aparece solo si hay pendientes --}}
    @if($pendientesCount > 0)
        <div class="absolute top-2 right-4">
            <button type="button" title="Ventas pendientes" class="relative focus:outline-none" aria-label="Ventas pendientes">
                <!-- Icono campana (SVG) -->
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

                <!-- Badge rojo con número -->
                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white rounded-full bg-red-600">
                    {{ $pendientesCount > 9 ? '9+' : $pendientesCount }}
                </span>
            </button>
        </div>
    @endif

    <h2 class="text-xl font-semibold mb-4">Ventas Pendientes</h2>

    @if($ventas->isEmpty())
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">No hay ventas en estado <strong>pendiente</strong>.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($ventas as $venta)
                <div class="bg-white p-4 rounded shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-gray-500">Venta #: <strong>{{ $venta->id_venta }}</strong></p>
                            <p class="text-sm text-gray-500">Fecha: <strong>{{ $venta->fecha_venta }}</strong></p>
                            <p class="text-sm text-gray-500">Cliente: <strong>{{ $venta->cliente->nombre ?? 'N/A' }} {{ $venta->cliente->apellidos ?? '' }}</strong></p>
                        </div>

                        <div class="text-right">
                            <p class="text-blue-700 font-bold">Total: Bs. {{ number_format($venta->total, 2) }}</p>
                            <p class="text-sm text-yellow-600 font-semibold">Estado: {{ $venta->status }}</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h3 class="font-medium text-blue-700">Detalles</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-2">
                            @foreach($venta->detalles as $det)
                                <div class="border p-2 rounded">
                                    <p class="text-sm text-gray-500">{{ $det->producto->nombre ?? 'Producto eliminado' }}</p>
                                    <p class="text-sm text-gray-500">Cant: {{ $det->cantidad }}</p>
                                    <p class="text-sm text-gray-500">Precio: Bs. {{ number_format($det->precio,2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-3 flex justify-end space-x-2">
                        @if(auth()->guard('web')->check())
                            <button wire:click="confirmVenta({{ $venta->id_venta }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Confirmar (descontar stock)
                            </button>
                        @else
                            <span class="text-sm text-gray-500">Inicia sesión como administrador para confirmar.</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Modal global manejado por ModalTicket en el layout --}}
