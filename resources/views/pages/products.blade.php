@extends('layouts.app')
@section('title', 'Productos')
@section('content')
	<div class="card">
	    <div class="card-body">
			<div class="row">
				<div class="col-6">
					<a href="{{ url('products') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Productos</a>
				</div>
				<div class="col-6 d-md-none d-flex justify-content-end">
					<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" title="Agregar">
						<span><i class="ti ti-plus"></i></span>
					</button>
				</div>
			</div>

			<div class="row pt-4 pt-md-3">
				<div class="col-12 col-md-5 mt-2">
					<form action="{{ url('products/search/list') }}" method="get">
						<div class="input-group">
							<input type="text" name="product" class="form-control" minlenght="3" placeholder="Buscar por descripcion...">
							<button type="submit" class="btn btn-primary">
								<span><i class="ti ti-search"></i></span>
							</button>
						</div>
					</form>
				</div>

				<div class="d-none col-md-7 d-md-flex justify-content-end">
					<a href="{{ url('export/products') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" class="btn btn-primary m-1" title="Exportar">
						<span><i class="ti ti-file-export"></i></span> Exportar 
					</a>
					<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" title="Agregar">
						<span><i class="ti ti-plus"></i></span>
					</button>
				</div>
			</div>

			@if(count($products) > 0)
				<div class="table-responsive">
					<table class="table mt-3">
						<thead>
							<tr>
								<th>Concepto o descripcion</th>
								<th class="text-center">Precio Venta</th>
								<th class="text-center">Precio Venta BS</th>
								<th class="text-center">Existencia</th>
								<th class="text-center">Inventario</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($products as $product)
								<tr>
									<td scope="row">{{ $product->description }}</td>
									<td class="text-center">{{ floor($product->price * pow(10, 2)) / pow(10, 2) }} $ </td>
									<td class="text-center">{{ floor($product->price * $bcv) }} BS</td>
									<td class="text-center">{{ $product->existence != null ? $product->existence : 0 }}</td>
									<td class="text-center">
										@if($product->existence <= $product->existence_minime)
											<span class="badge bg-danger">Insuficiente</span>
										@else
											<span class="badge bg-success">Suficiente</span>
										@endif
									</td>
									<td class="d-flex justify-content-center">

                                        @if (count($product->stocks) > 0)
                                            <!-- ModalStock -->
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalDet{{ $product->id }}" data-toggle="tooltip" title="Inventario">
                                                <span><i class="ti ti-report"></i></span>
                                            </button>

                                            <div class="modal fade" id="modalDet{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Inventario de {{ $product->description }}</h5>
                                                        </div>
                                                        <div class="modal-body ps-2 pt-1 container-table">
                                                            <table class="table table-stock mt-0 scroll">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Cantidad</th>
                                                                        <th class="text-center">Fecha</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($product->stocks as $stock)
                                                                        <tr>
                                                                            <td scope="row">
                                                                                <p class="fw-bolder {{ $stock->exists != 0 ? 'text-success' : 'text-danger' }}">
                                                                                    {{ $stock->quantity }}
                                                                                </p>
                                                                                {{-- <span class="badge rounded-pill px-2 {{ $stock->exists != 0 ? 'bg-success' : 'bg-danger' }}">{{ $stock->exists != 0 ? 'Disponible' : 'Agotado' }}</span> --}}
                                                                            </td>
                                                                            <td class="text-center">
                                                                                {{ \Carbon\Carbon::parse($stock->created_at)->format("d/m/Y") }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

										<!-- ModalEdit -->
										<button type="button" class="btn btn-warning mx-1" data-toggle="modal" data-target="#modalEdit{{ $product->id }}" data-toggle="tooltip" title="Editar">
											<span><i class="ti ti-edit"></i></span>
										</button>

										<div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Editar Producto</h5>
													</div>
													<form method="POST" action="{{ url("products/$product->id") }}" autocomplete="off">
														{{ csrf_field() }}
														  <input type="hidden" name="_method" value="PUT">

														<div class="modal-body" id="bodyModalEdit">
															<div class="form-group mb-4">
																<label for="inputDescription" class="form-label">Descripcion</label>
																<textarea name="description" type="text" class="form-control" id="inputEditDescription" required minlenght="5" maxlenght="150">{{ $product->description ? $product->description : old('description') }}</textarea>
																<p class="text-danger small d-none" id="messageDescriptionEdit">La descripcion solo puede contener letras y numeros, con un minimo de 5 caracteres y maximo 150 caracteres de longitud</p>
															</div>

															<div class="row mb-4">
																<div class="form-group col-12 mb-4">
																	<label for="inputCategory" class="form-label">Categoria</label>
																	<select id="inputCategory" class="form-control" name="category" required value="{{ $product->category ? $product->category : old('category') }}">
																		<option>- Seleccione -</option>
																		@foreach($categories as $category)
																			<option value="{{ $category->id }}" {{ $category->id == $product->category ? 'selected' : '' }}>{{ $category->name }}</option>
																		@endforeach
																	</select>
																</div>

																{{-- <div class="form-group col-12 col-md-7 mb-4">
																	<label class="d-block form-label mb-3">Estado Fiscal</label>

																	<div class="d-inline">
																		<input type="radio" name="iva" id="IvaOne" value=1 class="with-gap radio-col-red" value="checkedValue" required {{ $product->iva == 1 ? 'checked' : '' }}/>
																		<label for="IvaOne">Gravado</label>
																	</div>

																	<div class="ms-5 d-inline">
																		<input type="radio" name="iva" id="IvaTwo" value=0 class="with-gap radio-col-red" value="checkedValue" required {{ $product->iva == 0 ? 'checked' : '' }}/>
																		<label for="IvaTwo">Excento</label>
																	</div>
																</div> --}}

																<div class="mb-4">
																	<div class="form-group mb-4">
																		<label for="inputExistenceMinime" class="form-label">Existencia Minima</label>
																		<input name="minime" type="number" class="form-control" id="inputEditExistenceMinime" min="0" value="{{ $product->existence_minime ? $product->existence_minime : old('minime') }}">
                                                                        <small class="text-muted">Opcional</small>
																		<p class="text-danger small d-none" id="messageExistenceEdit">La existencia minima solo debe contener numeros</p>
																	</div>
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

										@if($product->existence <= 0)
											<!-- ModalDelete
											<button type="button" class="btn btn-danger m-1" data-toggle="modal" data-target="#modalDelete{{ $product->id }}" data-toggle="tooltip" title="Eliminar">
												<span><i class="ti ti-trash"></i></span>
											</button>

											<div class="modal fade" id="modalDelete{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Eliminar Producto</h5>
														</div>
														<form method="POST" action="{{  url("products/$product->id")  }}" autocomplete="off">
															{{ csrf_field() }}
															<input type="hidden" name="_method" value="DELETE">

															<div class="modal-body">
																<h6>¿Esta seguro de eliminar el producto {{ $product->description }}?</h6>
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
											<button type="button" class="btn ms-1 {{ $product->status == 1 ? 'btn-danger' : 'btn-success' }}" data-toggle="modal" data-target="#modalChangeStatus{{ $product->id }}" data-toggle="tooltip" title="{{ $product->status == 1 ? 'Inhabilitar' : 'Habilitar' }}">
												<span><i class="ti {{ $product->status == 1 ? 'ti-eye-off' : 'ti-eye' }}"></i></span>
											</button>

											<div class="modal fade" id="modalChangeStatus{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">{{ $product->status == 1 ? 'Inhabilitar' : 'Habilitar' }}  Producto</h5>
														</div>
														<form method="POST" action="{{  url("change/status/products/$product->id")  }}" autocomplete="off">
															{{ csrf_field() }}
															<input type="hidden" name="_method" value="PUT">

															<div class="modal-body">
																<h6>¿Esta seguro de {{ $product->status == 1 ? 'Inhabilitar' : 'Habilitar' }} el producto <span class="font-weight-bold">{{ $product->description }}</span>?</h6>
															</div>

															<div class="modal-footer">
																<button type="button" class="btn btn-dark" data-dismiss="modal">Cerrar</button>
																<button type="submit" class="btn m-1 {{ $product->status == 1 ? 'btn-danger' : 'btn-success' }}">
																	{{ $product->status == 1 ? 'Inhabilitar' : 'Habilitar' }}
																</button>
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

				<div class="d-flex justify-content-center mt-4">
					{!! $products->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay productos agregados
				</div>
			@endif
	    </div>
	</div>

	<!-- ModalAgg -->
	<div class="modal fade" id="modalAgg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Agregar Producto</h5>
						{{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="ti ti-times"></i></span>
						</button> --}}
				</div>
				<form method="POST" action="{{  url('products')  }}" autocomplete="off">
					{{ csrf_field() }}

					<div class="modal-body">
						<div class="form-group mb-4">
							<label for="inputDescription" class="form-label">Descripcion</label>
							<textarea name="description" type="text" class="form-control" id="inputAggDescription" required maxlenght="150">{{ old('description') }}</textarea>
							<p class="text-danger small d-none" id="messageDescriptionAgg">La descripcion solo puede contener letras y numeros, con un minimo de 5 caracteres y maximo 150 caracteres de longitud</p>
						</div>

						<div class="row mb-4">
							<div class="form-group col-12 mb-4">
								<label for="inputCategory" class="form-label">Categoria</label>
								<select id="inputCategory" class="form-control" name="category" required value="{{ old('category') }}">
									<option>- Seleccione -</option>
									@foreach($categories as $category)
										<option value="{{ $category->id }}" {{ $category->id == old('category') ? 'selected' : '' }}>{{ $category->name }}</option>
									@endforeach
								</select>
							</div>

							{{-- <div class="form-group col-12 col-md-7">
								<label class="d-block form-label mb-3">Estado Fiscal</label>

								<div class="d-inline">
									<input type="radio" name="iva" id="IvaOne" value=1 class="with-gap radio-col-red" value="checkedValue" required {{ old('iva') == 1 ? 'checked' : '' }}"/>
									<label for="IvaOne">Gravado</label>
								</div>

								<div class="ms-5 d-inline">
									<input type="radio" name="iva" id="IvaTwo" value=0 class="with-gap radio-col-red" value="checkedValue" required {{ old('iva') == 0 ? 'checked' : '' }}/>
									<label for="IvaTwo">Excento</label>
								</div>
							</div> --}}
						</div>

						<div class="mb-4">
							<div class="form-group mb-4">
								<label for="inputExistenceMinime" class="form-label">Existencia Minima</label>
								<input name="minime" type="number" class="form-control" id="inputAggExistenceMinime" min="0">
                                <small class="text-muted">Opcional</small>
								<p class="text-danger small d-none" id="messageExistenceAgg">La existencia minima solo debe contener numeros</p>
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
	<script src="{{  asset('js/validProducts.js')  }}"></script>
@endsection
