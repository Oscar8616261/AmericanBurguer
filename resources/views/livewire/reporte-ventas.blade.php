<div class="bg-[#e8e8eb] py-10 text-black">
    <h2 class="text-4xl md:text-5xl font-bold text-center mb-2 text-blue-700">Reporte de Ventas Mensual</h2>
    <p class="text-center text-gray-600 mb-8">American Burger</p>

    <div class="container mx-auto px-4" id="reporte-container">
        <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mes</label>
                    <select wire:model="month" class="w-full p-2 border rounded">
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
                    <label class="block text-sm font-medium text-gray-700">Año</label>
                    <input type="number" wire:model="year" class="w-full p-2 border rounded" min="2000" max="2100">
                </div>
                <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-5 gap-3">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="text-xs text-blue-700">Ventas</div>
                        <div class="text-2xl font-bold text-blue-800">{{ $summary['count'] ?? 0 }}</div>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <div class="text-xs text-green-700">Total</div>
                        <div class="text-2xl font-bold text-green-800">Bs. {{ number_format($summary['total'] ?? 0, 2, '.', ',') }}</div>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <div class="text-xs text-yellow-700">Ticket Promedio</div>
                        <div class="text-2xl font-bold text-yellow-800">Bs. {{ number_format($summary['avg'] ?? 0, 2, '.', ',') }}</div>
                    </div>
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                        <div class="text-xs text-purple-700">Items Vendidos</div>
                        <div class="text-2xl font-bold text-purple-800">{{ $summary['items'] ?? 0 }}</div>
                    </div>
                    <div class="bg-pink-50 border border-pink-200 rounded-lg p-3">
                        <div class="text-xs text-pink-700">Top Producto (mes)</div>
                        <div class="text-sm font-semibold text-pink-800 truncate">{{ $topProductMonth->nombre ?? 'Sin datos' }}</div>
                        <div class="text-xs text-pink-700">Unidades: {{ $topProductMonth->unidades ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
                <h3 class="text-xl font-semibold text-blue-700 mb-3">Totales por día</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border rounded">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left px-4 py-2">Día</th>
                                <th class="text-left px-4 py-2">Ventas</th>
                                <th class="text-left px-4 py-2">Total</th>
                                <th class="text-left px-4 py-2">Producto más vendido</th>
                                <th class="text-left px-4 py-2">Unidades</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($byDay as $d)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $d->dia }}</td>
                                    <td class="px-4 py-2">{{ $d->cantidad }}</td>
                                    <td class="px-4 py-2">Bs. {{ number_format($d->total, 2, '.', ',') }}</td>
                                    <td class="px-4 py-2">{{ $d->top_nombre }}</td>
                                    <td class="px-4 py-2">{{ $d->top_unidades }}</td>
                                </tr>
                            @empty
                                <tr><td class="px-4 py-2" colspan="3" class="text-gray-500">Sin datos</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-xl font-semibold text-blue-700 mb-3">Por tipo de pago</h3>
                <div class="space-y-2">
                    @forelse($byPayment as $p)
                        <div class="flex items-center justify-between border rounded px-3 py-2">
                            <div>
                                <div class="font-medium">{{ $p->nombre_pago }}</div>
                                <div class="text-xs text-gray-500">Ventas: {{ $p->cantidad }}</div>
                            </div>
                            <div class="text-green-700 font-bold">Bs. {{ number_format($p->total, 2, '.', ',') }}</div>
                        </div>
                    @empty
                        <p class="text-gray-500">Sin datos</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 mt-6">
            <h3 class="text-xl font-semibold text-blue-700 mb-3">Top 5 Productos</h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @forelse($topProducts as $t)
                    <div class="bg-white border rounded-lg p-3">
                        <div class="h-24 flex items-center justify-center bg-gray-50 rounded mb-2">
                            @if($t->foto)
                                <img src="/storage/img/{{ $t->foto }}" alt="{{ $t->nombre }}" class="max-h-24 object-contain">
                            @else
                                <span class="text-gray-400">Sin imagen</span>
                            @endif
                        </div>
                        <div class="font-semibold truncate">{{ $t->nombre }}</div>
                        <div class="text-sm text-gray-600">Unidades: {{ $t->unidades }}</div>
                        <div class="text-sm text-green-700">Total: Bs. {{ number_format($t->total, 2, '.', ',') }}</div>
                    </div>
                @empty
                    <p class="text-gray-500">Sin datos</p>
                @endforelse
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button id="btn-pdf" onclick="descargarPDF()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Descargar PDF</button>
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
        const canvas = await html2canvas(node, { scale: 2, useCORS: true, allowTaint: true });
        const imgData = canvas.toDataURL('image/png');

        const pdf = new jsPDF('p', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();

        const imgWidth = pageWidth - 20; // margin
        const imgHeight = canvas.height * imgWidth / canvas.width;

        if (imgHeight <= pageHeight - 20) {
            pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
        } else {
            let yPosPx = 0;
            const usableHeightMm = pageHeight - 20;
            const usableHeightPx = usableHeightMm * canvas.width / imgWidth;
            while (yPosPx < canvas.height) {
                const sliceHeightPx = Math.min(usableHeightPx, canvas.height - yPosPx);
                const sliceCanvas = document.createElement('canvas');
                sliceCanvas.width = canvas.width;
                sliceCanvas.height = sliceHeightPx;
                const ctx = sliceCanvas.getContext('2d');
                ctx.drawImage(canvas, 0, yPosPx, canvas.width, sliceHeightPx, 0, 0, canvas.width, sliceHeightPx);
                const sliceImg = sliceCanvas.toDataURL('image/png');
                pdf.addImage(sliceImg, 'PNG', 10, 10, imgWidth, sliceHeightPx * imgWidth / canvas.width);
                yPosPx += sliceHeightPx;
                if (yPosPx < canvas.height) pdf.addPage();
            }
        }

        const mSel = document.querySelector('select[wire\:model="month"]');
        const ySel = document.querySelector('input[wire\:model="year"]');
        const m = mSel ? mSel.value : '';
        const y = ySel ? ySel.value : '';
        const fname = `reporte_ventas_${String(m).padStart(2,'0')}_${y}.pdf`;
        pdf.save(fname);
    }
</script>