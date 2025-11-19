<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Productos más vendidos - {{ $monthName }} {{ $year }}</title>
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
        <h2>Productos más vendidos</h2>
        <div>{{ $monthName }} - {{ $year }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cantidad vendida</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($products as $prod)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $prod->name ?? 'N/A' }}</td>
                    <td class="right">{{ number_format($prod->total ?? 0) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay registros para este mes/año.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px; font-size:10px; color:#666">Generado: {{ date('d/m/Y H:i') }}</div>
</body>
</html>