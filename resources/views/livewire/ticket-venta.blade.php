<div>
    <div class="py-10"
         style="background: radial-gradient(circle at top, #2b2b2b 0%, #181818 60%, #050505 100%);">

        <h2 class="text-3xl md:text-4xl font-bold text-center mb-2 text-[#ff7a00] drop-shadow-md">
            Vista Previa de Venta
        </h2>
        <p class="text-center text-gray-300 mb-6">American Burger</p>

        <div class="container mx-auto px-4" id="ticket-container">
            <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-2xl p-5 border border-black/10">
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
                <div class="flex flex-wrap items-center justify-end gap-2 mt-6">
                    <button onclick="imprimirTicket()"
                            class="bg-[#ff7a00] hover:bg-[#ff9d2e] text-black font-semibold px-4 py-2 rounded-lg shadow-md transition">
                        Imprimir
                    </button>
                    <button onclick="descargarTicketPDF()"
                            class="bg-[#d6452f] hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition">
                        Descargar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        function imprimirTicket() {
            window.print();
        }

        async function descargarTicketPDF() {
            if (!window.jspdf || !window.html2canvas) {
                alert('No se pudo cargar el generador de PDF.');
                return;
            }

            const { jsPDF } = window.jspdf;
            const node = document.getElementById('ticket-container');
            const canvas = await html2canvas(node, {
                scale: 2,
                useCORS: true,
                allowTaint: true
            });

            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            const pageWidth  = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const imgWidth   = pageWidth - 20;
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

            const id = '{{ $venta->id_venta ?? '' }}';
            pdf.save(`ticket_venta_${id}.pdf`);
        }
    </script>
</div>
