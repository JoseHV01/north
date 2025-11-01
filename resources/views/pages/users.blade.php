@extends('layouts.app')
@section('title', 'Usuarios')
@section('content')
	<div class="card">
	    <div class="card-body">
			<div class="row">
				<div class="col-6">
					<a href="{{ url('users') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Usuarios</a>
				</div>

				<div class="col-6">
					<div class="d-flex justify-content-end">
						<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" data-placement="top" title="Agregar">
							<span><i class="ti ti-plus"></i></span>
						</button>

						  <!-- ModalAgg -->
						<div class="modal fade" id="modalAgg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Agregar Usuario</h5>
									</div>

									<form method="POST" action="{{  url('users')  }}" autocomplete="off"  class="validation-wizard tab-wizard wizard-circle">
									    {{ csrf_field() }}

										<div class="modal-body container-scroll">
                                            <div class="scroll">
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputName" class="form-label">Nombre</label>
                                                        <input name="name" type="text" class="form-control" id="inputName" required maxlenght="50" value="{{ old('name') }}">
                                                        <p class="text-danger small d-none" id="messageName">El Nombre debe contener solo letras, minimo 5 caracteres y maximo 50 caracteres de longitud</p>
                                                    </div>

                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputEmail" class="form-label">Correo</label>
                                                        <input name="email" type="email" class="form-control" id="inputEmail" required value="{{ old('email') }}">
                                                        <p class="text-danger small d-none" id="messageEmail">El correo debe de tener un formato valido con minimo 10 caracteres de longitud</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputPassword" class="form-label">Contraseña</label>
                                                        <input name="password" type="password" class="form-control" id="inputPassword" required minlength="8" value="{{ old('password') }}">
                                                        <p class="text-danger small d-none" id="messagePassword">La contraseña debe tener minimo 8 caracteres de longitud sin espacios en blancos</p>
                                                    </div>

                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputPasswordRepeat" class="form-label">Repetir Contraseña</label>
                                                        <input name="password_repeat" type="password" class="form-control" id="inputPasswordRepeat" required minlength="8" value="{{ old('password_repeat') }}">
                                                        <p class="text-danger small d-none" id="messagePasswordRepeat">Ambas contraseñas deben coincidir</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputAsk_1" class="form-label">Pregunta de seguidad N°1</label>
                                                        <input name="asks[]" type="text" class="form-control" id="inputAsk_1" required>
                                                        <p class="text-danger small d-none" id="messageAsk_n1">Las preguntas de seguridad deben contener mas de 5 caracteres</p>
                                                    </div>

                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputAnswer_1" class="form-label">Respuesta pregunta N°1</label>
                                                        <input name="answers[]" type="text" class="form-control" id="inputAnswer_1" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputAsk_2" class="form-label">Pregunta de seguidad N°2</label>
                                                        <input name="asks[]" type="text" class="form-control" id="inputAsk_2" required>
                                                        <p class="text-danger small d-none" id="messageAsk_n2">Las preguntas de seguridad deben contener mas de 5 caracteres</p>
                                                    </div>

                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputAnswer_2" class="form-label">Respuesta pregunta N°2</label>
                                                        <input name="answers[]" type="text" class="form-control" id="inputAnswer_2" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputAsk_3" class="form-label">Pregunta de seguidad N°3</label>
                                                        <input name="asks[]" type="text" class="form-control" id="inputAsk_3" required>
                                                        <p class="text-danger small d-none" id="messageAsk_n3">Las preguntas de seguridad deben contener mas de 5 caracteres</p>
                                                    </div>

                                                    <div class="col-12 col-lg-6 form-group mb-4">
                                                        <label for="inputAnswer_3" class="form-label">Respuesta pregunta N°3</label>
                                                        <input name="answers[]" type="text" class="form-control" id="inputAnswer_3" required>
                                                    </div>
                                                </div>
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


			@if(count($users) > 0)
				<div class="table-responsive">
					<table class="table mt-3">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Correo</th>
								<th>Estado</th>
								<th>Rol</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
								<tr>
									<td scope="row">{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>
										<span class="badge rounded-pill px-2 {{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">{{ $user->status == 1 ? 'Habilitado' : 'Inhabilitado' }}</span>
									</td>
									<td>{{ $user->role }}</td>

									<td class="d-flex justify-content-center">
										<button type="button" class="btn {{ $user->status == 0 ? 'btn-success' : 'btn-danger' }} m-1" data-toggle="modal" data-target="#modalStatus{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="{{ $user->status == 0 ? 'Habilitar' : 'Inhabilitar' }}">
                							<span><i class="ti {{ $user->status == 0 ? 'ti-user-check' : 'ti-user-x' }}"></i></span>
                                        </button>

										<!-- ModalStatus -->
										<div class="modal fade" id="modalStatus{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">{{ $user->status == 0 ? 'Habilitar' : 'Inhabilitar' }} Usuario</h5>
													</div>
													<form method="POST" action="{{  url("user/status/$user->id")  }}" autocomplete="off">
														{{ csrf_field() }}
														<div class="modal-body">
															¿Esta seguro de {{ $user->status == 0 ? 'habilitar' : 'inhabilitar' }} este Usuario?
														</div>

														<div class="modal-footer">
															<button type="button" class="btn btn-dark" data-dismiss="modal">No, cerrar</button>
															<button type="submit" class="btn btn-primary">Si, {{ $user->status == 0 ? 'habilitar' : 'inhabilitar' }}</button>
														</div>
													</form>
												</div>
											</div>
										</div>

                                        @if ($user->id_rol != 1 && $user->status == 1)
                                            <button type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#modalAssignPermissions{{ $user->id }}" data-toggle="tooltip" data-placement="top" title="Gestionar Permisos">
                                                <span><i class="ti ti-edit"></i></span>
                                            </button>

                                            <!-- ModalAssignPermissions -->
                                            <div class="modal fade" id="modalAssignPermissions{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Gestionar Permisos del Usuario</h5>
                                                        </div>
                                                        <form method="POST" action="{{  url("user/permissions/$user->id")  }}" autocomplete="off">
                                                            {{ csrf_field() }}

                                                            <div class="modal-body">
                                                                <div class="row ps-2">
                                                                    <div class="col-6">
                                                                        <p class="text-center fw-semibold">Permisos asignados</p>
                                                                        <hr class="mt-0" style="border-top: 1px solid gray !important;">

                                                                        <ul>
                                                                            @if (count($user->permissions))
                                                                                @foreach ($user->permissions as $permissions)
                                                                                    <li class="mb-2">{{ $permissions->permission }}</li>
                                                                                @endforeach
                                                                            @else
                                                                                <li class="text-center fw-semibold">Usuario sin permisos asignados</li>
                                                                            @endif
                                                                        </ul>
                                                                    </div>

                                                                    <div class="col-6">
                                                                        <p class="text-center fw-semibold">Permisos disponibles</p>
                                                                        <hr class="mt-0" style="border-top: 1px solid gray !important;">

                                                                        @foreach($modules as $key => $value)
                                                                            <div class="form-check mb-2">
                                                                                <input class="form-check-input" type="checkbox" value="{{ $value }}" id="flexCheckChecked{{ $key }}" name="permissions[]">
                                                                                <label class="form-check-label" for="flexCheckChecked{{ $key }}">
                                                                                    {{ $value }}
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Confirmar</button>
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
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay usuarios agregados
				</div>
			@endif
	    </div>
	</div>

	@include('../layouts/message')
    <script src="{{ asset('js/validUser.js') }}"></script>
@endsection
