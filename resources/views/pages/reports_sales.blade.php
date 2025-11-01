@extends('layouts.app')
@section('title', 'Facturas de Ventas')
@section('content')
	<div class="card">
	    <div class="card-body">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <a href="{{ url('bills/sales') }}" class="fw-semibold mb-0 h4"style="color: #5D87FF">Reporte Diario de Ventas</a>
                </div>
            </div>
            @if(isset($salesByShape) && count($salesByShape) > 0)
                @foreach($salesByShape as $shape => $sales)
                    <div class="card mt-3">
                        <div class="card-header">
                            <strong>Método de pago:</strong> {{ $shape }}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mt-3">
                                    <thead>
                                        <tr>
                                            <th>N° Control</th>
                                            <th>N° Fact</th>
                                            <th>Cliente</th>
                                            <th>Pago en {{ $shape }}</th>
                                            <th>Total de Venta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td scope="row">{{ $sale->id }}</td>
                                                <td>{{ $sale->number_bill }}</td>
                                                <td>
                                                    @if($sale->business_name == 'Sin Personalizar')
                                                        {{ $sale->business_name }}
                                                    @else
                                                        {{ $sale->document_type }} {{ $sale->document }} <br>
                                                        {{ $sale->business_name }}
                                                    @endif
                                                </td>
                                                <td>{{ $sale->amount_pay }}{{ $shape == "Divisas" ? ' $' : ' Bs' }}</td>
                                                <td>{{ floor(($sale->total) * pow(10, 2)) / pow(10, 2) }} Bs</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger text-center h4 mt-5" role="alert">
                    No hay facturas generadas
                </div>
            @endif
	    </div>
	</div>
	@include('../layouts/message')
@endsection
