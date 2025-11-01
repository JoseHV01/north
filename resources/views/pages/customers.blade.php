@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
	<div class="card">
	    <div class="card-body">
			<div class="row">
				<div class="col-6 align-items-center">
					<a href="{{ url('customers') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Clientes</a>
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
					<form action="{{ url('customers/search/list') }}" method="get">
						<div class="input-group">
							<input type="text" name="customer" class="form-control" minlenght="3" placeholder="Buscar por razon social...">
							<button type="submit" class="btn btn-primary">
								<span><i class="ti ti-search"></i></span>
							</button>
						</div>
					</form>
				</div>

				<div class="d-none col-md-7 d-md-flex justify-content-end">
					<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" title="Agregar">
						<span><i class="ti ti-plus"></i></span>
					</button>
				</div>
			</div>

			@if(count($customers) > 0)
				<div class="table-responsive">
					<table class="table mt-3">
						<thead>
							<tr>
								<th>Documento</th>
								<th>Razon Social</th>
								<th>Telefono Principal</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($customers as $customer)
								@if($customer->id != 1)
									<tr>
										<td scope="row">{{ $customer->document_type }} {{ $customer->document }}</td>
										<td>{{ $customer->business_name }}</td>
										<td>{{ $customer->phone ? $customer->phone : 'No registrado'}}</td>
										<td class="d-flex justify-content-center">

											<!-- ModalDet -->
											<button type="button" class="btn btn-secondary m-1" data-toggle="modal" data-target="#modalDet{{ $customer->id }}" data-toggle="tooltip" title="Detalles">
												<span><i class="ti ti-report"></i></span>
											</button>

											<div class="modal fade" id="modalDet{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Detalles Cliente</h5>
														</div>
														<div class="modal-body">
															<div class="row mb-3">
																<div class="form-group">
																	<label for="inputTypeDocument" class="form-label">Tipo de Documento</label>
																	<span>{{ $customer->document_type }} {{ $customer->document }}</span>
																</div>
															</div>

															<div class="form-group mb-3">
																<label for="inputBusinessName" class="form-label">Razon Social</label>
																<span>{{ $customer->business_name }}</span>
															</div>

															<div class="form-group mb-3">
																<label for="inputEmail" class="form-label">Correo</label>
																<span>{{ $customer->email ?? "No registrado" }}</span>
															</div>

															<div class="form-group mb-3">
																<label for="inputPhone" class="form-label">Telefono Principal</label>
																<span>{{ $customer->phone ?? "No registrado" }}</span>
															</div>

															<div class="form-group mb-3">
																<label for="inputPhoneSecondary" class="form-label">Telefono Segundario</label>
																<span>{{ $customer->phone_secondary ?? "No registrado" }}</span>
															</div>
														</div>

														<div class="modal-footer">
															<button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
														</div>
													</div>
												</div>
											</div>

											<!-- ModalEdit -->
											<button type="button" class="btn btn-warning m-1" data-toggle="modal" data-target="#modalEdit{{ $customer->id }}" data-toggle="tooltip" title="Editar">
												<span><i class="ti ti-edit"></i></span>
											</button>

											<div class="modal fade" id="modalEdit{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Editar Cliente</h5>
														</div>
														<form method="POST" action="{{ url("customers/$customer->id")  }}" autocomplete="off">
															{{ csrf_field() }}
															<input type="hidden" name="_method" value="PUT">

															<div class="modal-body" id="bodyModalEdit">
																<div class="row mb-3">
																	<div class="form-group col-12 col-md-4 mb-3 mb-md-2">
																		<label for="inputTypeDocument" class="form-label">Tipo de Documento</label>
																		<select name="type_document" class="form-control" required value="{{ old('type_document') }}">
																			@foreach($document_types as $type)
																				<option value="{{ $type->id }}" {{ $customer->id_document_type == $type->id ? 'selected' : '' }} >{{ $type->name }}</option>
																			@endforeach
																		</select>
																	</div>
																	<div class="form-group col-12 col-md-8 mb-3 mb-md-2">
																		<label for="editDocument" class="form-label">Documento</label>
																		<input name="document" type="number" class="form-control" id="inputEditDocument" required minlenght="7" maxlenght="10" value="{{ $customer->document ? $customer->document : old('document') }}">
																		<p class="text-danger small d-none" id="documentEditMessage">El documento debe de contar con una logitud de 7 a 10 caracteres de solo numeros</p>

																	</div>
																</div>

																<div class="row mb-3">
																	<div class="form-group col-12 col-md-6 mb-3 mb-md-2">
																		<label for="BusinessName" class="form-label">Razon Social</label>
																		<input name="business_name" type="text" class="form-control" id="inputEditBusinessName" required minlenght="1" maxlenght="50" value="{{ $customer->business_name ? $customer->business_name : old('business_name') }}">
																		<p class="text-danger small d-none" id="nameEditMessage">La razon social es requerida con minimo 6 caracteres de longitud</p>
																	</div>

																	<div class="form-group col-12 col-md-6 mb-3 mb-md-2">
																		<label for="inputEmail" class="form-label">Correo</label>
																		<input name="email" type="email" class="form-control" id="inputEditEmail" minlength="10" value="{{ $customer->email ? $customer->email : old('email') }}">
																		<small class="text-muted">Opcional</small>
																		<p class="text-danger small mb-0 d-none" id="emailEditMessage">El correo debe tener un formato valido, con un minimo de 5 caracteres de longitud antes del "@"</p>
																	</div>
																</div>


																<div class="row mb-3">
																	<div class="form-group col-12 col-md-6 mb-3 mb-md-2">
																		<label for="inputPhone" class="form-label">Telefono Principal</label>
																		<input name="phone" type="number" class="form-control" id="inputEditPhone" minlenght="10" maxlenght="11" value="{{ $customer->phone ? $customer->phone : old('phone') }}">
																		<small class="text-muted">Opcional</small>
																		<p class="text-danger small mb-0 d-none" id="phoneEditMessage">El telefono principal solo puede contener numeros, con un a logitud entre 10 a 12 caracteres</p>
																	</div>

																	<div class="form-group col-12 col-md-6 mb-3 mb-md-2">
																		<label for="inputPhoneSecondary" class="form-label">Telefono Segundario</label>
																		<input name="phone_secondary" type="number" class="form-control" id="inputEditPhoneSecondary" minlenght="10" maxlenght="11" value="{{ $customer->phone_secondary ? $customer->phone_secondary : old('phone_secondary') }}">
																		<small class="text-muted">Opcional</small>
																		<p class="text-danger small mb-0 d-none" id="phoneSecondaryEditMessage">El telefono secundario solo puede contener numeros, con un a logitud entre 10 a 12 caracteres</p>
																	</div>
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

											<!-- ModalDelete -->
											<!-- <button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#modalDelete{{ $customer->id }}"data-toggle="tooltip" title="Eliminar">
												<span><i class="ti ti-trash"></i></span>
											</button>

											<div class="modal fade" id="modalDelete{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Eliminar Cliente</h5>
														</div>
														<form method="POST" action="{{ url("customers/$customer->id") }}" autocomplete="off">
															{{ csrf_field() }}
															<input type="hidden" name="_method" value="DELETE">

															<div class="modal-body">
																<h6>¿Esta seguro de eliminar al cliente {{ $customer->business_name }}?</h6>
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
											<button type="button" class="btn m-1 {{ $customer->status == 1 ? 'btn-danger' : 'btn-success' }}" data-toggle="modal" data-target="#modalChangeStatus{{ $customer->id }}" data-toggle="tooltip" title="{{ $customer->status == 1 ? 'Inhabilitar' : 'Habilitar' }}">
												<span><i class="ti {{ $customer->status == 1 ? 'ti-eye-off' : 'ti-eye' }}"></i></span>
											</button>

											<div class="modal fade" id="modalChangeStatus{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">{{ $customer->status == 1 ? 'Inhabilitar' : 'Habilitar' }}  cliente</h5>
														</div>
														<form method="POST" action="{{  url("change/status/customers/$customer->id")  }}" autocomplete="off">
															{{ csrf_field() }}
															<input type="hidden" name="_method" value="PUT">

															<div class="modal-body">
																<h6>¿Esta seguro de {{ $customer->status == 1 ? 'Inhabilitar' : 'Habilitar' }} el cliente <span class="font-weight-bold">{{ $customer->business_name }}</span>?</h6>
															</div>

															<div class="modal-footer">
																<button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
																<button type="submit" class="btn m-1 {{ $customer->status == 1 ? 'btn-danger' : 'btn-success' }}">
																	{{ $customer->status == 1 ? 'Inhabilitar' : 'Habilitar' }}
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
					{!! $customers->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay clientes agregados
				</div>
			@endif
	    </div>
	</div>

    <!-- ModalAgg -->
    <div class="modal fade" id="modalAgg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Cliente</h5>
                </div>
                <form method="POST" action="{{ url('customers') }}" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="form-group col-12 col-md-4 mb-3 mb-md-3">
                                <label for="inputTypeDocument" class="form-label">Tipo de Documento</label>
                                <select name="type_document" class="form-control" required value="{{ old('type_document') }}">
                                    <option value="0">- Seleccione -</option>
                                    @foreach($document_types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-8 mb-3 mb-md-3">
                                <label for="inputDocument" class="form-label">Documento</label>
                                <input name="document" type="number" class="form-control" id="inputAggDocument" required minlenght="7" maxlenght="10" value="{{ old('document') }}">
								<p class="text-danger small d-none" id="documentAggMessage">El documento debe de contar con una logitud de 7 a 10 caracteres de solo numeros</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-12 col-md-6 mb-3 mb-md-3">
                                <label for="inputBusinessName" class="form-label">Razon Social</label>
                                <input name="business_name" type="text" class="form-control" id="inputAggBusinessName" required minlenght="1" maxlenght="50" value="{{ old('business_name') }}">
								<p class="text-danger small d-none" id="nameAggMessage">La razon social es requerida con minimo 6 caracteres de longitud</p>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3 mb-md-3">
                                <label for="inputEmail" class="form-label">Correo</label>
                                <input name="email" type="email" class="form-control" id="inputAggEmail" minlength="10" value="{{ old('email') }}">
								<small class="text-muted">Opcional</small>
                                <p class="text-danger small mb-0 d-none" id="emailAggMessage">El correo debe tener un formato valido, con un minimo de 5 caracteres de longitud antes del "@"</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="form-group col-12 col-md-6 mb-3 mb-md-3">
                                <label for="inputPhone" class="form-label">Telefono Principal</label>
                                <input name="phone" type="number" class="form-control" id="inputAggPhone" minlenght="10" maxlenght="11" value="{{ old('phone') }}">
								<small class="text-muted">Opcional</small>
                                <p class="text-danger small mb-0 d-none" id="phoneAggMessage">El telefono principal solo puede contener numeros, con un a logitud entre 10 a 12 caracteres</p>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3 mb-md-3">
                                <label for="inputPhoneSecondary" class="form-label">Telefono Segundario</label>
                                <input name="phone_secondary" type="number" class="form-control" id="inputAggPhoneSecondary" minlenght="10" maxlenght="11" value="{{ old('phone_secondary') }}">
                                <small class="text-muted">Opcional</small>
                                <p class="text-danger small mb-0 d-none" id="phoneSecondaryAggMessage">El telefono secundario solo puede contener numeros, con un a logitud entre 10 a 12 caracteres</p>
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

	@include('../layouts/message')
	
@endsection
