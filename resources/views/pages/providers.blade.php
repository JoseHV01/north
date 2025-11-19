@extends('layouts.app')
@section('title', 'Proveedores')
@section('content')
	<div class="card">
	    <div class="card-body">
			<div class="row">
				<div class="col-6 d-flex align-items-center">
					<a href="{{ url('providers') }}" class="fw-semibold mb-1 h4"style="color: #5D87FF">Clientes / Proveedores</a>
				</div>

				<div class="col-6 d-md-none d-flex justify-content-end">
					<div class="d-flex justify-content-end">
						<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" title="Agregar">
							<span><i class="ti ti-plus"></i></span>
						</button>
					</div>
				</div>
			</div>

            <div class="row pt-4 pt-md-3">
				<div class="col-12 col-md-5 mt-2">
                    <form action="{{ url('providers/search/list') }}" method="get">
                        <div class="input-group">
                            <select name="type" class="form-control" style="max-width:160px;">
                                <option value="">Todos</option>
                                <option value="provider" {{ request('type') == 'provider' ? 'selected' : '' }}>Proveedor</option>
                                <option value="customer" {{ request('type') == 'customer' ? 'selected' : '' }}>Cliente</option>
                            </select>
                            <input type="text" name="provider" class="form-control" placeholder="Buscar por razon social..." value="{{ request('provider') }}">
                            <button type="submit" class="btn btn-primary">
                                <span><i class="ti ti-search"></i></span>
                            </button>
                        </div>
                    </form>
				</div>

                <div class="d-none col-md-7 d-md-flex justify-content-end">
                    <a href="{{ url('export/providers') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" class="btn btn-primary m-1" title="Exportar">
                        <span><i class="ti ti-file-export"></i></span> Exportar
                    </a>
                    <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" title="Agregar">
                        <span><i class="ti ti-plus"></i></span>
                    </button>
                </div>
			</div>

			@if(count($providers) > 0)
                <div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Documento</th>
                                <th>Razon Social</th>
                                <th>Telefono Principal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($providers as $provider)
                                @if($provider->id != 1)
                                    <tr>
                                        <td scope="row">{{ $provider->type == "provider" ? "Proveedor" : "Cliente" }}</td>
                                        <td >{{ $provider->document_type }} {{ $provider->document }}</td>
                                        <td>{{ $provider->business_name }}</td>
                                        <td>{{ $provider->phone ?? "No registrado" }}</td>
                                        <td class="d-flex justify-content-center">

                                            <!-- ModalDet -->
                                            <button type="button" class="btn btn-secondary m-1" data-toggle="modal" data-target="#modalDet{{ $provider->id }}" data-toggle="tooltip" title="Detalles">
                                                <span><i class="ti ti-report"></i></span>
                                            </button>

                                            @include('pages.modals.providers.modalDetailProvider')

                                            <!-- ModalEdit -->
                                            <button type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#modalEdit{{ $provider->id }}" data-toggle="tooltip" title="Editar">
                                                <span><i class="ti ti-edit"></i></span>
                                            </button>

                                           @include('pages.modals.providers.modalEditProvider')

                                            <!-- ModalDelete -->
                                            <!-- <button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#modalDelete{{ $provider->id }}"data-toggle="tooltip" title="Eliminar">
                                                <span><i class="ti ti-trash"></i></span>
                                            </button>

                                            <div class="modal fade" id="modalDelete{{ $provider->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Eliminar Proveedor</h5>
                                                        </div>
                                                        <form method="POST" action="{{ url("providers/$provider->id") }}" autocomplete="off">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">

                                                            <div class="modal-body">
                                                                <h6>¿Esta seguro de eliminar al proveedor {{ $provider->business_name }}?</h6>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-dismiss="modal">No, Cerrar</button>
                                                                <button type="submit" class="btn btn-danger">Si, Eliminar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- ModalChangeStatus -->
                                            <button type="button" class="btn m-1 {{ $provider->status == 1 ? 'btn-danger' : 'btn-success' }}" data-toggle="modal" data-target="#modalChangeStatus{{ $provider->id }}" data-toggle="tooltip" title="{{ $provider->status == 1 ? 'Inhabilitar' : 'Habilitar' }}">
                                                <span><i class="ti {{ $provider->status == 1 ? 'ti-eye-off' : 'ti-eye' }}"></i></span>
                                            </button>

                                            <div class="modal fade" id="modalChangeStatus{{ $provider->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ $provider->status == 1 ? 'Inhabilitar' : 'Habilitar' }}  proveedor o cliente</h5>
                                                        </div>
                                                        <form method="POST" action="{{  url($provider->type == 'provider' ? "change/status/providers/$provider->id" : "change/status/customers/$provider->id")  }}" autocomplete="off">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="PUT">

                                                            <div class="modal-body">
                                                                <h6>¿Esta seguro de {{ $provider->status == 1 ? 'Inhabilitar' : 'Habilitar' }} el {{ $provider->type == 'provider' ? 'proveedor' : 'cliente' }} <span class="font-weight-bold">{{ $provider->business_name }}</span>?</h6>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn m-1 {{ $provider->status == 1 ? 'btn-danger' : 'btn-success' }}">
                                                                    {{ $provider->status == 1 ? 'Inhabilitar' : 'Habilitar' }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
				</div>

				<div class="d-flex justify-content-center mt-4">
					{!! $providers->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay proveedores agregados
				</div>
			@endif
	    </div>
	</div>

    @include('pages.modals.providers.modalAddProvider')

	@include('../layouts/message')
    {{-- <script src="{{ asset('js/validProviders.js') }}"></script>
    <script src="{{ asset('js/validCustomers.js') }}"></script> --}}
@endsection
