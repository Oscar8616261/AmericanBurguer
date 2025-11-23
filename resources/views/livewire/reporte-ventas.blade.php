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
@php
    $ventasSummary = [
        'count' => (int)($summary['count'] ?? 0),
        'total' => round((float)($summary['total'] ?? 0), 2),
        'avg' => round((float)($summary['avg'] ?? 0), 2),
        'items' => (int)($summary['items'] ?? 0),
        'top_nombre' => $topProductMonth->nombre ?? null,
        'top_unidades' => (int)($topProductMonth->unidades ?? 0),
        'month' => (int)($month ?? 1),
        'year' => (int)($year ?? 0),
    ];
    $ventasByDay = collect($byDay)->map(function($d){
        return [
            'dia' => $d->dia,
            'cantidad' => (int)($d->cantidad ?? 0),
            'total' => round((float)($d->total ?? 0), 2),
            'top_nombre' => $d->top_nombre,
            'top_unidades' => (int)($d->top_unidades ?? 0),
        ];
    })->values()->toArray();
    $ventasByPayment = collect($byPayment)->map(function($p){
        return [
            'nombre_pago' => $p->nombre_pago,
            'cantidad' => (int)($p->cantidad ?? 0),
            'total' => round((float)($p->total ?? 0), 2),
        ];
    })->values()->toArray();
    $ventasTopProducts = collect($topProducts)->map(function($t){
        return [
            'nombre' => $t->nombre,
            'unidades' => (int)($t->unidades ?? 0),
            'total' => round((float)($t->total ?? 0), 2),
        ];
    })->values()->toArray();
