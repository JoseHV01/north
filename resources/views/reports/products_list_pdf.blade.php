<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de Productos</title>
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
        <h2>Listado de Productos</h2>
        @if(!empty($filters['product']))
            <div>Filtro aplicado: <strong>"{{ $filters['product'] }}"</strong></div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Descripcion</th>
                <th>Categoria</th>
                <th class="right">Precio</th>
                <th class="right">Existencia</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($products as $product)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->category_name ?? 'N/A' }}</td>
                    <td class="right">{{ number_format($product->price ?? 0, 2) }} $</td>
                    <td class="right">{{ $product->existence ?? 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay registros.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px; font-size:10px; color:#666">Generado: {{ date('d/m/Y H:i') }}</div>
</body>
</html>