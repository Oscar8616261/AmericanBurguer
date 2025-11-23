<div class="py-10"
     style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 60%, #050505 100%);">

    <h2 class="text-4xl md:text-5xl font-bold text-center mb-2 text-[#ff7a00] drop-shadow-md">
        Reporte de Productos Más Vendidos
    </h2>
    <p class="text-center text-gray-300 mb-8">American Burger</p>

    <div class="container mx-auto px-4 text-white" id="reporte-productos">
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

                <div class="md:col-span-2 grid grid-cols-3 gap-3">
                    <div class="rounded-lg p-3 bg-[#09351f] border border-green-700/60">
                        <div class="text-xs text-green-200">Unidades vendidas</div>
                        <div class="text-2xl font-bold text-green-300">
                            {{ $summary['unidades_total'] ?? 0 }}
                        </div>
                    </div>

                    <div class="rounded-lg p-3 bg-[#0b2740] border border-blue-700/60">
                        <div class="text-xs text-blue-200">Productos con ventas</div>
                        <div class="text-2xl font-bold text-blue-300">
                            {{ $summary['productos_vendidos'] ?? 0 }}
                        </div>
                    </div>

                    <div class="rounded-lg p-3 bg-[#4a3807] border border-yellow-600/70">
                        <div class="text-xs text-yellow-200">Ingresos</div>
                        <div class="text-2xl font-bold text-yellow-300">
                            Bs. {{ number_format($summary['ingresos_total'] ?? 0, 2, '.', ',') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla ranking -->
        <div class="bg-white rounded-lg shadow-xl p-4 text-black">
            <h3 class="text-xl font-semibold text-[#ff7a00] mb-3">Ranking Top 20</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded">
                    <thead>
                        <tr class="bg-[#1a1a1a] text-white">
                            <th class="text-left px-4 py-2 text-sm font-semibold">Producto</th>
                            <th class="text-left px-4 py-2 text-sm font-semibold">Unidades</th>
                            <th class="text-left px-4 py-2 text-sm font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ranking as $r)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                                            @if($r->foto)
                                                <img src="/storage/img/{{ $r->foto }}" alt="{{ $r->nombre }}" class="object-cover w-12 h-12">
                                            @else
                                                <span class="text-gray-400 text-xs">Sin imagen</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $r->nombre }}</div>
                                            @if($r->precio_unidad)
                                                <div class="text-xs text-gray-500">
                                                    Precio unidad: Bs. {{ number_format($r->precio_unidad, 2, '.', ',') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-gray-800 font-medium">{{ $r->unidades }}</td>
                                <td class="px-4 py-2 font-semibold text-[#ff7a00]">
                                    Bs. {{ number_format($r->total, 2, '.', ',') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-4 text-center text-gray-500" colspan="3">
                                    Sin datos
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Botón PDF -->
        <div class="flex justify-end mt-6">
            <button id="btn-pdf-prod"
                    onclick="descargarPDFProductos()"
                    class="bg-[#d6452f] hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition">
                Descargar PDF
            </button>
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

        const mSel = document.querySelector('select[wire\\:model="month"]');
        const ySel = document.querySelector('input[wire\\:model="year"]');
        const m = mSel ? mSel.value : '';
        const y = ySel ? ySel.value : '';
        pdf.save(`reporte_productos_${String(m).padStart(2,'0')}_${y}.pdf`);
    }
</script>
