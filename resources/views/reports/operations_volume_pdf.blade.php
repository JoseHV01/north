<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Volumen de operaciones - {{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
        .totals { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Volumen de compras y ventas</h2>
        <div>{{ $year }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Mes</th>
                <th class="right">Compras (cant)</th>
                <th class="right">Ventas (cant)</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($rows as $row)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $row->monthName }} ({{ str_pad($row->month, 2, '0', STR_PAD_LEFT) }})</td>
                    <td class="right">{{ number_format($row->purchases) }}</td>
                    <td class="right">{{ number_format($row->sales) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay registros para este año.</td>
                </tr>
            @endforelse
            <tr class="totals">
                <td colspan="2">Total</td>
                <td class="right">{{ number_format($grandPurchases) }}</td>
                <td class="right">{{ number_format($grandSales) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top:20px; font-size:10px; color:#666">Generado: {{ date('d/m/Y H:i') }}</div>
</body>
</html>