<div class="py-10"
     style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 60%, #050505 100%);">

    <h2 class="text-4xl md:text-5xl font-bold text-center mb-2 text-[#ff7a00] drop-shadow-md">
        Reporte de Ventas Mensual
    </h2>
    <p class="text-center text-gray-300 mb-8">American Burger</p>

    <div class="container mx-auto px-4 text-white" id="reporte-container">
        <!-- Filtros + resumen -->
        <div class="bg-[#181818] rounded-lg shadow-2xl p-4 mb-6 border border-black/60">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Mes</label>
                    <select wire:model="month"
                            class="w-full p-2 rounded bg-[#2a2a2a] border border-black/60 text-white
                                   focus:outline-none focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]">
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Año</label>
                    <input type="number" wire:model="year" min="2000" max="2100"
                           class="w-full p-2 rounded bg-[#2a2a2a] border border-black/60 text-white
                                  focus:outline-none focus:ring-2 focus:ring-[#ff7a00] focus:border-[#ff7a00]">
                </div>

                <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-5 gap-3">
                    <div class="rounded-lg p-3 bg-[#0b2740] border border-blue-700/60">
                        <div class="text-xs text-blue-200">Ventas</div>
                        <div class="text-2xl font-bold text-blue-300">
                            {{ $summary['count'] ?? 0 }}
                        </div>
                    </div>

                    <div class="rounded-lg p-3 bg-[#09351f] border border-green-700/60">
                        <div class="text-xs text-green-200">Total</div>
                        <div class="text-2xl font-bold text-green-300">
                            Bs. {{ number_format($summary['total'] ?? 0, 2, '.', ',') }}
                        </div>
                    </div>

                    <div class="rounded-lg p-3 bg-[#4a3807] border border-yellow-600/70">
                        <div class="text-xs text-yellow-200">Ticket Promedio</div>
                        <div class="text-2xl font-bold text-yellow-300">
                            Bs. {{ number_format($summary['avg'] ?? 0, 2, '.', ',') }}
                        </div>
                    </div>

                    <div class="rounded-lg p-3 bg-[#2b1843] border border-purple-700/70">
                        <div class="text-xs text-purple-200">Items Vendidos</div>
                        <div class="text-2xl font-bold text-purple-300">
                            {{ $summary['items'] ?? 0 }}
                        </div>
                    </div>

                    <div class="rounded-lg p-3 bg-[#4b1932] border border-pink-700/70">
                        <div class="text-xs text-pink-200">Top Producto (mes)</div>
                        <div class="text-sm font-semibold text-pink-200 truncate">
                            {{ $topProductMonth->nombre ?? 'Sin datos' }}
                        </div>
                        <div class="text-xs text-pink-200/80">
                            Unidades: {{ $topProductMonth->unidades ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Totales por día + tipo de pago -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Tabla por día -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-xl p-4 text-black">
                <h3 class="text-xl font-semibold text-[#ff7a00] mb-3">Totales por día</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border rounded">
                        <thead>
                            <tr class="bg-[#1a1a1a] text-white">
                                <th class="text-left px-4 py-2 text-sm font-semibold">Día</th>
                                <th class="text-left px-4 py-2 text-sm font-semibold">Ventas</th>
                                <th class="text-left px-4 py-2 text-sm font-semibold">Total</th>
                                <th class="text-left px-4 py-2 text-sm font-semibold">Producto más vendido</th>
                                <th class="text-left px-4 py-2 text-sm font-semibold">Unidades</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($byDay as $d)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-900">{{ $d->dia }}</td>
                                    <td class="px-4 py-2 text-gray-900">{{ $d->cantidad }}</td>
                                    <td class="px-4 py-2 text-gray-900">
                                        Bs. {{ number_format($d->total, 2, '.', ',') }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-900">{{ $d->top_nombre }}</td>
                                    <td class="px-4 py-2 text-gray-900">{{ $d->top_unidades }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-4 text-center text-gray-500" colspan="5">
                                        Sin datos
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Por tipo de pago -->
            <div class="bg-[#181818] rounded-lg shadow-2xl p-4 border border-black/60">
                <h3 class="text-xl font-semibold text-[#ff7a00] mb-3">Por tipo de pago</h3>
                <div class="space-y-2">
                    @forelse($byPayment as $p)
                        <div class="flex items-center justify-between border border-black/50 rounded px-3 py-2 bg-[#242424]">
                            <div>
                                <div class="font-medium text-white">{{ $p->nombre_pago }}</div>
                                <div class="text-xs text-gray-400">Ventas: {{ $p->cantidad }}</div>
                            </div>
                            <div class="text-green-300 font-bold">
                                Bs. {{ number_format($p->total, 2, '.', ',') }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400">Sin datos</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top 5 productos -->
        <div class="bg-white rounded-lg shadow-xl p-4 mt-6 text-black">
            <h3 class="text-xl font-semibold text-[#ff7a00] mb-3">Top 5 Productos</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @forelse($topProducts as $t)
                    <div class="bg-white border rounded-lg p-3 hover:shadow-md transition">
                        <div class="h-24 flex items-center justify-center bg-gray-50 rounded mb-2">
                            @if($t->foto)
                                <img src="/storage/img/{{ $t->foto }}" alt="{{ $t->nombre }}" class="max-h-24 object-contain">
                            @else
                                <span class="text-gray-400 text-xs">Sin imagen</span>
                            @endif
                        </div>
                        <div class="font-semibold truncate text-gray-900">{{ $t->nombre }}</div>
                        <div class="text-sm text-gray-600">Unidades: {{ $t->unidades }}</div>
                        <div class="text-sm text-green-700">
                            Total: Bs. {{ number_format($t->total, 2, '.', ',') }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Sin datos</p>
                @endforelse
            </div>
        </div>

        <!-- Botón PDF -->
        <div class="flex justify-end mt-6">
            <button id="btn-pdf"
                    onclick="descargarPDF()"
                    class="bg-[#d6452f] hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition">
                Descargar PDF
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    async function descargarPDF() {
        if (!window.jspdf || !window.html2canvas) {
            alert('No se pudo cargar el generador de PDF. Verifica tu conexión.');
            return;
        }

        const { jsPDF } = window.jspdf;
        const node = document.getElementById('reporte-container');
        const canvas = await html2canvas(node, {
            scale: 2,
            useCORS: true,
            allowTaint: true
        });
        const imgData = canvas.toDataURL('image/png');

        const pdf = new jsPDF('p', 'mm', 'a4');
        const pageWidth  = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imgWidth   = pageWidth - 20; // margin
        const imgHeight  = canvas.height * imgWidth / canvas.width;

        if (imgHeight <= pageHeight - 20) {
            pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
        } else {
            let yPosPx = 0;
            const usableHeightMm = pageHeight - 20;
            const usableHeightPx = usableHeightMm * canvas.width / imgWidth;

            while (yPosPx < canvas.height) {
                const sliceHeightPx = Math.min(usableHeightPx, canvas.height - yPosPx);
                const sliceCanvas = document.createElement('canvas');
                sliceCanvas.width  = canvas.width;
                sliceCanvas.height = sliceHeightPx;

                const ctx = sliceCanvas.getContext('2d');
                ctx.drawImage(
                    canvas,
                    0, yPosPx, canvas.width, sliceHeightPx,
                    0, 0, canvas.width, sliceHeightPx
                );

                const sliceImg = sliceCanvas.toDataURL('image/png');
                pdf.addImage(
                    sliceImg,
                    'PNG',
                    10,
                    10,
                    imgWidth,
                    sliceHeightPx * imgWidth / canvas.width
                );

                yPosPx += sliceHeightPx;
                if (yPosPx < canvas.height) pdf.addPage();
            }
        }

        const mSel = document.querySelector('select[wire\\:model="month"]');
        const ySel = document.querySelector('input[wire\\:model="year"]');
        const m    = mSel ? mSel.value : '';
        const y    = ySel ? ySel.value : '';
        const fname = `reporte_ventas_${String(m).padStart(2,'0')}_${y}.pdf`;
        pdf.save(fname);
    }
</script>
