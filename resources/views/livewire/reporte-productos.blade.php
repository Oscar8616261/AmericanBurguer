<div class="py-10"
     style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 60%, #050505 100%);">

    <h2 class="text-4xl md:text-5xl font-bold text-center mb-2 text-[#ff7a00] drop-shadow-md">
        Reporte de Productos Más Vendidos
    </h2>
    <p class="text-center text-gray-300 mb-8">American Burger</p>

    <div class="container mx-auto px-4" id="reporte-productos">
        <div id="pdf-productos" class="hidden"></div>

            {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4">
                <div class="rounded-lg p-3 bg-green-50 border border-green-200">
                    <div class="text-xs text-green-700">Unidades vendidas</div>
                    <div class="text-2xl font-bold text-green-800">{{ $summary['unidades_total'] ?? 0 }}</div>
                </div>
                <div class="rounded-lg p-3 bg-blue-50 border border-blue-200">
                    <div class="text-xs text-blue-700">Productos con ventas</div>
                    <div class="text-2xl font-bold text-blue-800">{{ $summary['productos_vendidos'] ?? 0 }}</div>
                </div>
                <div class="rounded-lg p-3 bg-yellow-50 border border-yellow-200">
                    <div class="text-xs text-yellow-700">Ingresos</div>
                    <div class="text-2xl font-bold text-yellow-800">Bs. {{ number_format($summary['ingresos_total'] ?? 0, 2, '.', ',') }}</div>
                </div>
            </div> --}}

            {{-- <div class="mt-5">
                <h3 class="text-xl font-semibold text-blue-700 mb-2">Ranking Top 20</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border rounded">
                        <thead>
                            <tr class="bg-gray-900 text-white">
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
                                            <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden flex items-center justify-center">
                                                @if($r->foto)
                                                    <img src="/storage/img/{{ $r->foto }}" alt="{{ $r->nombre }}" class="object-cover w-10 h-10">
                                                @else
                                                    <span class="text-gray-400 text-xs">Sin imagen</span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $r->nombre }}</div>
                                                @if($r->precio_unidad)
                                                    <div class="text-xs text-gray-500">Precio unidad: Bs. {{ number_format($r->precio_unidad, 2, '.', ',') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 font-medium">{{ $r->unidades }}</td>
                                    <td class="px-4 py-2 font-semibold text-orange-600">Bs. {{ number_format($r->total, 2, '.', ',') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-4 text-center text-gray-500" colspan="3">Sin datos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> --}}
        </div>
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
@php
    $rankingRows = collect($ranking)->map(function($r){
        return [
            'nombre' => $r->nombre,
            'unidades' => (int)($r->unidades ?? 0),
            'total' => round((float)($r->total ?? 0), 2),
            'precio_unidad' => isset($r->precio_unidad) ? round((float)$r->precio_unidad, 2) : null,
        ];
    })->values()->toArray();
    $summaryData = [
        'unidades_total' => (int)($summary['unidades_total'] ?? 0),
        'productos_vendidos' => (int)($summary['productos_vendidos'] ?? 0),
        'ingresos_total' => round((float)($summary['ingresos_total'] ?? 0), 2),
        'month' => (int)($month ?? 1),
        'year' => (int)($year ?? 0),
    ];
@endphp
<script>
    window.__rankingData = {!! json_encode($rankingRows) !!};
    window.__summaryData = {!! json_encode($summaryData) !!};

    function drawCell(pdf, x, y, w, h, text, align='left', bold=false, topAlign=false) {
        pdf.setDrawColor(200);
        pdf.rect(x, y, w, h);
        pdf.setFont('helvetica', bold ? 'bold' : 'normal');
        const padding = 3;
        const baseTy = topAlign ? (y + padding + 3) : (y + h/2 + 3);
        if (Array.isArray(text)) {
            let ty = baseTy;
            for (const line of text) {
                const tx = align === 'center' ? x + w/2 : (align === 'right' ? x + w - padding : x + padding);
                const opts = align === 'center' ? { align: 'center' } : (align === 'right' ? { align: 'right' } : undefined);
                pdf.text(String(line), tx, ty, opts);
                ty += 5;
            }
        } else {
            const tx = align === 'center' ? x + w/2 : (align === 'right' ? x + w - padding : x + padding);
            const opts = align === 'center' ? { align: 'center' } : (align === 'right' ? { align: 'right' } : undefined);
            pdf.text(String(text), tx, baseTy, opts);
        }
    }

    async function descargarPDFProductos() {
        if (!window.jspdf) {
            alert('Generador PDF no disponible');
            return;
        }
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const margin = 10;

        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(18);
        pdf.text('American Burger', pageWidth/2, margin + 6, { align: 'center' });
        pdf.setFont('helvetica', 'normal');
        pdf.setFontSize(12);
        pdf.text('Productos más vendidos', pageWidth/2, margin + 12, { align: 'center' });

        const s = window.__summaryData || {};
        pdf.setFontSize(10);
        pdf.text(`Generado: ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}`, pageWidth - margin, margin + 6, { align: 'right' });
        const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        pdf.text(`Periodo: ${meses[(s.month||1)-1]} ${s.year||''}`, pageWidth - margin, margin + 12, { align: 'right' });

        let y = margin + 18;
        const boxW = (pageWidth - margin*2 - 10) / 3;
        drawCell(pdf, margin, y, boxW, 12, `Unidades vendidas`, 'left', true);
        drawCell(pdf, margin, y+12, boxW, 12, `${s.unidades_total ?? 0}`, 'left');
        drawCell(pdf, margin + boxW + 5, y, boxW, 12, `Productos con ventas`, 'left', true);
        drawCell(pdf, margin + boxW + 5, y+12, boxW, 12, `${s.productos_vendidos ?? 0}`, 'left');
        drawCell(pdf, margin + (boxW + 5)*2, y, boxW, 12, `Ingresos`, 'left', true);
        drawCell(pdf, margin + (boxW + 5)*2, y+12, boxW, 12, `Bs. ${(s.ingresos_total ?? 0).toFixed(2)}`, 'left');

        y += 28;
        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(12);
        pdf.text('Ranking Top 20', margin, y);
        y += 4;

        const colW = [pageWidth - margin*2 - 70, 30, 40];
        const headerH = 12;
        drawCell(pdf, margin, y, colW[0], headerH, 'Producto', 'left', true);
        drawCell(pdf, margin + colW[0], y, colW[1], headerH, 'Unidades', 'center', true);
        drawCell(pdf, margin + colW[0] + colW[1], y, colW[2], headerH, 'Total', 'right', true);
        y += headerH;

        const rows = window.__rankingData || [];
        const minRowH = 11;
        for (let i = 0; i < rows.length; i++) {
            const r = rows[i];
            let nombre = r.precio_unidad ? `${r.nombre}\nPrecio unidad: Bs. ${Number(r.precio_unidad).toFixed(2)}` : r.nombre;
            const nameLines = pdf.splitTextToSize(String(nombre), colW[0] - 6);
            const rowH = Math.max(minRowH, 8 + (nameLines.length - 1) * 5);
            if (y + rowH > pageHeight - margin) {
                pdf.addPage();
                y = margin;
            }
            drawCell(pdf, margin, y, colW[0], rowH, nameLines, 'left', false, true);
            drawCell(pdf, margin + colW[0], y, colW[1], rowH, r.unidades, 'center');
            drawCell(pdf, margin + colW[0] + colW[1], y, colW[2], rowH, `Bs. ${Number(r.total).toFixed(2)}`, 'right');
            y += rowH;
        }

        const mSel = document.querySelector('select[wire\\:model="month"]');
        const ySel = document.querySelector('input[wire\\:model="year"]');
        const m = mSel ? mSel.value : '';
        const yv = ySel ? ySel.value : '';
        pdf.save(`reporte_productos_${String(m).padStart(2,'0')}_${yv}.pdf`);
    }
</script>
