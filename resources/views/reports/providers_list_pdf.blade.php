<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado Clientes / Proveedores</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Listado de Clientes / Proveedores</h2>
        @if(!empty($filters['provider']) || !empty($filters['type']))
            <div>Filtros aplicados:
                @if(!empty($filters['type'])) <strong>{{ $filters['type'] }}</strong> @endif
                @if(!empty($filters['provider'])) - <strong>"{{ $filters['provider'] }}"</strong> @endif
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Razon Social</th>
                <th>Documento</th>
                <th>Telefono</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @forelse($rows as $row)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $row->type == 'provider' ? 'Proveedor' : 'Cliente' }}</td>
                    <td>{{ $row->business_name }}</td>
                    <td>{{ $row->document }}</td>
                    <td>{{ $row->phone ?? 'No registrado' }}</td>
                    <td>{{ $row->email ?? 'No registrado' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay registros.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px; font-size:10px; color:#666">Generado: {{ date('d/m/Y H:i') }}</div>
</body>
</html>