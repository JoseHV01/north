@extends('layouts.app')
@section('title', 'Facturas de Ventas')
@section('content')
	<div class="card">
	    <div class="card-body">
	    	<div class="row">
                <div class="col-6 d-flex align-items-center">
                    <a href="{{ url('logs') }}" class="fw-semibold mb-0 h4"style="color: #5D87FF">Bitacora</a>
                </div>
            </div>

            @if(count($logs) > 0)
                <form action="{{ url('logs/search') }}" method="get" class="row mt-4 mb-3">
                    <div class="form-group col-12 col-md-3 mb-3 mb-md-0">
                        <small class="form-label">Usuario</small>
                        <select name="user_id" class="form-control">
                            <option value="">- Seleccione -</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-12 col-md-3 mb-3 mb-md-0">
                        <small class="form-label">Modulo</small>
                        <select name="module" class="form-control">
                            <option value="">- Seleccione -</option>
                            @foreach($modules as $module)
                                <option value="{{ $module }}">{{ $module }}</option>
                            @endforeach
                            <option value="Productos">Productos</option>
                        </select>
                    </div>

                    <div class="form-group col-4 col-md-2 mb-3 mb-md-0">
                        <small class="form-label">Fecha Inicio</small>
                        <input type="date" class="form-control" name="start" max="{{ date("Y-m-d") }}">
                    </div>

                    <div class="form-group col-4 col-md-2 mb-3 mb-md-0">
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

			@if(count($logs) > 0)
				<div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Fecha y Hora</th>
                                <th>Usuario</th>
                                <th>Modulo</th>
                                <th>Accion</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format("d/m/Y") }} - {{ \Carbon\Carbon::parse($log->created_at)->format("H:i:s A") }}</td>
                                    <td>{{ $log->user_name }}</td>
                                    <td>{{ $log->module }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>
                                        <!-- ModalCancel -->
                                        {{-- @if($sale->status == 0 && auth()->user()->id_rol == 1)
                                            <button type="button" class="btn btn-sm btn-danger mb-2" data-toggle="modal" data-target="#modalCancel{{ $sale->id }}" data-toggle="tooltip" title="Anular">
                                                <span><i class="ti ti-clipboard-off"></i></span>
                                            </button>

                                            <div class="modal fade" id="modalCancel{{ $sale->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Anular Factura</h5>
                                                        </div>
                                                        <form method="POST" action="{{ url("bills/cancel/logs/$sale->id") }}" autocomplete="off">
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
                                        @endif --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
				</div>

				<div class="d-flex justify-content-center mt-4">
					{!! $logs->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay registros generados
				</div>
			@endif
	    </div>
	</div>
	@include('../layouts/message')
@endsection
