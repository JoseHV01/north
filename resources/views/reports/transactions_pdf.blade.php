<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Distribución de transacciones - {{ $monthName }} {{ $year }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Distribución de transacciones</h2>
        <div>{{ $monthName }} - {{ $year }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Forma de pago</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; $grand = 0; @endphp
            @forelse($records as $rec)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $rec->name ?? '-' }}</td>
                    <td style="text-align: right">{{ number_format($rec->total ?? 0) }}</td>
                </tr>
                @php $grand += ($rec->total ?? 0); @endphp
            @empty
                <tr>
                    <td colspan="3">No hay registros para este mes/año.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="2" class="total">Total</td>
                <td class="total" style="text-align: right">{{ number_format($grand) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top:20px; font-size:10px; color:#666">Generado: {{ date('d/m/Y H:i') }}</div>
</body>
</html>