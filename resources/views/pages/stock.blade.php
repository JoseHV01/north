@extends('layouts.app')
@section('title', 'Inventario')
@section('content')
	<div class="card">
	    <div class="card-body">
			<div class="row">
				<div class="col-12">
					<a href="{{ url('stock') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Inventario</a>
				</div>
			</div>

			{{-- <div class="row pt-4 pt-md-3">
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
					<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modalAgg" data-toggle="tooltip" title="Agregar">
						<span><i class="ti ti-plus"></i></span>
					</button>
				</div>
			</div> --}}

            {{-- @if(count($stock) > 0) --}}
                <form action="{{ url('stock/search') }}" method="get" class="row mt-4 mb-3">
                    <div class="col-12 col-md-9 row">
                        <div class="form-group col-12 col-md-5 mb-3 mb-md-0">
                            <small class="form-label">Numero Factura</small>
                            <input type="number" class="form-control" name="number_bills">
                        </div>

                        <div class="form-group col-6 col-md-5 mb-3 mb-md-0">
                            <small class="form-label">Fecha</small>
                            <input type="date" class="form-control" name="start" max="{{ date("Y-m-d") }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="d-flex justify-content-center align-items-center pt-1 pt-md-2">
                            <button type="submit" class="btn btn-primary w-50">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
        {{-- @endif --}}

			{{-- @if(count($stock) > 0)
				<div class="table-responsive">
					<table class="table mt-3">
						<thead>
							<tr>
								<th>Lote</th>
								<th class="text-center">Fecha</th>
								<th class="text-center">Estado</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($stock as $product)
								<tr>
									<td scope="row">{{ $product->description }}</td>
									<td class="text-center">{{ $product->existence != null ? $product->existence : 0 }}</td>
									<td class="text-center"></td>
									<td class="d-flex justify-content-center"></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="d-flex justify-content-center mt-4">
					{!! $stock->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay inventario registrado
				</div>
			@endif --}}
	    </div>
	</div>

	@include('../layouts/message')
@endsection
