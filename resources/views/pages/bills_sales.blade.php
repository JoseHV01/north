@extends('layouts.app')
@section('title', 'Facturas de Ventas')
@section('content')
	<div class="card">
	    <div class="card-body">
	    	<div class="row">
                <div class="col-6 d-flex align-items-center">
                    <a href="{{ url('bills/sales') }}" class="fw-semibold mb-0 h4"style="color: #5D87FF">Ventas</a>
                </div>

                <div class="col-6">
					<div class="d-flex justify-content-end">
                        <a role="button" class="btn btn-primary m-1" href="{{ url('report/sales') }}" data-toggle="tooltip" title="Agregar">
							<span><i class="ti ti-report"></i></span> Reporte Diario
						</a>
						<a role="button" class="btn btn-primary m-1" href="{{ url('sales/create') }}" data-toggle="tooltip" title="Agregar">
							<span><i class="ti ti-plus"></i></span>
						</a>
					</div>
                </div>
            </div>

            @if(count($sales) > 0)
                <form action="{{ url('bills/search/sales') }}" method="get" class="row mt-4 mb-3">
                    <div class="form-group col-12 col-md-3 mb-3 mb-md-0">
                        <small class="form-label">Cliente</small>
                        <select name="customer" class="form-control">
                            <option value="">- Seleccione -</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->business_name }}</option>
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

                    <div class="col-12 col-md-2 d-flex align-items-center pt-1 pt-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i>
                        </button>
                    </div>
                </form>
            @endif

			@if(count($sales) > 0)
				<div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>N° Control</th>
                                <th>N° Fact</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                {{-- <th>Operacion</th> --}}
                                <th>Estado</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td scope="row">
                                        {{ $sale->id }}
                                    </td>
                                    <td>
                                        {{ $sale->number_bill }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($sale->created_at)->format("d/m/Y") }} -
                                        {{ \Carbon\Carbon::parse($sale->created_at)->format("h:i A") }}
                                    </td>
                                    <td>
                                        @if($sale->business_name == 'Sin Personalizar')
                                            {{ $sale->business_name }}
                                        @else
                                            {{ $sale->document_type }} {{ $sale->document }} <br>
                                            {{ $sale->business_name }}
                                        @endif
                                    </td>
                                    {{-- <td>
                                        {{ $sale->state }}
                                    </td> --}}
                                    <td>
                                        {{ $sale->status == 0 ? 'Vigente' : 'Anulada' }}
                                    </td>
                                    <td>
                                        {{ floor(($sale->total) * pow(10, 2)) / pow(10, 2) }} Bs
                                    </td>
                                    <td>
                                        <a href="{{ url("bills/sales/$sale->id") }}" class="btn btn-sm btn-success mb-2" data-toggle="tooltip" title="Detalles" target="_blank">
                                            <span><i class="ti ti-eye"></i></span>
                                        </a>

                                        @if($sale->status == 0 && auth()->user()->id_rol == 1)
                                            <!-- ModalCancel -->
                                            <button type="button" class="btn btn-sm btn-danger mb-2" data-toggle="modal" data-target="#modalCancel{{ $sale->id }}" data-toggle="tooltip" title="Anular">
                                                <span><i class="ti ti-clipboard-off"></i></span>
                                            </button>

                                            <div class="modal fade" id="modalCancel{{ $sale->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Anular Factura</h5>
                                                        </div>
                                                        <form method="POST" action="{{ url("bills/cancel/sales/$sale->id") }}" autocomplete="off">
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

                                        <a href="{{ url("bills/pdf/sales/$sale->id") }}" class="btn btn-sm btn-info mb-2"  data-toggle="tooltip" title="Generar PDF">
                                            <span><i class="ti ti-file-export"></i></span>
                                        </a>

                                        @if($sale->state == 'Pendiente' && $sale->status == 0 && auth()->user()->id_rol == 1)
                                            <!-- ModalChangeStateOperation -->
                                            <button type="button" class="btn btn-sm btn-dark mb-2" data-toggle="modal" data-target="#modalChange{{ $sale->id }}" data-toggle="tooltip" title="Cobrar">
                                                <span><i class="ti ti-credit-card"></i></span>
                                            </button>

                                            <div class="modal fade" id="modalChange{{ $sale->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Cobrar Factura</h5>
                                                        </div>
                                                        <form method="POST" action="{{ url("bills/change/sales/$sale->id") }}" autocomplete="off">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="PUT">

                                                            <div class="modal-body">
                                                                <h6>¿Esta seguro de cobrar la factura N {{ $sale->number_bill }}?</h6>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cerrar</button>
                                                                <button type="submit" class="btn btn-danger">Si, Cobrar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
				</div>

				<div class="d-flex justify-content-center mt-4">
					{!! $sales->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay facturas generadas
				</div>
			@endif
	    </div>
	</div>
	@include('../layouts/message')
@endsection
