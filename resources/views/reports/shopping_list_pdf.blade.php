<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Compras</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Listado de Compras</h2>
        @if(!empty($filters))
            <div>
                <strong>Filtros aplicados:</strong>
                <ul style="list-style:none; padding:0;">
                    @if(!empty($filters['provider']))
                        <li>Proveedor ID: <strong>{{ $filters['provider'] }}</strong></li>
                    @endif
                    @if(!empty($filters['number_bills']))
                        <li>Numero factura: <strong>{{ $filters['number_bills'] }}</strong></li>
                    @endif
                    @if(!empty($filters['start']) || !empty($filters['end']))
                        <li>Rango fechas: <strong>{{ $filters['start'] ?? '-' }} / {{ $filters['end'] ?? '-' }}</strong></li>
                    @endif
                </ul>
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>N° Fact</th>
                <th>Fecha</th>
                <th>Tipo Doc</th>
                <th>Documento</th>
                <th>Proveedor</th>
                <th class="right">Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($shopping as $shop)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $shop->invoice_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($shop->date)->format('d/m/Y') }}</td>
                    <td>{{ $shop->document_type ?? '-' }}</td>
                    <td>{{ $shop->document ?? '-' }}</td>
                    <td>{{ $shop->business_name ?? 'Sin Personalizar' }}</td>
                    <td class="right">{{ number_format($shop->total ?? 0, 2) }} $</td>
                    <td>{{ $shop->status == 0 ? 'Vigente' : 'Anulada' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay registros.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px; font-size:10px; color:#666">Generado: {{ date('d/m/Y H:i') }}</div>
</body>
</html>
