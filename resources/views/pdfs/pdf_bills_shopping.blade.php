<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Compra N°{{ $data[0]->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            line-height: 18pt;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .header > div {
            display: table-cell;
            vertical-align: top;
        }

        .company-info {
            text-align: right;
            width: 40%;
        }

        .invoice-details {
            width: 60%;
        }

        .client-info, .invoice-metadata {
            width: 100%;
            margin-bottom: 20px;
        }

        .client-info table, .invoice-metadata table {
            width: 100%;
            border-collapse: collapse;
        }

        .client-info th, .client-info td, .invoice-metadata th, .invoice-metadata td {
            text-align: left;
            padding: 5px;
            border: 1px solid #ddd;
        }
        .client-info th { background-color: #f2f2f2; }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .item-table th, .item-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .item-table th {
            background-color: #f2f2f2;
            text-transform: uppercase;
        }

        .totals-box {
            width: 100%;
            margin-top: 20px;
            display: table;
        }

        .totals-box > div {
            display: table-cell;
            width: 50%; /* Dividir en dos columnas */
            vertical-align: top;
        }

        .totals-box .calculations {
            width: 100%;
            max-width: 300px; /* Ancho fijo para la sección de totales */
            margin-left: auto; /* Alinear a la derecha */
            border: 1px solid #000;
            padding: 10px;
        }

        .totals-box .calculation-row {
            display: table;
            width: 100%;
        }

        .totals-box .calculation-row > div {
            display: table-cell;
            padding: 3px;
        }

        .totals-box .label { text-align: left; }
        .totals-box .value { text-align: right; font-weight: bold; }
        .total-final .value { background-color: #ccc; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="invoice-details">
                <h1 style="color: #333; font-size: 16pt;">FACTURA DE COMPRA</h1>
                <div>**N° Factura:** {{ $data[0]->invoice_number }}</div>
                <div>**N° Control:** {{ $data[0]->id }}</div>
                <div>**Fecha de Venta:** {{ \Carbon\Carbon::parse($data[0]->created_at)->format("d/m/Y") }}</div>
                </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #ccc;">

        <div class="client-info">
            <table>
                <thead>
                    <tr>
                        <th colspan="3" style="background-color: #ccc; text-align: center;">DATOS DEL PROVEEDOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">**Razón Social / Nombre:** {{ $data[0]->business_name }}</td>
                    </tr>
                    <tr>
                        <td>
                            **RIF / C.I:**
                            @if($data[0]->business_name == "Sin Personalizar")
                                Sin Especificar
                            @else
                                {{ $data[0]->document_type }}{{ $data[0]->document }}
                            @endif
                        </td>
                        <td>**Teléfono:** {{ $data[0]->phone }}</td>
                        <td>**Condición de Pago:** {{ $data[0]->payments->pluck('shape_payment')->join(', ') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="item-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Descripción</th>
                    <th style="width: 15%;">Cantidad</th>
                    <th style="width: 15%;">Precio Unitario (Bs)</th>
                    <th style="width: 20%;">Total (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data[1] as $product)
                    <tr>
                        <td style="text-align: left;">{{ $product->description }}</td>
                        <td>{{ number_format($product->amount, 2) }}</td>
                        <td>{{ number_format($product->price * $data[4], 2) }} Bs</td>
                        <td>{{ number_format($product->amount * $product->price * $data[4], 2) }} Bs</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- <div class="totals-box">
            <div>
                @if($data[0]->igtf > 0)
                    <div>**Tasa BCV:** {{ number_format($data[0]->bcv, 4) }}</div>
                @endif
            </div>
            <div class="calculations">
                <div class="calculation-row">
                    <div class="label">Base Imponible:</div>
                    <div class="value">{{ number_format($data[0]->tax_base, 2) }}</div>
                </div>

                <div class="calculation-row">
                    <div class="label">IVA ({{ $data[0]->iva }}%):</div>
                    @php
                        $ivaAmount = ($data[0]->iva * $data[0]->tax_base) / 100;
                    @endphp
                    <div class="value">{{ number_format($ivaAmount, 2) }}</div>
                </div>

                @if($data[0]->igtf > 0)
                    @php
                        $subtotalPlusIva = $data[0]->tax_base + $ivaAmount;
                        $igtfAmount = ($subtotalPlusIva * $data[0]->igtf) / 100;
                    @endphp
                    <div class="calculation-row">
                        <div class="label">IGTF ({{ $data[0]->igtf }}%):</div>
                        <div class="value">{{ number_format($igtfAmount, 2) }}</div>
                    </div>
                @endif

                <hr style="border: 0; border-top: 1px solid #000;">

                <div class="calculation-row total-final">
                    <div class="label">**TOTAL A PAGAR (Bs):**</div>
                    <div class="value">**{{ number_format($data[0]->total, 2) }} Bs**</div>
                </div>
            </div>
        </div> --}}
    </div>
</body>
</html>