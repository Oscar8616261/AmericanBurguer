<div>
<div class="bg-[#e8e8eb] py-10 text-black">
    <h2 class="text-3xl font-bold text-center mb-4 text-blue-700">Vista Previa de Venta</h2>
    <p class="text-center text-gray-600 mb-6">American Burger</p>

    <div class="container mx-auto px-4" id="ticket-container">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="text-sm text-gray-500">Fecha</div>
                    <div class="font-semibold">{{ $venta->fecha_venta ?? '' }}</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Ticket</div>
                    <div class="font-semibold">#{{ $venta->id_venta ?? '' }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 border rounded p-3">
                    <div class="text-sm text-gray-500">Cliente</div>
                    <div class="font-semibold">{{ ($cliente->nombre ?? '') . ' ' . ($cliente->apellidos ?? '') }}</div>
                    <div class="text-sm text-gray-600">CI: {{ $cliente->ci ?? '' }}</div>
                    <div class="text-sm text-gray-600">Dirección: {{ $cliente->direccion ?? '' }}</div>
                </div>
                <div class="bg-gray-50 border rounded p-3">
                    <div class="text-sm text-gray-500">Administrador</div>
                    <div class="font-semibold">{{ $admin->full_name ?? (($admin->nombre ?? '') . ' ' . ($admin->apellidos ?? '')) }}</div>
                    <div class="text-sm text-gray-600">ID: {{ $admin->id_usuario ?? '' }}</div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left px-4 py-2">Producto</th>
                            <th class="text-left px-4 py-2">Cantidad</th>
                            <th class="text-left px-4 py-2">Precio</th>
                            <th class="text-left px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detalles as $d)
                            @php $p = \App\Models\ProductoModel::find($d->id_producto); @endphp
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $p->nombre ?? 'Producto' }}</td>
                                <td class="px-4 py-2">{{ $d->cantidad }}</td>
                                <td class="px-4 py-2">Bs. {{ number_format($d->precio, 2, '.', ',') }}</td>
                                <td class="px-4 py-2">Bs. {{ number_format($d->precio * $d->cantidad, 2, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <div class="text-xl font-bold">Total: Bs. {{ number_format($venta->total ?? 0, 2, '.', ',') }}</div>
            </div>

            <div class="flex items-center justify-end gap-2 mt-6">
                <button onclick="imprimirTicket()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Imprimir</button>
                <button onclick="descargarTicketPDF()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Descargar PDF</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function imprimirTicket() {
        window.print();
    }
    async function descargarTicketPDF() {
        const { jsPDF } = window.jspdf;
        const node = document.getElementById('ticket-container');
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
        const id = '{{ $venta->id_venta ?? '' }}';
        pdf.save(`ticket_venta_${id}.pdf`);
    }
</script>
</div>