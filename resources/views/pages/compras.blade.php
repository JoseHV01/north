@extends('layouts.app')
@section('title', 'Usuarios')
@section('content')
	<div class="card">
	    <div class="card-body">
	    	<h5 class="card-title fw-semibold mb-4">Usuarios</h5>
	    	{{-- <p class="mb-0">Pagina de los usuarios</p> --}}
	          <!-- <button type="button" class="btn btn-secondary m-1">Secondary</button>
	          <button type="button" class="btn btn-success m-1">Success</button>
	          <button type="button" class="btn btn-danger m-1">Danger</button>
	          <button type="button" class="btn btn-warning m-1">Warning</button>
	          <button type="button" class="btn btn-info m-1">Info</button> -->

        	<div class="d-flex justify-content-end">
          		<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg">Agregar 
          			<span><i class="ti ti-plus"></i></span>
          		</button>
         	</div>

			@if(count($users) > 0)
				<table class="table mt-3">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Correo</th>
							<th>Rol</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td scope="row">{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->rol }}</td>
								@if($user->rol == "User")
									<td>
										<button type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#modalEdit">
						          			<span><i class="ti ti-pincel"></i></span>
										</button>
									</td>
								@endif
							</tr>

							<!-- ModalEdit -->
							<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Editar Usuario</h5>
										</div>
										<form method="PUT" action="{{  url("users/$user->id")  }}" autocomplete="off">
											{{ csrf_field() }}
											<div class="modal-body">
												<div class="mb-3">
													<label for="inputName" class="form-label">Nombre</label>
													<input name="name" type="text" class="form-control" id="inputName" required maxlenght="50">
												</div>

												<div class="mb-3">
													<label for="inputEmail" class="form-label">Correo</label>
													<input name="email" type="email" class="form-control" id="inputEmail" required minlenght="10">
												</div>

												<div class="mb-4">
													<label for="inputPassword" class="form-label">Contraseña</label>
													<input name="password" type="password" class="form-control" id="inputPassword" required minlenght="8">
												</div>

												<div class="mb-4">
													<label for="inputPasswordRepeat" class="form-label">Repetir Contraseña</label>
													<input name="password_repeat" type="password" class="form-control" id="inputPasswordRepeat" required minlenght="8">
												</div>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
												<button type="submit" class="btn btn-primary">Agregar</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						@endforeach
					</tbody>
				</table>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay usuarios agregados
				</div>
			@endif
	    </div>
	</div>

	{{-- Modals --}}
	<!-- ModalAgg -->
	<div class="modal fade" id="modalAgg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Agregar Usuario</h5>
						{{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="ti ti-times"></i></span>
						</button> --}}
				</div>
				<form method="POST" action="{{  url('users')  }}" autocomplete="off">
					{{ csrf_field() }}
					<div class="modal-body">
						<div class="row">
							<div class="col-12 col-lg-6">
								<div class="mb-4">
									<label for="inputName" class="form-label">Nombre</label>
									<input name="name" type="text" class="form-control" id="inputName" required maxlenght="50">
								</div>
							</div>

							<div class="col-12 col-lg-6">
									<div class="mb-4">
										<label for="inputEmail" class="form-label">Correo</label>
										<input name="email" type="email" class="form-control" id="inputEmail" required minlenght="10">
									</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-lg-6">
									<div class="mb-4">
										<label for="inputPassword" class="form-label">Contraseña</label>
										<input name="password" type="password" class="form-control" id="inputPassword" required minlenght="8">
									</div>
							</div>

							<div class="col-12 col-lg-6">
									<div class="mb-4">
										<label for="inputPasswordRepeat" class="form-label">Repetir Contraseña</label>
										<input name="password_repeat" type="password" class="form-control" id="inputPasswordRepeat" required minlenght="8">
									</div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 col-lg-6">
									<div class="mb-4">
										<label for="inputAsk" class="form-label">Pregunta de seguidad</label>
										<input name="ask" type="text" class="form-control" id="inputAsk" required>
									</div>
							</div>

							<div class="col-12 col-lg-6">
									<div class="mb-4">
										<label for="inputAnswer" class="form-label">Respuesta pregunta</label>
										<input name="answer" type="text" class="form-control" id="inputAnswer" required>
									</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Agregar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@include('../layouts/message')
@endsection