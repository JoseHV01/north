@extends('layouts.app')
@section('title', 'Ventas')
@section('content')
	<div class="card">
	    <div class="card-body">
	    	<a href="{{ url('sales') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Ventas</a>

	    	<form id="formSales" action="{{ url('sales') }}" method="POST">
				{{ csrf_field() }}

		    	<div class="row mt-4 gap-4 gap-md-0">
					<div class="form-group col-12 col-md-6 mb-4 mb-lg-0">
						<label for="selectCustomer" class="form-label">Cliente</label>
						<select name="customer" class="form-control" id="selectCustomer" onchange="evaluateValueSelects()" required>
							<option value="0"></option>
							@foreach($customers as $customer)
								<option value="{{ $customer->id }}">{{ $customer->document_type }} {{ $customer->document }} &nbsp;&nbsp; {{ $customer->business_name }}</option>
							@endforeach
						</select>
					</div>
					<input id="total_sales" type="hidden" name="totalSales" value="0">
					<div class="form-group col-12 col-md-6 mb-4 mb-lg-0">
						<label class="form-label">Forma de Pago</label>
						<div class="dropdown">
							<span class="form-control w-100 text-start" type="button" id="dropdownShapes" data-bs-toggle="dropdown" aria-expanded="false">
								- Seleccione -
							</span>
							<ul class="dropdown-menu w-100" aria-labelledby="dropdownShapes" id="dropdownShapesMenu">
								@foreach($shapes_payments as $shape_payment)
									<li>
										<label class="dropdown-item">
											<input type="checkbox" class="form-check-input me-2 shape-payment-checkbox" name="shape_payment[]" value="{{ $shape_payment->id }}" onchange="evaluateValueSelects()">
											{{ $shape_payment->name }}
										</label>
									</li>
								@endforeach
							</ul>
						</div>
						<small class="text-muted">Selecciona una o más formas de pago.</small>
						<input type="hidden" name="shape_payment_input" id="shapePaymentHidden">
					</div>
					<div id="shapePaymentAmounts" class="d-none"></div>

					<div class="form-group col-12 col-md-4 d-none">
						<label for="selectStates" class="form-label">Estado de Operacion</label>
						<select name="states_operation" class="form-control" id="selectStates"  onchange="evaluateValueSelects()" required>
							<option value="1">- Seleccione -</option>
							@foreach($states_operation as $state_operation)
								<option value="{{ $state_operation->id }}">{{ $state_operation->name }}</option>
							@endforeach
						</select>
					</div>
				</div>

		    	<div class="my-4 row">
					<div class="col-12 col-md-6 form-group mt-4 mt-md-0">
						<label class="form-label">Categoria</label>
						<select class="form-control" id="selectCategory" disabled>
							<option value="">- Seleccione -</option>
							@foreach($categorys as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
		    		<div class="col-12 col-md-6 form-group">
						<label class="form-label">Producto</label>
			    		<div class="input-group">
							<input id="search_product" type="text" class="form-control" minlength="1" disabled>
							<button id="btn_search" type="button" class="btn btn-primary" disabled>
								<span><i class="ti ti-search"></i></span>
							</button>
						</div>
					</div>

					
				</div>

				<div id="container_search_category" class="my-5 d-none">
					<div id="container_search" class="mt-1 mb-3 row pe-0 pe-md-3">
						<h6 id="paramet" class="col-6 col-md-10 d-flex align-items-center" style="font-weight: bold !important;"></h6>
						<div class="col-6 col-md-2 d-flex justify-content-end align-items-center">
							<button type="button" class="btn btn-danger" onclick="clearSearch(true)">
								<span><i class="ti ti-search-off"></i></span>
							</button>
						</div>
					</div>
					<div id="container_result" class="mt-1"></div>

					<div id="container_sale" class="my-5 d-none">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cant.</th>
                                        <th>Concepto o Descripcion</th>
                                        <th>P. Unit.</th>
                                        <th>Total</th>
                                        <th>Descartar</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTableResult"></tbody>
                            </table>
                        </div>

						<div class="d-flex justify-content-end align-items-center mt-3">
							<table class="table" style="width: 100%">
								<tbody>
									<tr>
										<th>Base Imponible</th>
										<td id="base" class="text-center"></td>
									</tr>

									<tr>
										<th>IVA
											<span id="iva"></span> sobre <span id="base_copy"></span>
										</th>
										<td id="totalIva" class="text-center"></td>
									</tr>

									<tr id="container_igtf" class="d-none">
										<th>IGTF
											<span id="igtf"></span> sobre <span id="igtf_copy"></span>
											<br><br>
											<span class="pt-2" style="font-weight: normal;">(Tasa BCV {{ Cache::get('bcv') }})</span>
										</th>
										<td id="totalIgtf" class="text-center"></td>
									</tr>

									<tr>
										<th>Total</th>
										<td id="total" class="text-center"></td>
									</tr>
									<tr id="container_error" class="d-none">
										<th colspan="2" class="text-danger text-sm">La suma de los montos no coincide con el total de la venta.</th>
									</tr>
								</tbody>
							</table>
						</div>

                        <input type="hidden" name="totalSale" id="totalSale">
                        <input type="hidden" name="taxBase" id="taxBase">
						<div class="d-flex justify-content-end align-items-center mt-4 gap-3">
							<button type="button" class="btn btn-dark" onclick="cancelSale()">Cancelar</button>
							<button type="submit" class="btn btn-primary" id="btn_save">Guardar</button>
						</div>
					</div>
				</div>
	    	</form>
	    </div>
	</div>
	@include('../layouts/message')

  	
@endsection
@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const element = document.getElementById('selectCustomer');
			const choices = new Choices(element, {
				searchEnabled: true,
				itemSelectText: '',
				placeholder: true,
				placeholderValue: '- Seleccione un cliente -',
			});
		});
	</script>
	<script>
        listProducts = @php echo json_encode($products) @endphp;
		const dollarRate = @json($rates->firstWhere('name', 'BCV')->value ?? 0);
		const shapesPayments = @json($shapes_payments); 
  	</script>
  	<script src="{{ asset('js/sales_create.js') }}"></script>
@endsection