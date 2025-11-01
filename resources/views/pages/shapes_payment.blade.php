@extends('layouts.app')
@section('title', 'Formas de Pago')
@section('content')
	<div class="card">
	    <div class="card-body">
			<div class="row">
				<div class="col-6">
					<a href="{{ url('shapes_payment') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF; line-height: 25px;">Formas de Pago</a>
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
										<h5 class="modal-title">Agregar Forma de Pago</h5>
									</div>
									<form method="POST" action="{{ url('shapes_payment') }}" autocomplete="off">
										{{ csrf_field() }}

										<div class="modal-body">
											<div class="form-group mb-3">
												<label for="inputName" class="form-label">Nombre</label>
												<input name="name" type="text" class="form-control" id="inputName" required minlenght="1" maxlenght="50">
												<p class="text-danger small d-none" id="messageName">El nombre de la forma de pago debe contener solo letras y numeros, debe de tener entre 1 y 50 letras de longitud</p>
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


			@if(count($shapes_payment) > 0)
				<table class="table mt-3">
					<thead>
						<tr>
							<th>Forma</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($shapes_payment as $shape_payment)
							<tr>
								<td scope="row">{{ $shape_payment->name }}</td>
								<td class="d-flex justify-content-center">

									<!-- ModalEdit -->
									<button type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#modalEdit{{ $shape_payment->id }}" data-toggle="tooltip" title="Editar">
										<span><i class="ti ti-edit"></i></span>
									</button>

									<div class="modal fade" id="modalEdit{{ $shape_payment->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Editar Forma de Pago</h5>
												</div>
												<form method="POST" action="{{ url("shapes_payment/$shape_payment->id") }}" autocomplete="off">
													{{ csrf_field() }}
                          							<input type="hidden" name="_method" value="PUT">

													<div class="modal-body" id="bodyModalEdit">
														<div class="form-group mb-3">
															<label for="inputName" class="form-label">Nombre</label>
															<input name="name" type="text" class="form-control" id="inputEditName" required minlenght="1" maxlenght="50" value="{{ $shape_payment->name }}">
															<p class="text-danger small d-none" id="messageEditName">El nombre de la forma de pago debe contener solo letras y numeros, debe de tener entre 1 y 50 letras de longitud</p>
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
									<button type="button" class="btn m-1 {{ $shape_payment->status == 1 ? 'btn-danger' : 'btn-success' }}" data-toggle="modal" data-target="#modalChangeStatus{{ $shape_payment->id }}" data-toggle="tooltip" title="{{ $shape_payment->status == 1 ? 'Inhabilitar' : 'Habilitar' }}">
										<span><i class="ti {{ $shape_payment->status == 1 ? 'ti-eye-off' : 'ti-eye' }}"></i></span>
									</button>

									<div class="modal fade" id="modalChangeStatus{{ $shape_payment->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">{{ $shape_payment->status == 1 ? 'Inhabilitar' : 'Habilitar' }} Forma de Pago</h5>
												</div>
												<form method="POST" action="{{  url("change/status/shapes_payment/$shape_payment->id")  }}" autocomplete="off">
													{{ csrf_field() }}
                          							<input type="hidden" name="_method" value="PUT">

													<div class="modal-body">
														<h6>¿Esta seguro de {{ $shape_payment->status == 1 ? 'Inhabilitar' : 'Habilitar' }} forma de pago <span class="font-weight-bold">{{ $shape_payment->name }}</span>?</h6>
													</div>

													<div class="modal-footer">
														<button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
														<button type="submit" class="btn m-1 {{ $shape_payment->status == 1 ? 'btn-danger' : 'btn-success' }}">
															{{ $shape_payment->status == 1 ? 'Inhabilitar' : 'Habilitar' }}
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<!-- ModalDelete -->
									<!-- <button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#modalDelete{{ $shape_payment->id }}"data-toggle="tooltip" title="Eliminar">
										<span><i class="ti ti-trash"></i></span>
									</button>

									<div class="modal fade" id="modalDelete{{ $shape_payment->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Eliminar Forma de Pago</h5>
												</div>
												<form method="POST" action="{{ url("shapes_payment/$shape_payment->id") }}" autocomplete="off">
													{{ csrf_field() }}
													<input type="hidden" name="_method" value="DELETE">

													<div class="modal-body">
														<h6>¿Esta seguro de eliminar la forma de pago {{ $shape_payment->name }}?</h6>
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
					{!! $shapes_payment->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay formas de pago agregadas
				</div>
			@endif
	    </div>
	</div>
	@include('../layouts/message')
	<script src="{{ asset('js/validShapesPayMent.js') }}"></script>
@endsection
