@extends('layouts.app')
@section('title', 'Detalles de Venta')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-9 d-flex align-items-center">
                    <a href="#" class="fw-semibold mb-0 h4"style="color: #5D87FF">Detalles de la Factura de Venta</a>
                </div>

                <div class="col-3 d-flex justify-content-end" style="gap: 10px !important;">
                    <!-- ModalCancel -->
                    @if ($sales->status == 0)
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalCancel{{ $sales->id }}" data-toggle="tooltip" title="Anular">
                            <span><i class="ti ti-clipboard-off"></i></span>
                        </button>

                        <div class="modal fade" id="modalCancel{{ $sales->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Anular Factura</h5>
                                    </div>
                                    <form method="POST" action="{{ url("bills/cancel/sales/$sales->id") }}" autocomplete="off">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="PUT">

                                        <div class="modal-body">
                                            <h6>¿Esta seguro de anular la factura?</h6>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cerrar</button>
                                            <button type="submit" class="btn btn-danger">Si, Anular</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <a href="{{ url("bills/pdf/sales/$sales->id") }}" class="btn btn-info"  data-toggle="tooltip" title="Generar PDF">
                        <span><i class="ti ti-file-export"></i></span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-8 text-center mb-3 mb-md-0">
                    <h3 class="fw-bold">{{ $company->name }}</h3>
                    <small class="d-block" style="letter-spacing: 3px">{{ $company->rif }}</small>
                    <div class="fw-bold " style="letter-spacing: 3px">{{ $company->phone }}</div>
                    <div class="mt-2">{{ $company->direction }}</div>
                    <small class="d-block mt-1">{{ $company->email }}</small>
                </div>
                <div class="col-12 col-md-4 flex-column justify-content-between d-flex ">
                    <div class="text-center d-none d-md-block">
                        <img src="{{ url("images/logos/company.png") }}" style="width: 7rem;" alt="" srcset="">
                    </div>
                    <div class="row align-items-center d-flex">
                        <div class="col-6">Fecha de Venta:</div>
                        <div class="col-6 text-end">{{ \Carbon\Carbon::parse($sales->created_at)->format("d/m/Y") }}</div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Numero Factura: <span class="fw-normal">{{ $sales->number_bill }}</span></th>
                            <th>Numero Control: <span class="fw-normal">{{ $sales->id }}</span></th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Razon Social: <span class="fw-normal">{{ $sales->business_name }}</span></th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <th>RIF / C.I:
                                <span class="fw-normal">
                                    @if($sales->business_name == 'Sin Personalizar')
                                        Sin especificar
                                    @else
                                        {{ $sales->document_type }}{{ $sales->document }}
                                    @endif
                                </span>
                            </th>
                            <th>Telefono: <span class="fw-normal">{{ $sales->phone }}</span></th>
                            <th>Forma de Pago: <span class="fw-normal">{{ $sales->payments->pluck('shape_payment')->join(', ') }}</span></th>
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
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td scope="row">{{ $product->description }}</td>
                                <td>{{ $product->amount }}</td>
                                <td>{{ floor($product->price * pow(10, 2)) / pow(10, 2) }}</td>
                                <td>{{ floor($product->amount*$product->price * pow(10, 2)) / pow(10, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-12 col-md-6">
                    @if($sales->igtf > 0)
                        B.C.V: &nbsp; <span class="d-inline-block" style="width: 4rem; border-bottom: 1px rgb(93, 135, 255) solid;">{{ $sales->bcv }}</span>
                    @endif
                </div>
                <div class="col-12 col-md-6 d-md-flex justify-content-end">
                    <div>
                        <div class="text-end mb-2 mb-md-3">
                            Base Imponible:
                            <span class="d-inline-block rounded p-2 box-details-bills text-center">{{ floor($sales->tax_base * pow(10, 2)) / pow(10, 2) }}</span>
                        </div>
                        <div class="text-end mb-2 mb-md-3">
                            I.V.A:
                            <span class="d-inline-block border-box-detail text-center">{{ $sales->iva }}</span>%
                            SOBRE
                            <span class="d-inline-block border-box-detail text-center">{{ $sales->tax_base }}</span>
                            <span class="d-inline-block rounded p-2 box-details-bills text-center">
                                {{ floor((($sales->iva * $sales->tax_base) / 100) * pow(10, 2)) / pow(10, 2) }}
                            </span>
                        </div>
                        @if($sales->igtf > 0)
                            <div class="text-end mb-2 mb-md-3">
                                IGTF:
                                <span class="d-inline-block border-box-detail text-center">{{ $sales->igtf }}</span>%
                                SOBRE
                                <span class="d-inline-block border-box-detail text-center">{{ (($sales->iva * $sales->tax_base) / 100 ) + $sales->tax_base }}</span>
                                <span class="d-inline-block rounded p-2 box-details-bills text-center">
                                    {{
                                        floor(((((($sales->iva * $sales->tax_base) / 100 ) + $sales->tax_base) * $sales->igtf) / 100) * pow(10, 2)) / pow(10, 2)
                                    }}
                                </span>
                            </div>
                        @endif
                        <div class="text-end mb-2 mb-md-3">
                            Total:
                            <span class="d-inline-block rounded p-2 box-details-bills text-center"> {{  floor($sales->total * pow(10, 2)) / pow(10, 2) }} Bs</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('../layouts/message')
@endsection
