<div class="bg-[#e8e8eb] py-10 text-black">
    <h2 class="text-4xl md:text-5xl font-bold text-center mb-2 text-blue-700">Reporte de Productos Más Vendidos</h2>
    <p class="text-center text-gray-600 mb-8">American Burger</p>

    <div class="container mx-auto px-4" id="reporte-productos">
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
                <div class="md:col-span-2 grid grid-cols-3 gap-3">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <div class="text-xs text-green-700">Unidades vendidas</div>
                        <div class="text-2xl font-bold text-green-800">{{ $summary['unidades_total'] ?? 0 }}</div>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <div class="text-xs text-blue-700">Productos con ventas</div>
                        <div class="text-2xl font-bold text-blue-800">{{ $summary['productos_vendidos'] ?? 0 }}</div>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <div class="text-xs text-yellow-700">Ingresos</div>
                        <div class="text-2xl font-bold text-yellow-800">Bs. {{ number_format($summary['ingresos_total'] ?? 0, 2, '.', ',') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <h3 class="text-xl font-semibold text-blue-700 mb-3">Ranking Top 20</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left px-4 py-2">Producto</th>
                            <th class="text-left px-4 py-2">Unidades</th>
                            <th class="text-left px-4 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ranking as $r)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                                            @if($r->foto)
                                            <img src="/storage/img/{{ $r->foto }}" alt="{{ $r->nombre }}" class="object-cover w-12 h-12">
                                            @else
                                            <span class="text-gray-400">Sin imagen</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ $r->nombre }}</div>
                                            @if($r->precio_unidad)
                                            <div class="text-xs text-gray-500">Precio unidad: Bs. {{ number_format($r->precio_unidad, 2, '.', ',') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2">{{ $r->unidades }}</td>
                                <td class="px-4 py-2">Bs. {{ number_format($r->total, 2, '.', ',') }}</td>
                            </tr>
                        @empty
                            <tr><td class="px-4 py-2" colspan="3" class="text-gray-500">Sin datos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button id="btn-pdf-prod" onclick="descargarPDFProductos()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Descargar PDF</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    async function descargarPDFProductos() {
        if (!window.jspdf || !window.html2canvas) {
            alert('No se pudo cargar el generador de PDF.');
            return;
        }
        const { jsPDF } = window.jspdf;
        const node = document.getElementById('reporte-productos');
        const canvas = await html2canvas(node, { scale: 2, useCORS: true, allowTaint: true });
        const imgData = canvas.toDataURL('image/png');

        const pdf = new jsPDF('p', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imgWidth = pageWidth - 20;
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
        pdf.save(`reporte_productos_${String(m).padStart(2,'0')}_${y}.pdf`);
    }
</script>