@extends('layouts.app')
@section('title', 'Perfil')
@section('content')
	<div class="card">
	    <div class="card-body">
	    	<a href="{{ url('profile') }}" class="fw-semibold mb-5 mb-md-4 h4"style="color: #5D87FF">Perfil</a>

			<div class="card-body mb-2" style="padding: 25px 0px">
				<h5 class="card-title fw-semibold mb-4">Editar Correo</h5>
				<form method="POST" class="row" action="{{ url('/change/email') }}" autocomplete="off">
					{{ csrf_field() }}
					<div class="mb-3 col-12 col-md-6">
						<label for="inputEmail" class="form-label">Nuevo Correo</label>
						<input name="email" type="email" class="form-control" id="inputEmail" required minlenght="10">
						<p class="text-danger small d-none" id="errorEmail">Complete el correo con un formato valido</p>
					</div>

					<div class="mb-3 col-12 col-md-6">
						<label for="inputPassword" class="form-label">Contraseña Actual</label>
						<div class="input-group">
							<input id="password" name="password" type="password" class="form-control" id="inputPassword" required minlenght="8">
							<button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden('password')">
								<span id="iconShow"><i class="ti ti-eye"></i></span>
								<span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
							</button>
						</div>
					</div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary w-25 btn-responsive">Editar Correo</button>
                    </div>
				</form>
			</div>

			<div class="card-body mb-2" style="padding: 25px 0px">
				<h5 class="card-title fw-semibold mb-4">Editar Contraseña</h5>
				<form method="POST" class="row" action="{{ url('/change/password') }}" autocomplete="off">
					{{ csrf_field() }}

					<div class="mb-3 col-12 col-md-4">
						<label for="inputPasswordCurrent" class="form-label">Contraseña Actual</label>
						<div class="input-group">
							<input id="password_old" name="password" type="password" class="form-control" id="inputPasswordCurrent" required minlenght="8">
							<button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden('password_old')">
								<span id="iconShow"><i class="ti ti-eye"></i></span>
								<span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
							</button>
						</div>
					</div>

					<div class="mb-3 col-12 col-md-4">
						<label for="inputNewPassword" class="form-label">Nueva Contraseña</label>
						<div class="input-group">
							<input id="password_new"  name="new_password" type="password" class="form-control" id="inputNewPassword" required minlenght="8">
							<button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden('password_new')">
								<span id="iconShow"><i class="ti ti-eye"></i></span>
								<span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
							</button>
						</div>
						<p class="text-danger small d-none" id="errorPassword">Complete la contraseña con un formato que contega al menos una minuscula y una mayuscula, al menos un número, y debe tener minimo 8 caracteres de longitud sin espacios en blanco</p>
					</div>

					<div class="mb-3 col-12 col-md-4">
						<label for="inputRepeatNewPassword" class="form-label">Repetir Nueva Contraseña</label>
						<div class="input-group">
							<input id="password_new_two" name="repeat_new_password" type="password" class="form-control" id="inputRepeatNewPassword" required minlenght="8">
							<button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden('password_new_two')">
								<span id="iconShow"><i class="ti ti-eye"></i></span>
								<span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
							</button>
						</div>
						<p id="errorTwoPassword" class="text-danger small d-none">La contraseña no coincide</p>
					</div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary w-25 btn-responsive">Editar Contraseña</button>
                    </div>
				</form>
			</div>

			<div class="card-body mb-2" style="padding: 25px 0px">
				<h5 class="card-title fw-semibold mb-4">Editar Preguntas de Seguridad</h5>
				<form method="POST" action="{{ url('/change/asks/security') }}" autocomplete="off">
					{{ csrf_field() }}

					@foreach ($asks_security as $key => $item)
						<div class="row mb-3">
							<div class="col-12 col-lg-6 mb-4 mb-md-0">
								<div class="form-group">
									<label for="inputAsk_{{ $item->id }}" class="form-label">Pregunta de seguidad N°{{ $key+1 }}</label>
									<input name="asks[]" type="text" class="form-control" id="inputAsk_{{ $item->id }}" required minlenght="5" value="{{ $item->ask }}">
								</div>
							</div>

							<div class="col-12 col-lg-6 mb-3 mb-md-0">
								<div class="form-group">
									<label for="inputAnswer_{{ $item->id }}" class="form-label">Respuesta pregunta N°{{ $key+1 }}</label>
									<div class="input-group">
										<input id="{{ $item->id }}" name="answers[]" type="password" class="form-control" id="inputAnswer_.{{ $item->id }}" required value="{{ decrypt( $item->answer ) }}">
										<button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden({{ $item->id }})">
											<span id="iconShow"><i class="ti ti-eye"></i></span>
											<span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
										</button>
									</div>
								</div>
							</div>
						</div>
					@endforeach

					<div class="form-group mb-3">
						<label for="inputPasword" class="form-label">Contraseña</label>
						<div class="input-group">
							<input id="password_confirm" name="password" type="password" class="form-control" id="inputPasword" required minlenght="8">
							<button id="btn_search" type="button" class="btn btn-outline-primary" onClick="showHiden('password_confirm')">
								<span id="iconShow"><i class="ti ti-eye"></i></span>
								<span id="iconHidden" class="d-none"><i class="ti ti-eye-off"></i></span>
							</button>
						</div>
					</div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary w-25 btn-responsive">Editar Preguntas</button>
                    </div>
				</form>
			</div>
	    </div>
	</div>

	<script src="{{ asset('js/configurationInputsPassword.js') }}"></script>
	<script src="{{ asset('js/validProfile.js') }}"></script>
	@include('../layouts/message')
@endsection
