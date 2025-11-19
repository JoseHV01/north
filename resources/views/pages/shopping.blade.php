@extends('layouts.app')
@section('title', 'Compras')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <a href="{{ url('shopping') }}" class="fw-semibold mb-0 h4" style="color: #5D87FF">Compras</a>
            </div>

            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <a role="button" class="btn btn-primary m-1" href="{{ url('shopping/create') }}"
                        data-toggle="tooltip" title="Agregar">
                        <span><i class="ti ti-plus"></i></span>
                    </a>
                </div>
            </div>
        </div>

        @if(count($shopping) > 0)
            <div class="table-responsive">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>N° Fac</th>
                            <th>N° Control</th>
                            <th>Proveedor</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shopping as $shop)
                            <tr>
                                <td scope="row">
                                    {{ \Carbon\Carbon::parse($shop->date)->format("d/m/Y") }}
                                </td>
                                <td>
                                    {{ $shop->invoice_number }}
                                </td>
                                <td>
                                    {{ $shop->control_number }}
                                </td>
                                <td>
                                    @if($shop->business_name == 'Sin Personalizar')
                                        {{ $shop->business_name }}
                                    @else
                                        {{ $shop->document_type }} {{ $shop->document }} {{ $shop->business_name }}
                                    @endif
                                </td>
                                <td>
                                    {{ floor(($shop->total) * pow(10, 2)) / pow(10, 2) }} $
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {!! $shopping->appends(request()->query())->links() !!}
            </div>
        @else
            <div class="alert alert-danger text-center h4 mt-5" role="alert">
                No hay Compras agregadas
            </div>
        @endif
    </div>
</div>
@include('../layouts/message')
@endsection
