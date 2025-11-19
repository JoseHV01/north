@extends('layouts.app')
@section('title', 'Detalles de Compra')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <a href="#" class="fw-semibold mb-0 h4"style="color: #5D87FF">Detalles de la Factura de Compra</a>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <h5 class="mb-4">Numero de factura: &nbsp; N° {{ $shopping->invoice_number }}</h5>
                    <h5>Numero de control: &nbsp; N° {{ $shopping->control_number }}</h5>
                </div>
                <div class="col-12 col-md-6 text-start text-md-end">
                    <h5>Fecha de Compra: &nbsp; {{ \Carbon\Carbon::parse($shopping->date)->format("d/m/Y") }}</h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Razon Social: <span class="fw-normal">{{ $shopping->business_name }}</span></th>
                            <th>Domicilio Fiscal:
                                <span class="fw-normal">{{ $shopping->business_name == 'Sin Personalizar' ? 'Sin Especificar' : $shopping->direction }}</span>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-2">
                    <tbody>
                        <tr>
                            <th>RIF:
                                <span class="fw-normal">
                                    @if($shopping->business_name == 'Sin Personalizar')
                                        Sin Especificar
                                    @else
                                        {{ $shopping->document_type }}{{ $shopping->document }}
                                    @endif
                                </span>
                            </th>
                            <th>Forma de Pago:
                                <span class="fw-normal">
                                    {{ $shopping->payments->pluck('shape_payment')->join(', ') }} 
                                </span>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio (Bs)</th>
                            <th>% Ganancia</th>
                            <th>Total (Bs)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td scope="row">{{ $product->description }}</td>
                                <td>{{ $product->amount }}</td>
                                <td>{{ floor(($product->price * floatval($shopping->bcv)) * pow(10, 2)) / pow(10, 2) }} Bs</td>
                                <td>{{ $product->percentaje }}%</td>
                                <td>{{ floor(($product->amount * $product->price * floatval($shopping->bcv)) * pow(10, 2)) / pow(10, 2) }} Bs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-5 mt-md-4">
                <div class="col-md-6 col-12">
                    <div class="">
                        <h5>B.C.V: &nbsp; {{ $shopping->bcv }} Bs</h5>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="d-flex justify-content-end">
                        <h5>Total Pagado: &nbsp; {{ $shopping->total }} Bs</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('../layouts/message')
@endsection
