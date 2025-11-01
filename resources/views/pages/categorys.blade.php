@extends('layouts.app')
@section('title', 'Categorias')
@section('content')
	<div class="card">
	    <div class="card-body">
			<div class="row">
				<div class="col-6">
					<a href="{{ url('categorys') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Categorias</a>
				</div>

				<div class="col-6">
					<div class="d-flex justify-content-end">
						<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" title="Agregar" id="">
							<span><i class="ti ti-plus"></i></span>
						</button>

						<!-- ModalAgg -->
						<div class="modal fade" id="modalAgg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Agregar Categoria</h5>
									</div>
									<form method="POST" action="{{  url('categorys')  }}" autocomplete="off">
										{{ csrf_field() }}

										<div class="modal-body" id="bodyModalAgg">
											<div class="form-group mb-4">
												<label for="inputName" class="form-label">Nombre</label>
												<input name="name" type="text" class="form-control" id="inputName" required minlength="5" maxlenght="50">
												<p class="text-danger small d-none" id="messageAggName">El nombre de la categoria debe contener solo letras, entre 5 y 50 caracteres de longitud</p>
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


			@if(count($categorys) > 0)
				<table class="table mt-3">
					<thead>
						<tr>
							<th>Categoria</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($categorys as $category)
							<tr>
								<td scope="row">{{ $category->name }}</td>
								<td class="d-flex justify-content-center">

									<!-- ModalEdit -->
									<button type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#modalEdit{{ $category->id }}" data-toggle="tooltip" title="Editar">
										<span><i class="ti ti-edit"></i></span>
									</button>

									<div class="modal fade" id="modalEdit{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Editar Categoria</h5>
												</div>
												<form method="POST" action="{{  url("categorys/$category->id")  }}" autocomplete="off">
													{{ csrf_field() }}
                          							<input type="hidden" name="_method" value="PUT">

													<div class="modal-body" id="bodyModalEdit">
														<div class="form-group mb-3">
															<label for="inputNameEdit" class="form-label">Nombre</label>
															<input name="name" type="text" class="form-control" id="inputNameEdit" required minlength="5" maxlenght="50" value="{{ $category ->name }}">
															<p class="text-danger small d-none" id="messageEditName">El nombre de la categoria debe contener solo letras, entre 5 y 50 caracteres de longitud</p>
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
									<button type="button" class="btn m-1 {{ $category->status == 1 ? 'btn-danger' : 'btn-success' }}" data-toggle="modal" data-target="#modalChangeStatus{{ $category->id }}" data-toggle="tooltip" title="{{ $category->status == 1 ? 'Inhabilitar' : 'Habilitar' }}">
										<span><i class="ti {{ $category->status == 1 ? 'ti-eye-off' : 'ti-eye' }}"></i></span>
									</button>

									<div class="modal fade" id="modalChangeStatus{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">{{ $category->status == 1 ? 'Inhabilitar' : 'Habilitar' }} Categoria</h5>
												</div>
												<form method="POST" action="{{  url("change/status/categorys/$category->id")  }}" autocomplete="off">
													{{ csrf_field() }}
                          							<input type="hidden" name="_method" value="PUT">

													<div class="modal-body">
														<h6>¿Esta seguro de {{ $category->status == 1 ? 'Inhabilitar' : 'Habilitar' }} categoria <span class="font-weight-bold">{{ $category->name }}</span>?</h6>
													</div>

													<div class="modal-footer">
														<button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
														<button type="submit" class="btn m-1 {{ $category->status == 1 ? 'btn-danger' : 'btn-success' }}">
															{{ $category->status == 1 ? 'Inhabilitar' : 'Habilitar' }}
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<!-- ModalDelete -->
									<!-- <button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#modalDelete{{ $category->id }}" data-toggle="tooltip" title="Eliminar">
										<span><i class="ti ti-trash"></i></span>
									</button>

									<div class="modal fade" id="modalDelete{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Eliminar Categoria</h5>
												</div>
												<form method="POST" action="{{  url("categorys/$category->id")  }}" autocomplete="off">
													{{ csrf_field() }}
													<input type="hidden" name="_method" value="DELETE">

													<div class="modal-body">
														<h6>¿Esta seguro de eliminar la categoria {{ $category->name }}?</h6>
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
					{!! $categorys->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay categorias agregadas
				</div>
			@endif
	    </div>
	</div>

	@include('../layouts/message')
	<script src="{{ asset('js/validCategorys.js') }}"></script>
@endsection
