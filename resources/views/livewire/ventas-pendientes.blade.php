<div class="p-4">
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
                            <p class="text-lg font-bold">Total: Bs. {{ number_format($venta->total, 2) }}</p>
                            <p class="text-sm text-yellow-600 font-semibold">Estado: {{ $venta->status }}</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h3 class="font-medium">Detalles</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-2">
                            @foreach($venta->detalles as $det)
                                <div class="border p-2 rounded">
                                    <p class="text-sm font-semibold">{{ $det->producto->nombre ?? 'Producto eliminado' }}</p>
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
