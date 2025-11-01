@extends('layouts.app')
@section('title', 'Estados Operacion')
@section('content')
	<div class="card">
	    <div class="card-body">
			<div class="row">
				<div class="col-6">
					<a href="{{ url('states_operation') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF; line-height: 25px;">Estados de Operacion</a>
				</div>

				<div class="col-6">
					<div class="d-flex justify-content-end">
						<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" title="Agregar"> 
							<span><i class="ti ti-plus"></i></span>
						</button>
		
						<!-- ModalAgg -->
						<div class="modal fade" id="modalAgg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Agregar Estado de Operacion</h5>
											{{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true"><i class="ti ti-times"></i></span>
											</button> --}}
									</div>
									<form method="POST" action="{{ url('states_operation') }}" autocomplete="off">
										{{ csrf_field() }}
										
										<div class="modal-body">
											<div class="form-group mb-3">
												<label for="inputName" class="form-label">Nombre</label>
												<input name="name" type="text" class="form-control" id="inputName" required minlength="1" maxlenght="50">
											</div>
										</div>
		
										<div class="modal-footer">
											<button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
											<button type="submit" class="btn btn-primary">Agregar</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			@if(count($states_operation) > 0)
				<table class="table mt-3">
					<thead>
						<tr>
							<th>Estado</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($states_operation as $state)
							<tr>
								<td scope="row">{{ $state->name }}</td>
								<td class="d-flex justify-content-center">
									<!-- ModalEdit -->
									<button type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#modalEdit{{ $state->id }}" data-toggle="tooltip" title="Editar">
										<span><i class="ti ti-edit"></i></span>
									</button>

									<div class="modal fade" id="modalEdit{{ $state->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Editar Estado de Operacion</h5>
												</div>
												<form method="POST" action="{{  url("states_operation/$state->id")  }}" autocomplete="off">
													{{ csrf_field() }}
                          							<input type="hidden" name="_method" value="PUT">

													<div class="modal-body">
														<div class="form-group mb-3">
															<label for="inputName" class="form-label">Nombre</label>
															<input name="name" type="text" class="form-control" id="inputName" required minlength="1" maxlenght="50" value="{{ $state ->name }}">
														</div>
													</div>

													<div class="modal-footer">
														<button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
														<button type="submit" class="btn btn-warning">Editar</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<!-- ModalChangeStatus -->
									<button type="button" class="btn m-1 {{ $state->status == 1 ? 'btn-danger' : 'btn-success' }}" data-toggle="modal" data-target="#modalChangeStatus{{ $state->id }}" data-toggle="tooltip" title="{{ $state->status == 1 ? 'Inhabilitar' : 'Habilitar' }}">
										<span><i class="ti {{ $state->status == 1 ? 'ti-eye-off' : 'ti-eye' }}"></i></span>
									</button>

									<div class="modal fade" id="modalChangeStatus{{ $state->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">{{ $state->status == 1 ? 'Inhabilitar' : 'Habilitar' }}  Estado de Operacion</h5>
												</div>
												<form method="POST" action="{{  url("change/status/states_operation/$state->id")  }}" autocomplete="off">
													{{ csrf_field() }}
                          							<input type="hidden" name="_method" value="PUT">

													<div class="modal-body">
														<h6>¿Esta seguro de {{ $state->status == 1 ? 'Inhabilitar' : 'Habilitar' }} el estado de operacion <span class="font-weight-bold">{{ $state->name }}</span>?</h6>
													</div>

													<div class="modal-footer">
														<button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
														<button type="submit" class="btn m-1 {{ $state->status == 1 ? 'btn-danger' : 'btn-success' }}">
															{{ $state->status == 1 ? 'Inhabilitar' : 'Habilitar' }}
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<!-- ModalDelete
									<button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#modalDelete{{ $state->id }}"data-toggle="tooltip" title="Eliminar">
										<span><i class="ti ti-trash"></i></span>
									</button>

									<div class="modal fade" id="modalDelete{{ $state->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Eliminar Estado de Operacion</h5>
												</div>
												<form method="POST" action="{{ url("states_operation/$state->id") }}" autocomplete="off">
													{{ csrf_field() }}
													<input type="hidden" name="_method" value="DELETE">

													<div class="modal-body">
														<h6>¿Esta seguro de eliminar el estado de operacion {{ $state->name }}?</h6>
													</div>

													<div class="modal-footer">
														<button type="button" class="btn btn-dark" data-dismiss="modal">No, Cerrar</button>
														<button type="submit" class="btn btn-danger">Si, Eliminar</button>
													</div>
												</form>
											</div>
										</div>
									</div> -->
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div class="d-flex justify-content-center mt-4">
					{!! $states_operation->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay estados de operacion agregados
				</div>
			@endif
	    </div>
	</div>
	@include('../layouts/message')
@endsection