@endphp
<script>
    window.__ventasSummary = {!! json_encode($ventasSummary) !!};
    window.__ventasByDay = {!! json_encode($ventasByDay) !!};
    window.__ventasByPayment = {!! json_encode($ventasByPayment) !!};
    window.__ventasTopProducts = {!! json_encode($ventasTopProducts) !!};

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

    async function descargarPDF() {
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
        pdf.text('Reporte de Ventas Mensual', pageWidth/2, margin + 12, { align: 'center' });

        const s = window.__ventasSummary || {};
        pdf.setFontSize(10);
        pdf.text(`Generado: ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}`, pageWidth - margin, margin + 6, { align: 'right' });
        const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        pdf.text(`Periodo: ${meses[(s.month||1)-1]} ${s.year||''}`, pageWidth - margin, margin + 12, { align: 'right' });

        let y = margin + 18;
        const boxW = (pageWidth - margin*2 - 15) / 4;
        drawCell(pdf, margin, y, boxW, 12, 'Ventas', 'left', true);
        drawCell(pdf, margin, y+12, boxW, 12, `${s.count ?? 0}`, 'left');
        drawCell(pdf, margin + boxW + 5, y, boxW, 12, 'Total', 'left', true);
        drawCell(pdf, margin + boxW + 5, y+12, boxW, 12, `Bs. ${(s.total ?? 0).toFixed(2)}`, 'left');
        drawCell(pdf, margin + (boxW + 5)*2, y, boxW, 12, 'Ticket promedio', 'left', true);
        drawCell(pdf, margin + (boxW + 5)*2, y+12, boxW, 12, `Bs. ${(s.avg ?? 0).toFixed(2)}`, 'left');
        drawCell(pdf, margin + (boxW + 5)*3, y, boxW, 12, 'Items vendidos', 'left', true);
        drawCell(pdf, margin + (boxW + 5)*3, y+12, boxW, 12, `${s.items ?? 0}`, 'left');

        y += 28;
        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(12);
        pdf.text('Totales por día', margin, y);
        y += 4;

        const colWDay = [25, 25, 35, pageWidth - margin*2 - 25 - 25 - 35 - 25, 25];
        const headerH = 12;
        drawCell(pdf, margin, y, colWDay[0], headerH, 'Día', 'left', true);
        drawCell(pdf, margin + colWDay[0], y, colWDay[1], headerH, 'Ventas', 'center', true);
        drawCell(pdf, margin + colWDay[0] + colWDay[1], y, colWDay[2], headerH, 'Total', 'right', true);
        drawCell(pdf, margin + colWDay[0] + colWDay[1] + colWDay[2], y, colWDay[3], headerH, 'Producto más vendido', 'left', true);
        drawCell(pdf, margin + colWDay[0] + colWDay[1] + colWDay[2] + colWDay[3], y, colWDay[4], headerH, 'Unid.', 'center', true);
        y += headerH;

        const rowsDay = window.__ventasByDay || [];
        const minRowH = 11;
        for (let i = 0; i < rowsDay.length; i++) {
            const r = rowsDay[i];
            const nameLines = pdf.splitTextToSize(String(r.top_nombre || ''), colWDay[3] - 6);
            const rowH = Math.max(minRowH, 8 + Math.max(0, (nameLines.length - 1)) * 5);
            if (y + rowH > pageHeight - margin) {
                pdf.addPage();
                y = margin;
            }
            drawCell(pdf, margin, y, colWDay[0], rowH, r.dia, 'left');
            drawCell(pdf, margin + colWDay[0], y, colWDay[1], rowH, r.cantidad, 'center');
            drawCell(pdf, margin + colWDay[0] + colWDay[1], y, colWDay[2], rowH, `Bs. ${Number(r.total).toFixed(2)}`, 'right');
            drawCell(pdf, margin + colWDay[0] + colWDay[1] + colWDay[2], y, colWDay[3], rowH, nameLines, 'left', false, true);
            drawCell(pdf, margin + colWDay[0] + colWDay[1] + colWDay[2] + colWDay[3], y, colWDay[4], rowH, r.top_unidades, 'center');
            y += rowH;
        }

        y += 8;
        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(12);
        pdf.text('Por tipo de pago', margin, y);
        y += 4;
        const colWPay = [pageWidth - margin*2 - 60, 25, 35];
        drawCell(pdf, margin, y, colWPay[0], headerH, 'Tipo de pago', 'left', true);
        drawCell(pdf, margin + colWPay[0], y, colWPay[1], headerH, 'Ventas', 'center', true);
        drawCell(pdf, margin + colWPay[0] + colWPay[1], y, colWPay[2], headerH, 'Total', 'right', true);
        y += headerH;
        const rowsPay = window.__ventasByPayment || [];
        for (let i = 0; i < rowsPay.length; i++) {
            const r = rowsPay[i];
            const rowH = minRowH;
            if (y + rowH > pageHeight - margin) {
                pdf.addPage();
                y = margin;
            }
            drawCell(pdf, margin, y, colWPay[0], rowH, r.nombre_pago, 'left');
            drawCell(pdf, margin + colWPay[0], y, colWPay[1], rowH, r.cantidad, 'center');
            drawCell(pdf, margin + colWPay[0] + colWPay[1], y, colWPay[2], rowH, `Bs. ${Number(r.total).toFixed(2)}`, 'right');
            y += rowH;
        }

        y += 8;
        pdf.setFont('helvetica', 'bold');
        pdf.setFontSize(12);
        pdf.text('Top 5 Productos', margin, y);
        y += 4;
        const colWTop = [pageWidth - margin*2 - 60, 25, 35];
        drawCell(pdf, margin, y, colWTop[0], headerH, 'Producto', 'left', true);
        drawCell(pdf, margin + colWTop[0], y, colWTop[1], headerH, 'Unidades', 'center', true);
        drawCell(pdf, margin + colWTop[0] + colWTop[1], y, colWTop[2], headerH, 'Total', 'right', true);
        y += headerH;
        const rowsTop = window.__ventasTopProducts || [];
        for (let i = 0; i < rowsTop.length; i++) {
            const r = rowsTop[i];
            const nameLines = pdf.splitTextToSize(String(r.nombre || ''), colWTop[0] - 6);
            const rowH = Math.max(minRowH, 8 + Math.max(0, (nameLines.length - 1)) * 5);
            if (y + rowH > pageHeight - margin) {
                pdf.addPage();
                y = margin;
            }
            drawCell(pdf, margin, y, colWTop[0], rowH, nameLines, 'left', false, true);
            drawCell(pdf, margin + colWTop[0], y, colWTop[1], rowH, r.unidades, 'center');
            drawCell(pdf, margin + colWTop[0] + colWTop[1], y, colWTop[2], rowH, `Bs. ${Number(r.total).toFixed(2)}`, 'right');
            y += rowH;
        }

        const mSel = document.querySelector('select[wire\\:model="month"]');
        const ySel = document.querySelector('input[wire\\:model="year"]');
        const m    = mSel ? mSel.value : '';
        const yv   = ySel ? ySel.value : '';
        const fname = `reporte_ventas_${String(m).padStart(2,'0')}_${yv}.pdf`;
        pdf.save(fname);
    }
</script>
