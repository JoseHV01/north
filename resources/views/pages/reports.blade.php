@extends('layouts.app')
@section('title', 'Reportes y Graficas')
@section('content')
	<div class="card">
	    <div class="card-body">
	    	<a href="{{ url('reports') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Reportes y Graficas</a>

            <div class="row my-4">
                <div class="col-7">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-3">Productos mas vendidos</h6>
                            <div class="row col-12 col-md-8 mb-3">
                                <div class="col-5">
                                    <select class="form-control" id="selectorMonth">
                                        <option value="">Mes</option>
                                        @foreach ($queryDates[0] as $value)
                                            @php
                                                $arrayMonth = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                                $position = $value->month < 10 ? substr($value->month, 1) : $value->month;
                                            @endphp
                                            <option value="{{ $value->month }}">{{ $arrayMonth[$position-1] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">
                                    <select class="form-control" id="selectorYear">
                                        <option value="">Año</option>
                                        @foreach ($queryDates[1] as $value)
                                            <option value="{{ $value->year }}">{{ $value->year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary" onclick="searchProducts()">Buscar</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyTable"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-5" style="padding-left: 0px;">
                    <div class="card" style="margin-bottom: 25px !important">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-0">Historico</h6>
                        </div>
                    </div>

                    <div class="d-flex flex-column justify-content-around">
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title fw-semibold mb-3">Compras realizadas</h4>
                                        <p class="card-text h5">{{ $totalTransaction[0] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title fw-semibold mb-3">Ventas concretadas</h4>
                                        <p class="card-text h5">{{ $totalTransaction[1] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="card">
                            <div class="card-body">
                                <h4 class="card-title fw-semibold mb-3">Valor total del Inventario</h4>
                                <p class="card-text h5">{{ floor(($valueTotalProducts) * pow(10, 2)) / pow(10, 2) }} Bs.</p>
                            </div>
                        </div> --}}

                        {{-- <div class="card">
                            <div class="card-body">
                                <h4 class="card-title fw-semibold">Ganancia total estimada</h4>
                                <p class="card-text h5">{{ floor(($valueTotalGanance) * pow(10, 2)) / pow(10, 2) }} Bs.</p>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- <div class="row mb-4">
                <div id="column" class="col-12 col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="loader_chart_shopping_month" class="container-loader">
                                <span class="loader"></span>
                                <h6 class="title">Cargando</h6>
                            </div>
                            <canvas class="d-none" style="max-height:75vh;" id="chart_shopping_month"></canvas>
                        </div>
                    </div>
                </div>

                <div id="column" class="col-12 col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="loader_chart_sale_month" class="container-loader">
                                <span class="loader"></span>
                                <h6 class="title">Cargando</h6>
                            </div>
                            <canvas class="d-none" style="max-height:75vh;" id="chart_sale_month"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title fw-semibold mb-4 text-center">Volumen de Ventas y Compras</h6>
                    <div class="d-flex justify-content-center">
                        <div class="row col-12 col-md-6 mb-0">
                            {{-- <div class="col-5">
                                <select name="" class="form-control" id="selectorMonthOperations">
                                    <option value="">Mes</option>
                                    @foreach ($queryDatesOperations[0] as $value)
                                        @php
                                            $arrayMonth = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                        @endphp
                                        <option value="{{ $value }}">{{ $arrayMonth[$value-1] }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-10">
                                <select name="" class="form-control" id="selectorYearOperations">
                                    <option value="">Año</option>
                                    @foreach ($queryDatesOperations[1] as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-2">
                                <button class="btn btn-primary" onclick="searchOperations()">Buscar</button>
                            </div>
                        </div>
                    </div>

                    <div id="container_operations" class="d-flex justify-content-center align-items-center mt-4 container-chart"></div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title fw-semibold mb-4 text-center">Distribucion de formas de pago</h6>
                    <div class="d-flex justify-content-center">
                        <div class="row col-12 col-md-6 mb-0">
                            <div class="col-5">
                                <select class="form-control" id="selectorMonthDistribution">
                                    <option value="">Mes</option>
                                    @foreach ($queryDatesDistribution[0] as $value)
                                        @php
                                            $arrayMonth = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                        @endphp
                                        <option value="{{ $value }}">{{ $arrayMonth[$value - 1] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-5">
                                <select class="form-control" id="selectorYearDistribution">
                                    <option value="">Año</option>
                                    @foreach ($queryDatesDistribution[1] as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-2">
                                <button class="btn btn-primary" onclick="searchDistributionTransaction()">Buscar</button>
                            </div>
                        </div>
                    </div>

                    <div id="container_distribution_transaction" class="d-flex justify-content-center align-items-center mt-4 container-chart"></div>
                </div>
            </div>
	    </div>
	</div>

	@include('../layouts/message')
    {{-- <script src="{{ asset('js/reports.js') }}"></script> --}}
    <script>
        const metaToken= document.getElementsByName('csrf-token')[0].content;
        const headers = {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': metaToken
            }
        };

        const bodyTable = document.getElementById('bodyTable');
        const containerDistribution = document.getElementById('container_distribution_transaction');
        const containerOperations = document.getElementById('container_operations');

        const arrayMonths = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        searchProducts();
        searchOperations();
        searchDistributionTransaction();

        async function searchProducts() {
            let year = document.getElementById('selectorYear').value != '' ? document.getElementById('selectorYear').value : new Date().getFullYear();
            let month = document.getElementById('selectorMonth').value != '' ? document.getElementById('selectorMonth').value  : (new Date().getMonth() + 1);

            await fetch(`reports-table/${year}/${month}`).then(response => {
                if (response.ok)
                    return response.json()
                else
                    throw new Error(response.status);
            }).then(data => {
                bodyTable.innerHTML = '';
                if(data.length){
                    data.forEach((element, index) => {
                        bodyTable.innerHTML += `
                            <tr>
                                <td>${ index + 1}</td>
                                <td>${ element.name }</td>
                                <td>${ element.total }</td>
                            </tr>
                        `;
                    });
                    return;
                }

                bodyTable.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center">Sin resultados</td>
                    </tr>
                `;
            }).catch(err => {
                console.error("ERROR: ", err.message);
            });
        }

        async function searchOperations(){
            let year = document.getElementById('selectorYearOperations').value != '' ? document.getElementById('selectorYearOperations').value : new Date().getFullYear();
            let colorsList = ['#fc6484', '#9c64fc', '#fccc54', '#387854', '#34a4ec', '#fc9c44', '#cccccc', '#4cc4c4'];

            containerOperations.innerHTML = '';

            await fetch(`reports-operations/${year}`).then(response => {
                if (response.ok)
                    return response.json()
                else
                    throw new Error(response.status);
            }).then(data => {
                var monthsList = [];
                var labelsMonths = [];
                var valuesSales = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                var valuesPurshases = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

                if(data.length > 0){
                    containerOperations.innerHTML = `
                        <canvas class="mt-2" id="chart_operations"></canvas>
                    `;

                    data[0].forEach((element) => {
                       monthsList.push(parseInt(element.month));
                    });

                    data[1].forEach((element) => {
                        if(!monthsList.includes(parseInt(element.month))) monthsList.push(parseInt(element.month));
                    });

                    monthsList = monthsList.sort(function(a, b){return a - b});
                    monthsList.forEach(numberMonth => {
                        labelsMonths.push(arrayMonths[numberMonth - 1]);
                    });

                    data[0].forEach(item => {
                        valuesPurshases[parseInt(item.month) - 1] = item.total;
                    });
                    valuesPurshases = valuesPurshases.slice((monthsList[0] - 1), monthsList.at(-1));

                    data[1].forEach(item => {
                        valuesSales[parseInt(item.month) - 1] = item.total;
                    });
                    valuesSales = valuesSales.slice((monthsList[0] - 1), monthsList.at(-1));

                    new Chart(document.querySelector("#chart_operations"), {
                        type: 'bar',
                        data: {
                            labels: labelsMonths,
                            datasets: [{
                                label: 'Ventas',
                                data: valuesSales,
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderWidth: 1,
                                hoverOffset: 4
                            },{
                                label: 'Compras',
                                data: valuesPurshases,
                                backgroundColor: 'rgb(54, 162, 235)',
                                borderWidth: 1,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            plugins: {
                                title:{
                                    display: true,
                                    text: ``,
                                },
                                legend:{
                                    labels:{
                                        font:{
                                            size: 16
                                        },
                                    },
                                }
                            }
                        }
                    });
                }else{
                    containerOperations.innerHTML = `
                        <h3 class="text-center" style="font-weight: 600;">Sin resultados</h3>
                    `;
                }
            }).catch(err => {
                console.error("ERROR: ", err.message);
            });
        }

        async function searchDistributionTransaction() {
            let year = document.getElementById('selectorYearDistribution').value != '' ? document.getElementById('selectorYearDistribution').value : new Date().getFullYear();
            let month = document.getElementById('selectorMonthDistribution').value != '' ? document.getElementById('selectorMonthDistribution').value  : (new Date().getMonth() + 1);

            let colorsList = ['#34a4ec', '#fc6484', '#fc9c44', '#cccccc', '#4cc4c4', '#9c64fc', '#fccc54', '#387854'];

            containerDistribution.innerHTML = '';

            await fetch(`reports-distribution/${year}/${month}`).then(response => {
                if (response.ok)
                    return response.json()
                else
                    throw new Error(response.status);
            }).then(data => {
                var datasetsList = [];
                var labelMonth = arrayMonths[month - 1];

                if(data.length > 0){
                    containerDistribution.innerHTML = `
                        <canvas id="chart_distribution_transaction"></canvas>
                    `;

                    data.forEach((element, index) => {
                        datasetsList.push({
                            label: element.name,
                            data: [element.total],
                            backgroundColor: colorsList[index],
                            borderWidth: 1,
                            hoverOffset: 4
                        });
                    });

                    new Chart(document.querySelector("#chart_distribution_transaction"), {
                        type: 'bar',
                        data: {
                            labels: [labelMonth],
                            datasets: datasetsList,
                        },
                        options: {
                            plugins: {
                                title:{
                                    display: true,
                                    text: ``,
                                },
                                legend:{
                                    labels:{
                                        font:{
                                            size: 16
                                        },
                                    },
                                }
                            }
                        }
                    });
                }else{
                    containerDistribution.innerHTML = `
                        <h3 class="text-center" style="font-weight: 600;">Sin resultados</h3>
                    `;
                }
            }).catch(err => {
                console.error("ERROR: ", err.message);
            });
        }
    </script>
@endsection
