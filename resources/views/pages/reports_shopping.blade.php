@extends('layouts.app')
@section('title', 'Facturas de Compras')
@section('content')
	<div class="card">
	    <div class="card-body">
            <div class="row">
                <div class="col-sm-6 col-12 d-flex align-items-center">
                    <a href="{{ url('bills/shopping') }}" class="fw-semibold mb-0 h4"style="color: #5D87FF">Reporte Diario de Compras</a>
                </div>
                <div class="col-sm-6 col-12 d-sm-flex justify-content-end">
                    <a href="{{ url('bills/shopping') }}" class="btn btn-primary">Atras</a>
                </div>
            </div>
            @if(isset($shoppingByShape) && count($shoppingByShape) > 0)
                @foreach($shoppingByShape as $shape => $shopping)
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
                                            <th>Proveedor</th>
                                            <th>Pago en {{ $shape }}</th>
                                            <th>Total de Compra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($shopping as $shop)
                                            <tr>
                                                <td scope="row">{{ $shop->id }}</td>
                                                <td>{{ $shop->invoice_number }}</td>
                                                <td>
                                                    @if($shop->business_name == 'Sin Personalizar')
                                                        {{ $shop->business_name }}
                                                    @else
                                                        {{ $shop->document_type }} {{ $shop->document }} <br>
                                                        {{ $shop->business_name }}
                                                    @endif
                                                </td>
                                                <td>{{ $shop->amount_pay }}{{ $shape == "Divisas" ? ' $' : ' $' }}</td>
                                                <td>{{ floor(($shop->total) * pow(10, 2)) / pow(10, 2) }} $</td>
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
