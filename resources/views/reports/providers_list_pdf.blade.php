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
        @if(!empty($filters['provider']) || !empty($filters['type']) || !empty($filters['date_start']) || !empty($filters['date_end']))
            <div style="font-size: 11px; color: #555;">
                <strong>Filtros aplicados:</strong><br>
                @if(!empty($filters['type'])) 
                    Tipo: <strong>{{ $filters['type'] == 'provider' ? 'Proveedor' : ($filters['type'] == 'customer' ? 'Cliente' : $filters['type']) }}</strong><br>
                @endif
                @if(!empty($filters['provider'])) 
                    Búsqueda: <strong>"{{ $filters['provider'] }}"</strong><br>
                @endif
                @if(!empty($filters['date_start'])) 
                    Desde: <strong>{{ \Carbon\Carbon::parse($filters['date_start'])->format('d/m/Y') }}</strong>
                @endif
                @if(!empty($filters['date_end'])) 
                    Hasta: <strong>{{ \Carbon\Carbon::parse($filters['date_end'])->format('d/m/Y') }}</strong>
                @endif
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