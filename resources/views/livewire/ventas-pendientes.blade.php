<div class="p-4 relative bg-[#181818] rounded-2xl shadow-2xl border border-black/60 text-white"
     wire:poll.3000ms="loadVentasPendientes">

    {{-- CAMPANITA: aparece solo si hay pendientes --}}
    @if($pendientesCount > 0)
        <div class="absolute top-3 right-4">
            <button type="button"
                    title="Ventas pendientes"
                    class="relative focus:outline-none"
                    aria-label="Ventas pendientes">
                <!-- Icono campana (SVG) -->
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                     stroke="#ffcc4d" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

                <!-- Badge rojo con número -->
                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white rounded-full bg-red-600 shadow-md">
                    {{ $pendientesCount > 9 ? '9+' : $pendientesCount }}
                </span>
            </button>
        </div>
    @endif

    <h2 class="text-xl font-bold mb-4 text-[#ff7a00]">
        Ventas Pendientes
    </h2>

    @if($ventas->isEmpty())
        <div class="bg-[#202020] border border-black/50 p-4 rounded-xl shadow">
            <p class="text-gray-300">
                No hay ventas en estado <strong class="text-[#ffcc4d]">pendiente</strong>.
            </p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($ventas as $venta)
                <div class="bg-white p-4 rounded-xl shadow-md border border-gray-200 text-black">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-500">
                                Venta #:
                                <strong class="text-gray-900">{{ $venta->id_venta }}</strong>
                            </p>
                            <p class="text-xs text-gray-500">
                                Fecha:
                                <strong class="text-gray-900">{{ $venta->fecha_venta }}</strong>
                            </p>
                            <p class="text-xs text-gray-500">
                                Cliente:
                                <strong class="text-gray-900">
                                    {{ $venta->cliente->nombre ?? 'N/A' }} {{ $venta->cliente->apellidos ?? '' }}
                                </strong>
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-[#ff7a00] font-bold text-sm">
                                Total: Bs. {{ number_format($venta->total, 2) }}
                            </p>
                            <p class="text-xs text-yellow-600 font-semibold">
                                Estado: {{ $venta->status }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h3 class="font-semibold text-sm text-[#0A3D91]">
                            Detalles
                        </h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-2">
                            @foreach($venta->detalles as $det)
                                <div class="border border-gray-200 p-2 rounded-lg bg-gray-50">
                                    <p class="text-sm text-gray-700 font-medium">
                                        {{ $det->producto->nombre ?? 'Producto eliminado' }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        Cant: {{ $det->cantidad }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        Precio: Bs. {{ number_format($det->precio,2) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-3 flex justify-end space-x-2">
                        @if(auth()->guard('web')->check())
                            <button wire:click="confirmVenta({{ $venta->id_venta }})"
                                    class="bg-[#ff7a00] hover:bg-[#ff9d2e] text-black px-4 py-2 rounded-lg font-semibold shadow-sm transition">
                                Confirmar (descontar stock)
                            </button>
                        @else
                            <span class="text-xs text-gray-500">
                                Inicia sesión como administrador para confirmar.
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Modal global manejado por ModalTicket en el layout --}}
