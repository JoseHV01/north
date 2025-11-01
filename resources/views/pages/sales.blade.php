@extends('layouts.app')
@section('title', 'Ventas')
@section('content')
	<div class="card">
	    <div class="card-body">
	    	<div class="row">
                <div class="col-6 d-flex align-items-center">
                    <a href="{{ url('sales') }}" class="fw-semibold mb-0 h4"style="color: #5D87FF">Ventas</a>
                </div>
                <div class="col-6">
					<div class="d-flex justify-content-end">
						<a role="button" class="btn btn-primary m-1" href="{{ url('sales/create') }}" data-toggle="tooltip" title="Agregar">
							<span><i class="ti ti-plus"></i></span>
						</a>
					</div>
                </div>
            </div>

			@if(count($sales) > 0)
				<div class="table-responsive">
					<table class="table mt-3">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach($sales as $sale)
								<tr>
									<td scope="row">
										{{ \Carbon\Carbon::parse($sale->created_at)->format("d/m/Y") }} -
										{{ \Carbon\Carbon::parse($sale->created_at)->format("h:i A") }}
									</td>
									@if($sale->business_name == 'Sin Personalizar')
										<td>
											{{ $sale->business_name }}
										</td>
									@else
										<td>
											{{ $sale->document_type }} {{ $sale->document }} {{ $sale->business_name }}
										</td>
									@endif
									<td>
										{{ floor(($sale->total) * pow(10, 2)) / pow(10, 2) }} Bs
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="d-flex justify-content-center mt-4">
					{!! $sales->appends(request()->query())->links() !!}
				</div>
			@else
				<div class="alert alert-danger text-center h4 mt-5" role="alert">
					No hay ventas agregadas
				</div>
			@endif
	    </div>
	</div>
	@include('../layouts/message')
@endsection
