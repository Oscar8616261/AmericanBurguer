<div>
    <div class="py-10"
         style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 60%, #050505 100%);">

        <h2 class="text-3xl md:text-4xl font-bold text-center mb-2 text-[#ff7a00] drop-shadow-md">
            Vista Previa de Venta
        </h2>
        <p class="text-center text-gray-300 mb-6">American Burger</p>

        <div class="container mx-auto px-4" id="ticket-container">
            <div id="ticket-card"
                 data-summary='{"fecha":"{{ $venta->fecha_venta ?? '' }}","id":"{{ $venta->id_venta ?? '' }}","total":{{ round((float)($venta->total ?? 0), 2) }},"cliente_nombre":"{{ trim(($cliente->nombre ?? '') . ' ' . ($cliente->apellidos ?? '')) }}","cliente_ci":"{{ $cliente->ci ?? '' }}","cliente_direccion":"{{ $cliente->direccion ?? '' }}","admin_nombre":"{{ $admin->full_name ?? trim(($admin->nombre ?? '') . ' ' . ($admin->apellidos ?? '')) }}","admin_id":"{{ $admin->id_usuario ?? '' }}" }'
                 class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-5 border border-black/10">
                <!-- Encabezado fecha / ticket -->
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <div class="text-xs text-gray-500 uppercase tracking-wide">Fecha</div>
                        <div class="font-semibold text-gray-900">{{ $venta->fecha_venta ?? '' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500 uppercase tracking-wide">Ticket</div>
                        <div class="font-semibold text-gray-900">#{{ $venta->id_venta ?? '' }}</div>
                    </div>
                </div>

                <!-- Cliente / Admin -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <div class="text-xs text-gray-500 uppercase tracking-wide">Cliente</div>
                        <div class="font-semibold text-gray-900">
                            {{ ($cliente->nombre ?? '') . ' ' . ($cliente->apellidos ?? '') }}
                        </div>
                        <div class="text-sm text-gray-600 mt-1">CI: {{ $cliente->ci ?? '' }}</div>
                        <div class="text-sm text-gray-600">Dirección: {{ $cliente->direccion ?? '' }}</div>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <div class="text-xs text-gray-500 uppercase tracking-wide">Administrador</div>
                        <div class="font-semibold text-gray-900">
                            {{ $admin->full_name ?? (($admin->nombre ?? '') . ' ' . ($admin->apellidos ?? '')) }}
                        </div>
                        <div class="text-sm text-gray-600 mt-1">ID: {{ $admin->id_usuario ?? '' }}</div>
                    </div>
                </div>

                <!-- Detalle productos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-[#1a1a1a] text-white text-sm">
                                <th class="text-left px-4 py-2">Producto</th>
                                <th class="text-left px-4 py-2">Cantidad</th>
                                <th class="text-left px-4 py-2">Precio</th>
                                <th class="text-left px-4 py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalles as $d)
                                @php $p = \App\Models\ProductoModel::find($d->id_producto); @endphp
                                <tr class="border-t border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-900">{{ $p->nombre ?? 'Producto' }}</td>
                                    <td class="px-4 py-2 text-gray-800">{{ $d->cantidad }}</td>
                                    <td class="px-4 py-2 text-gray-800">
                                        Bs. {{ number_format($d->precio, 2, '.', ',') }}
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-[#ff7a00]">
                                        Bs. {{ number_format($d->precio * $d->cantidad, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="flex justify-end mt-4">
                    <div class="text-xl font-bold text-gray-900">
                        Total:
                        <span class="text-[#ff7a00]">
                            Bs. {{ number_format($venta->total ?? 0, 2, '.', ',') }}
                        </span>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex flex-wrap items-center justify-end gap-2 mt-6 ticket-actions" data-no-print="true">
                    <button id="btn-imprimir-ticket"
                            class="bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold px-4 py-2 rounded-lg shadow-md transition">
                        Imprimir
                    </button>
                    <button id="btn-pdf-ticket"
                            class="bg-[#d6452f] hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition">
                        Descargar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function imprimirTicket() {
            const card = document.getElementById('ticket-card');
            const w = window.open('', '_blank');
            if (w && typeof w.document !== 'undefined') {
                w.document.write('<html><head><title>Ticket</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">');
                w.document.write('<style>body{font-family:Arial,Helvetica,sans-serif;padding:16px;background:#fff} table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:6px} th{background:#1a1a1a;color:#fff} .text-right{text-align:right}</style>');
                w.document.write('</head><body>');
                w.document.write(card.outerHTML);
                w.document.write('</body></html>');
                w.document.close();
                w.focus();
                w.print();
                w.close();
            } else {
                window.print();
            }
        }

        function ensureJsPDF() {
            return new Promise((resolve, reject) => {
                if (window.jspdf) return resolve();
                const s = document.createElement('script');
                s.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
                s.onload = () => resolve();
                s.onerror = () => reject(new Error('No se pudo cargar jsPDF'));
                document.head.appendChild(s);
            });
        }

        async function descargarTicketPDF() {
            try {
                await ensureJsPDF();
            } catch(e) {
                alert('No se pudo cargar el generador de PDF.');
                return;
            }
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const margin = 10;

            function drawCell(pdfDoc, x, y, w, h, text, align, bold, topAlign) {
                pdfDoc.setDrawColor(200);
                pdfDoc.rect(x, y, w, h);
                pdfDoc.setFont('helvetica', bold ? 'bold' : 'normal');
                const padding = 3;
                const baseTy = topAlign ? (y + padding + 3) : (y + h/2 + 3);
                if (Array.isArray(text)) {
                    let ty = baseTy;
                    for (const line of text) {
                        const tx = align === 'center' ? x + w/2 : (align === 'right' ? x + w - padding : x + padding);
                        const opts = align === 'center' ? { align: 'center' } : (align === 'right' ? { align: 'right' } : undefined);
                        pdfDoc.text(String(line), tx, ty, opts);
                        ty += 5;
                    }
                } else {
                    const tx = align === 'center' ? x + w/2 : (align === 'right' ? x + w - padding : x + padding);
                    const opts = align === 'center' ? { align: 'center' } : (align === 'right' ? { align: 'right' } : undefined);
                    pdfDoc.text(String(text), tx, baseTy, opts);
                }
            }

            pdf.setFont('helvetica', 'bold');
            pdf.setFontSize(18);
            pdf.text('American Burger', pageWidth/2, margin + 6, { align: 'center' });
            pdf.setFont('helvetica', 'normal');
            pdf.setFontSize(12);
            pdf.text('Ticket de Venta', pageWidth/2, margin + 12, { align: 'center' });

            const s = window.__ticketSummary || {};
            pdf.setFontSize(10);
            pdf.text(`Fecha: ${s.fecha || ''}`, pageWidth - margin, margin + 6, { align: 'right' });
            pdf.text(`Ticket: #${s.id || ''}`, pageWidth - margin, margin + 12, { align: 'right' });

            let y = margin + 18;
            const halfW = (pageWidth - margin*2 - 5) / 2;
            drawCell(pdf, margin, y, halfW, 18, ['Cliente', `${s.cliente_nombre || ''}`, `CI: ${s.cliente_ci || ''}`, `Dir.: ${s.cliente_direccion || ''}`], 'left', true, true);
            drawCell(pdf, margin + halfW + 5, y, halfW, 18, ['Administrador', `${s.admin_nombre || ''}`, `ID: ${s.admin_id || ''}`], 'left', true, true);
            y += 24;

            pdf.setFont('helvetica', 'bold');
            pdf.setFontSize(12);
            pdf.text('Detalle', margin, y);
            y += 4;

            const colW = [pageWidth - margin*2 - 60, 20, 20, 20];
            const headerH = 12;
            drawCell(pdf, margin, y, colW[0], headerH, 'Producto', 'left', true);
            drawCell(pdf, margin + colW[0], y, colW[1], headerH, 'Cant.', 'center', true);
            drawCell(pdf, margin + colW[0] + colW[1], y, colW[2], headerH, 'Precio', 'right', true);
            drawCell(pdf, margin + colW[0] + colW[1] + colW[2], y, colW[3], headerH, 'Subt.', 'right', true);
            y += headerH;

            const rows = window.__ticketRows || [];
            const minRowH = 11;
            for (let i = 0; i < rows.length; i++) {
                const r = rows[i];
                const nameLines = pdf.splitTextToSize(String(r.nombre || ''), colW[0] - 6);
                const rowH = Math.max(minRowH, 8 + Math.max(0, (nameLines.length - 1)) * 5);
                if (y + rowH > pageHeight - margin - 20) {
                    pdf.addPage();
                    y = margin;
                }
                drawCell(pdf, margin, y, colW[0], rowH, nameLines, 'left', false, true);
                drawCell(pdf, margin + colW[0], y, colW[1], rowH, r.cantidad, 'center');
                drawCell(pdf, margin + colW[0] + colW[1], y, colW[2], rowH, `Bs. ${Number(r.precio).toFixed(2)}`, 'right');
                drawCell(pdf, margin + colW[0] + colW[1] + colW[2], y, colW[3], rowH, `Bs. ${Number(r.subtotal).toFixed(2)}`, 'right');
                y += rowH;
            }

            y += 6;
            pdf.setFont('helvetica', 'bold');
            pdf.setFontSize(12);
            pdf.text(`Total: Bs. ${Number(s.total || 0).toFixed(2)}`, pageWidth - margin, y, { align: 'right' });

            const id = s.id || '';
            pdf.save(`ticket_venta_${id}.pdf`);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const impBtn = document.getElementById('btn-imprimir-ticket');
            const pdfBtn = document.getElementById('btn-pdf-ticket');
            if (impBtn) impBtn.addEventListener('click', imprimirTicket);
            if (pdfBtn) pdfBtn.addEventListener('click', descargarTicketPDF);
        });
    </script>
    @php
        $ticketSummary = [
            'fecha' => $venta->fecha_venta ?? '',
            'id' => $venta->id_venta ?? '',
            'total' => round((float)($venta->total ?? 0), 2),
            'cliente_nombre' => trim(($cliente->nombre ?? '').' '.($cliente->apellidos ?? '')),
            'cliente_ci' => $cliente->ci ?? '',
            'cliente_direccion' => $cliente->direccion ?? '',
            'admin_nombre' => ($admin->full_name ?? trim(($admin->nombre ?? '').' '.($admin->apellidos ?? ''))),
            'admin_id' => $admin->id_usuario ?? ''
        ];
        $ticketRows = collect($detalles)->map(function($d){
            $p = \App\Models\ProductoModel::find($d->id_producto);
            return [
                'nombre' => $p->nombre ?? 'Producto',
                'cantidad' => (int)($d->cantidad ?? 0),
                'precio' => round((float)($d->precio ?? 0), 2),
                'subtotal' => round((float)($d->precio ?? 0) * (int)($d->cantidad ?? 0), 2),
            ];
        })->values()->toArray();
    @endphp
    <script>
        window.__ticketSummary = {!! json_encode($ticketSummary) !!};
        window.__ticketRows = {!! json_encode($ticketRows) !!};
    </script>
</div>
