@extends('layouts.app')
@section('title', 'Empresa')
@section('content')
	<div class="card">
	    <div class="card-body">
	    	<a href="{{ url('company') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Empresa</a>

            <form id="form" method="POST" action="{{ url('/company') }}" autocomplete="off" class="my-4 my-md-5">
				{{ csrf_field() }}

				<div class="row mb-4">
					<div class="col-12 col-md-6 mb-4 mb-md-0">
						<label for="inputName" class="form-label">Razon Social</label>
						<input name="name" type="text" class="form-control" id="inputCompanyName" required value="{{ old('name') ?? $data_company->name }}">
						<p class="text-danger small d-none" id="errorName">complete el nombre con solo letras</p>
					</div>

					<div class="col-12 col-md-6">
						<label for="inputRif" class="form-label">RIF</label>
						<input name="rif" type="text" class="form-control" id="inputRif" required value="{{ old('rif') ?? $data_company->rif }}" minlength="10" maxlength="12">
						<p class="text-danger small d-none" id="errorRif">complete el RIF con un formato valido y una longitud de 10 a 11 caracteres</p><!--V-27890234-0 -->
					</div>
				</div>

				<div class="row mb-4">
					<div class="col-12 col-md-6 mb-4 mb-md-0">
						<label for="inputEmail" class="form-label">Correo</label>
						<input name="email" type="email" class="form-control" id="inputEmail" required value="{{ old('email') ?? $data_company->email }}">
						<p class="text-danger small d-none" id="errorEmail">complete el correo con un formato valido</p>
					</div>

					<div class="col-12 col-md-6">
						<label for="inputPhone" class="form-label">Telefono</label>
						<input name="phone" type="number" class="form-control" id="inputPhone" required value="{{ old('phone') ?? $data_company->phone }}">
						<p class="text-danger small d-none" id="errorPhone">complete el telefono con solo numeros</p>
					</div>
				</div>

				<div class="col-12 mb-4">
					<label for="inputDirection" class="form-label">Domicilio Fiscal</label>
					<textarea name="direction" class="form-control" id="inputDirection" required rows="5">{{ old('direction') ?? $data_company->direction }}</textarea>
					<p class="text-danger small d-none" id="errorDirection">complete la direccion con minimo 10 caracteres</p>
				</div>

				<div class="d-flex justify-content-center">
					<button type="submit" class="btn btn-warning">Editar</button>
				</div>
			</form>
	    </div>
	</div>

	@include('../layouts/message')
	<script src="{{ asset ('js/validCompany.js') }}"></script>
@endsection
