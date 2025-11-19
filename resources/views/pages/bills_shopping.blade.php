@extends('layouts.app')
@section('title', 'Compras')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <a href="{{ url('bills/shopping') }}" class="fw-semibold mb-0 h4" style="color: #5D87FF">Compras</a>
            </div>

            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <a role="button" class="btn btn-primary m-1" href="{{ url('shopping/create') }}"
                        data-toggle="tooltip" title="Agregar">
                        <span><i class="ti ti-plus"></i></span>
                    </a>
                </div>
            </div>
        </div>

        @if(count($shopping) > 0)
            <form action="{{ url('bills/search/purchases') }}" method="get" class="row mt-4 mb-3">
                <div class="form-group col-12 col-md-3 mb-3 mb-md-0">
                    <small class="form-label">Proveedor</small>
                    <select name="provider" class="form-control">
                        <option value="">- Seleccione -</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->business_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-12 col-md-3 mb-3 mb-md-0">
                    <small class="form-label">Numero Factura</small>
                    <input type="number" class="form-control" name="number_bills">
                </div>

                <div class="form-group col-6 col-md-2 mb-3 mb-md-0">
                    <small class="form-label">Fecha Inicio</small>
                    <input type="date" class="form-control" name="start" max="{{ date("Y-m-d") }}">
                </div>

                <div class="form-group col-6 col-md-2 mb-3 mb-md-0">
                    <small class="form-label">Fecha Fin</small>
                    <input type="date" class="form-control" name="end" max="{{ date("Y-m-d") }}">
                </div>

                <div class="col-12 col-md-2 d-flex align-items-center pt-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search"></i>
                    </button>
                </div>
            </form>
        @endif

        @if(count($shopping) > 0)
            <div class="table-responsive">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>N°</th>
                            <th>Proveedor</th>
                            {{-- <th>Operacion</th> --}}
                            <th>Estado</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shopping as $shop)
                            <tr>
                                <td scope="row">
                                    {{ \Carbon\Carbon::parse($shop->date)->format("d/m/Y") }}
                                </td>
                                <td>
                                    {{ $shop->invoice_number }}
                                </td>
                                <td>
                                    @if($shop->business_name == 'Sin Personalizar')
                                        {{ $shop->business_name }}
                                    @else
                                        {{ $shop->document_type }} {{ $shop->document }} {{ $shop->business_name }}
                                    @endif
                                </td>
                                {{-- <td>
                                    {{ $shop->state }}
                                </td> --}}
                                <td>
                                    {{ $shop->status == 0 ? 'Vigente' : 'Anulada' }}
                                </td>
                                <td>
                                    {{ floor(($shop->total) * pow(10, 2)) / pow(10, 2) }} $
                                </td>
                                <td>
                                    
                                    <a href="{{ url("bills/shopping/$shop->id") }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Detalles" target="_blank">
                                        <span><i class="ti ti-eye"></i></span>
                                    </a>

                                    @if($shop->status == 0 && auth()->user()->id_rol == 1)
                                        <!-- ModalCancel -->
                                        <button type="button" class="btn btn-sm btn-danger my-1 m-md-1" data-toggle="modal" data-target="#modalCancel{{ $shop->id }}" data-toggle="tooltip" title="Anular">
                                            <span><i class="ti ti-clipboard-off"></i></span>
                                        </button>

                                        <div class="modal fade" id="modalCancel{{ $shop->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Anular Factura</h5>
                                                    </div>
                                                    <form method="POST" action="{{ url("bills/cancel/purchases/$shop->id") }}" autocomplete="off">
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

                                        <a href="{{ url("bills/pdf/shop/$shop->id") }}" class="btn btn-sm btn-info"  data-toggle="tooltip" title="Generar PDF">
                                            <span><i class="ti ti-file-export"></i></span>
                                        </a>

                                    @endif

                                    {{-- @if($shop->state == 'Pendiente' && $shop->status == 0 && auth()->user()->id_rol == 1)
                                        <!-- ModalChangeStateOperation -->
                                        <button type="button" class="btn btn-sm btn-dark m-1" data-toggle="modal" data-target="#modalChange{{ $shop->id }}" data-toggle="tooltip" title="Pagar">
                                            <span><i class="ti ti-credit-card"></i></span>
                                        </button>

                                        <div class="modal fade" id="modalChange{{ $shop->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Pagar Factura</h5>
                                                    </div>
                                                    <form method="POST" action="{{ url("bills/change/purchases/$shop->id") }}" autocomplete="off">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="PUT">

                                                        <div class="modal-body">
                                                            <h6>¿Esta seguro de pagar la factura N {{ $shop->invoice_number }}?</h6>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cerrar</button>
                                                            <button type="submit" class="btn btn-danger">Si, Pagar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {!! $shopping->appends(request()->query())->links() !!}
            </div>
        @else
            <div class="alert alert-danger text-center h4 mt-5" role="alert">
                No hay Facturas generadas
            </div>
        @endif
    </div>
</div>
@include('../layouts/message')
@endsection
