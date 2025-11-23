@extends('layouts.app')
@section('title', 'Crear Compra')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ url('shopping/create') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Compras</a>

            <form id="shoppingForm" action="{{ url('shopping') }}" method="POST">
                {{ csrf_field() }}


                <!-- STEP 1: Encabezado (cliente y datos de factura) -->
                <div id="step-1">
                    <div class="row mt-4">
                        <div class="form-group col-12 col-md-6 mb-4">
                            <label for="selectCustomer" class="form-label">Numero de Factura</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">N°</span>
                                <input id="bill" type="number" class="form-control" name="invoiceNumber"
                                    min="1" aria-describedby="basic-addon1" required
                                    onkeyup="evaluateValueSelects()">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 mb-4">
                            <label for="selectCustomer" class="form-label">Numero de Control</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">N°</span>
                                <input id="bill_number" type="number" class="form-control" name="controlNumber"
                                    min="1" aria-describedby="basic-addon3" required
                                    onkeyup="evaluateValueSelects()">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 mb-4">
                            <label for="selectCustomer" class="form-label">Fecha de Compra</label>
                            <input id="shopping_date" type="date" class="form-control" name="date"
                                max="{{ date('Y-m-d') }}" required onkeyup="evaluateValueSelects()">
                        </div>
                        <div class="form-group col-12 col-md-6 mb-4">
                            <label for="selectCustomer" class="form-label">Proveedor</label>
                            <select name="provider" class="form-control" id="selectCustomer"
                                onchange="evaluateValueSelects()" required>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->document_type }}
                                        {{ $provider->document }} &nbsp;&nbsp; {{ $provider->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6 mb-4">
                            <label for="dollarRate" class="form-label">Precio del Dólar</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon-dollar">$</span>
                                <input id="dollarRate" type="number" class="form-control" name="dollarRate"
                                    min="0.01" step="0.01" value="{{ $rates->firstWhere('name', 'BCV')->value ?? 0 }}"
                                    aria-describedby="basic-addon-dollar" required onkeyup="evaluatePaymentsSum()">
                            </div>
                        </div>
                    </div>

                    <div id="step1Error" class="alert alert-danger d-none mt-3"></div>
                </div>

                <div class="mt-4 mb-5 row d-none">
                    <div class="form-group col-12 col-md-4 ">
                        <label for="selectStates" class="form-label">Estado de Operacion</label>
                        <select name="states_operation" class="form-control" id="selectStates"
                            onchange="evaluateValueSelects()" required>
                            <option value="1">- Seleccione -</option>
                            @foreach ($states_operation as $state_operation)
                                <option value="{{ $state_operation->id }}">{{ $state_operation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="step-2">
                    <div class="mt-4 mb-5 row">
                        <div class="col-12 col-md-6 form-group">
                            <label class="form-label">Categoria</label>
                            <select class="form-control" id="selectCategory">
                                <option value="">- Seleccione -</option>
                                @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 form-group mb-4 mb-lg-0">
                            <label class="form-label">Producto</label>
                            <div class="input-group">
                                <input id="search_product" type="text" class="form-control" min="1">
                                <button id="btn_search" type="button" class="btn btn-primary">
                                    <span><i class="ti ti-search"></i></span>
                                </button>
                            </div>
                        </div>


                    </div>

                    <div id="container_search_category" class="my-5 d-none">
                        <div id="container_search" class="mt-1 mb-3 row pe-0 pe-md-3">
                            <h6 id="paramet" class="col-6 col-md-10 d-flex align-items-center"
                                style="font-weight: bold !important;"></h6>
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
                                            <th>Producto</th>
                                            <th>Cant.</th>
                                            <th>Precio</th>
                                            <th>% Ganacia</th>
                                            <th>Descartar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="shopResult"></tbody>
                                    <tr>
                                        <td colspan="5">
                                            <div class="alert alert-warning mb-0" role="alert">
                                                <strong>Recuerda que:</strong> los precios deben ser mayor a 0.01$ y que los
                                                porcentaje de ganancia no pueden ser mayores a 99
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div id="step2Error" class="alert alert-danger d-none mt-3"></div>
                            <div class="d-flex justify-content-start align-items-center mt-4 gap-3">
                                <div>
                                    <button type="button" class="btn btn-dark" onclick="cancelSale()">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Pagos y Resumen -->
                <div id="step-3">
                    <div class="row mt-4">
                        <div class="form-group col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                            <label for="shopping_total" class="form-label">Total de la Compra</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2">$</span>
                                <input id="shopping_total" type="number" class="form-control" name="totalShopping"
                                    aria-describedby="basic-addon2" readonly min="0">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-8 mb-4 mb-lg-0">
                            <label class="form-label">Forma de Pago</label>
                            <div class="dropdown">
                                <span class="form-control w-100 text-start" type="button" id="dropdownShapes"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    - Seleccione -
                                </span>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownShapes" id="dropdownShapesMenu">
                                    @foreach ($shapes_payments as $shape_payment)
                                        <li>
                                            <label class="dropdown-item">
                                                <input type="checkbox"
                                                    class="form-check-input me-2 shape-payment-checkbox"
                                                    name="shape_payment[]" value="{{ $shape_payment->id }}">
                                                {{ $shape_payment->name }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <small class="text-muted">Selecciona una o más formas de pago y asigna montos en la
                                lista.</small>
                            <input type="hidden" name="shape_payment_input" id="shapePaymentHidden">
                        </div>
                    </div>
                    <div id="shapePaymentAmounts" class="mt-4 mb-5 row d-none"></div>



                    <div id="paymentsError" class="alert alert-danger d-none mt-3"></div>
                    <div class="d-flex justify-content-end align-items-center mt-4 gap-3">
                        <button id="submitBtn" type="submit" class="btn btn-success">Guardar Compra</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    @include('../layouts/message')


@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const element = document.getElementById('selectCustomer');
            const choices = new Choices(element, {
                searchEnabled: true,
                itemSelectText: '',
                placeholder: true,
                placeholderValue: '- Seleccione un proveedor -',
            });
        });
    </script>
    <script>
        listProducts = @php echo json_encode($products) @endphp;
        const shapesPayments = @json($shapes_payments);
    </script>
    <script>
        (function() {
            // Elements (safely get them)
            const selectCustomer = document.getElementById('selectCustomer');
            const selectCategory = document.getElementById('selectCategory');
            const inputSearchProduct = document.getElementById('search_product');
            const btnSearch = document.getElementById('btn_search');
            const bill = document.getElementById('bill');
            const shoppingDate = document.getElementById('shopping_date');
            const billNumber = document.getElementById('bill_number');
            const dollarRate = document.getElementById('dollarRate');
            const containerSearch = document.getElementById('container_search');
            const containerCategory = document.getElementById('container_search_category');
            const containerResult = document.getElementById('container_result');
            const containerSale = document.getElementById('container_sale');
            const bodyTable = document.getElementById('shopResult');
            const reviewResult = document.getElementById('reviewResult');
            const shoppingTotalInput = document.getElementById('shopping_total');
            
            // Dynamic getter for dollarRate from input
            function getDollarRate() {
                return parseFloat(dollarRate?.value || 0) || 0;
            }



            let listProducts = [],
                productsSale = [],
                resultsProducts = [];
            const metaToken = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
            const headers = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': metaToken
                }
            };

            // Fetch product list
            fetch('list/search', headers).then(r => r.ok ? r.json() : Promise.reject(r.status)).then(data => {
                listProducts = data[0] || [];
            }).catch(() => {});

            // Navigation between steps


            function evaluateValueSelects() {
                
                // header validation: bill, bill_number, shopping_date and provider
                const billVal = bill && bill.value !== '';
                const billNumVal = billNumber && billNumber.value !== '';
                const dateVal = shoppingDate && shoppingDate.value !== '';
                const providerVal = selectCustomer && selectCustomer.value !== '';
                const ok = billVal && billNumVal && dateVal && providerVal;
                
                // enable product search if header ok
                if (ok) {
                    if (selectCategory) selectCategory.disabled = false;
                    if (inputSearchProduct) inputSearchProduct.disabled = false;
                    if (btnSearch) btnSearch.disabled = false;
                } else {
                    if (selectCategory) selectCategory.disabled = true;
                    if (inputSearchProduct) inputSearchProduct.disabled = true;
                    if (btnSearch) btnSearch.disabled = true;
                }
            }
            window.evaluateValueSelects = evaluateValueSelects;

            // Navigation listeners (use navigateToStep to enforce validations)


            function isStep1Valid() {
                const billVal = bill && bill.value !== '';
                const billNumVal = billNumber && billNumber.value !== '';
                const dateVal = shoppingDate && shoppingDate.value !== '';
                const providerVal = selectCustomer && selectCustomer.value !== '';
                return billVal && billNumVal && dateVal && providerVal;
            }

            function isStep2Valid() {
                let valid = true;
                const messages = [];
                productsSale.forEach(id => {
                    const q = parseFloat(document.getElementById('quantity' + id)?.value || 0) || 0;
                    const p = parseFloat(document.getElementById('price' + id)?.value || 0) || 0;
                    const perc = parseFloat(document.getElementById('percentaje' + id)?.value || 0) || 0;
                    const prod = listProducts.find(pObj => pObj.id == id) || {};
                    const name = prod.description || ('ID ' + id);
                    if (q < 1) {
                        valid = false;
                        messages.push(`La cantidad de "${name}" debe ser al menos 1.`);
                    }
                    if (p < 0.1) {
                        valid = false;
                        messages.push(`El precio de "${name}" debe ser al menos 0.1.`);
                    }
                    if (perc < 1) {
                        valid = false;
                        messages.push(`El % Ganancia de "${name}" debe ser al menos 1.`);
                    }
                    if (perc > 99) {
                        valid = false;
                        messages.push(`El % Ganancia de "${name}" no debe ser mayor a 99.`);
                    }
                });
                return {
                    valid,
                    messages
                };
            }



            // Search products
            if (btnSearch) btnSearch.addEventListener('click', searchProducts);
            if (selectCategory) selectCategory.addEventListener('change', () => {
                
                clearSearch();
                resultsProducts = listProducts.filter(p => p.id_category == selectCategory.value);
                visibleContainer('Categoria');
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    searchProducts();
                    e.preventDefault();
                }
            });

            function searchProducts() {
                if (!inputSearchProduct) return;
                clearSearch();
                const val = inputSearchProduct.value.trim().toLowerCase();
                resultsProducts = listProducts.filter(p => (p.description || '').toLowerCase().includes(val));
                visibleContainer('Descripcion');
            }

            function clearSearch(clearAll = false) {
                if (clearAll) {
                    if (inputSearchProduct) inputSearchProduct.value = '';
                    if (selectCategory) selectCategory.value = '';
                }
                resultsProducts = [];
                if (containerResult) containerResult.innerHTML = '';
                if (containerSearch) containerSearch.classList.add('d-none');
            }

            function visibleContainer(searchParamet) {
                if (containerCategory) containerCategory.classList.remove('d-none');
                if (containerSearch) containerSearch.classList.remove('d-none');
                const param = document.getElementById('paramet');
                if (param) param.textContent = resultsProducts.length > 0 ? 'Por ' + searchParamet + ':' :
                    'Busqueda sin resultados';
                if (resultsProducts.length > 0) {
                    const frag = document.createDocumentFragment();
                    resultsProducts.forEach(p => {
                        const btn = document.createElement('button');
                        btn.id = 'prod_' + p.id;
                        btn.type = 'button';
                        btn.className = 'btn btn-outline-secondary mb-2 me-1';
                        btn.textContent = p.description;
                        btn.onclick = () => salesCar(p.id);
                        addStyles(btn, p.id);
                        frag.appendChild(btn);
                    });
                    containerResult.appendChild(frag);
                }
            }

            function addStyles(btn, idProduct) {
                if (productsSale.includes(idProduct)) {
                    btn.classList.remove('btn-outline-secondary');
                    btn.classList.add('btn-success');
                    btn.disabled = true;
                } else {
                    btn.classList.add('btn-outline-secondary');
                    btn.classList.remove('btn-success');
                    btn.disabled = false;
                }
            }

            function toggleProductBtn(id, selected) {
                const btn = document.getElementById('prod_' + id);
                if (btn) {
                    btn.classList.toggle('btn-success', selected);
                    btn.classList.toggle('btn-outline-secondary', !selected);
                    btn.disabled = selected;
                }
            }

            window.salesCar = function(idProduct) {
                if (productsSale.includes(idProduct)) {
                    removeProductOfList(idProduct);
                    toggleProductBtn(idProduct, false);
                } else {
                    addProductToList(idProduct);
                    toggleProductBtn(idProduct, true);
                }
            };

            function addProductToList(idProduct) {
                if (productsSale.indexOf(idProduct) !== -1) return;
                productsSale.push(idProduct);
                const product = listProducts.find(p => p.id == idProduct);
                if (!product) return;
                const {
                    id,
                    description
                } = product;
                const tr = document.createElement('tr');
                tr.id = 'fila' + id;
                tr.innerHTML =
                    `
            <td>${description}</td>
            <td><input id="quantity${id}" name="quantity[]" type="number" class="form-control" min="1" value="1" style="min-width: 4rem;" required><input name="product_id[]" class="d-none" type="number" value="${id}"></td>
            <td>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input id="price${id}" name="price[]" type="number" class="form-control" min="0.1" step="0.01" value="1.00" style="min-width: 3rem;" required>
                </div>
            </td>
            <td><input id="percentaje${id}" name="percentaje[]" type="number" class="form-control" min="1" value="1" max="99" style="min-width: 5rem;" required></td>
            <td><button type="button" class="btn btn-danger m-1" data-toggle="tooltip" title="Descartar" onclick="removeProductOfList(${id})"><span><i class="ti ti-trash"></i></span></button></td>`;
                if (bodyTable) bodyTable.appendChild(tr);
                // attach listeners
                const qEl = document.getElementById('quantity' + id);
                const pEl = document.getElementById('price' + id);
                const percEl = document.getElementById('percentaje' + id);
                if (qEl) qEl.addEventListener('input', () => {
                    recalcTotals();

                });
                if (pEl) pEl.addEventListener('input', () => {
                    recalcTotals();
                    evaluatePaymentsSum();
                });
                if (percEl) percEl.addEventListener('input', () => {

                });
                if (containerSale) containerSale.classList.remove('d-none');

            }

            window.removeProductOfList = function(idProduct) {
                productsSale = productsSale.filter(id => id !== idProduct);
                const fila = document.getElementById('fila' + idProduct);
                if (fila) fila.remove();
                toggleProductBtn(idProduct, false);
                if (productsSale.length === 0 && containerSale) containerSale.classList.add('d-none');

                recalcTotals();
            };



            function recalcTotals() {
                let sum = 0;
                productsSale.forEach(id => {
                    const q = parseFloat(document.getElementById('quantity' + id)?.value || 0) || 0;
                    const p = parseFloat(document.getElementById('price' + id)?.value || 0) || 0;
                    sum += q * p;
                });
                if (shoppingTotalInput) shoppingTotalInput.value = sum.toFixed(2);
            }
            window.recalcTotals = recalcTotals;



            // Payment inputs
            let paymentsOk = true;
            const paymentsErrorEl = document.getElementById('paymentsError');
            const submitBtn = document.getElementById('submitBtn');

            function updateShapePaymentInputs() {
                const checked = Array.from(document.querySelectorAll('.shape-payment-checkbox:checked'));
                const container = document.getElementById('shapePaymentAmounts');
                const hiddenInput = document.getElementById('shapePaymentHidden');
                const dropdownShapes = document.getElementById('dropdownShapes');

                if (!container || !hiddenInput) return;
                container.innerHTML = '';
                hiddenInput.value = checked.map(cb => cb.value).join(',');

                // Update dropdown placeholder
                if (dropdownShapes) {
                    if (checked.length > 0) {
                        const names = checked.map(cb => {
                            const paymentObj = (shapesPayments && shapesPayments.find && (shapesPayments.find(sp =>
                                sp.id == cb.value) || {})) || {};
                            return paymentObj.name || cb.parentNode.textContent.trim();
                        });
                        dropdownShapes.textContent = names.join(', ');
                    } else {
                        dropdownShapes.textContent = '- Seleccione -';
                    }
                }

                if (checked.length > 0) {
                    container.classList.remove('d-none');
                    container.classList.add('row');
                    checked.forEach(cb => {
                        const paymentObj = (shapesPayments && shapesPayments.find && (shapesPayments.find(sp =>
                            sp.id == cb.value) || {})) || {};
                        const paymentName = paymentObj.name || cb.parentNode.textContent.trim();
                        const safeName = String(paymentName).replace(/\"/g, '');
                        const inputDiv = document.createElement('div');
                        inputDiv.className = 'col-12 col-md-4';
                        // attach data-shape-name to the input so we can know which method it is later
                        inputDiv.innerHTML = '<div class="form-group"><label class="form-label">' +
                            paymentName + ' - Monto</label><input type="number" name="amounts[' + cb.value +
                            ']" data-shape-name="' + safeName + '" data-shape-id="' + cb.value +
                            '" class="form-control payment-amount-input" min="0" step="0.01" required></div>';
                        container.appendChild(inputDiv);
                    });
                    
                    // Add suggestion element
                    let suggestionEl = document.getElementById('paymentsSuggestion');
                    if (!suggestionEl) {
                        suggestionEl = document.createElement('div');
                        suggestionEl.id = 'paymentsSuggestion';
                        suggestionEl.className = 'text-muted small mt-2 col-12';
                        container.appendChild(suggestionEl);
                    }

                    // attach listeners
                    container.querySelectorAll('.payment-amount-input').forEach(inp => inp.addEventListener('input',
                        (e) => {
                            calculatePaymentLogic(e.target);
                            evaluatePaymentsSum();
                        }));
                        
                    // Initial calculation
                    calculatePaymentLogic(null);
                } else {
                    container.classList.add('d-none');
                }
                // evaluate on change
                evaluatePaymentsSum();
            }

            function calculatePaymentLogic(triggerInput) {
                const totalUSD = parseFloat(shoppingTotalInput?.value || 0) || 0;
                const rate = getDollarRate();
                const inputs = Array.from(document.querySelectorAll('.payment-amount-input'));
                const suggestionEl = document.getElementById('paymentsSuggestion');

                // Identify Divisas input
                const divisasInput = inputs.find(inp => {
                    const name = (inp.dataset.shapeName || '').toLowerCase();
                    return name.includes('divisa') || name.includes('dolar') || name.includes('usd');
                });

                // Scenario: Divisas + Others
                if (divisasInput && inputs.length > 1) {
                    // If user is typing in Divisas, or if we just initialized and want to distribute
                    if (triggerInput === divisasInput || triggerInput === null) {
                        const valDivisas = parseFloat(divisasInput.value || 0);
                        const remainingUSD = Math.max(0, totalUSD - valDivisas);
                        const remainingBs = remainingUSD * rate;

                        // Find other inputs
                        const otherInputs = inputs.filter(inp => inp !== divisasInput);
                        // Auto-fill the first other input with the remainder in Bs
                        if (otherInputs.length > 0) {
                            otherInputs[0].value = remainingBs.toFixed(2);
                        }
                    }
                    if (suggestionEl) suggestionEl.textContent = '';
                } 
                // Scenario: Only Non-Divisas (one or more)
                else if (!divisasInput && inputs.length > 0) {
                    const totalBs = totalUSD * rate;
                    if (suggestionEl) {
                        suggestionEl.textContent = `Total a pagar: $${totalUSD.toFixed(2)} ≈ Bs ${totalBs.toFixed(2)}`;
                    }
                }
                // Scenario: Only Divisas
                else if (divisasInput && inputs.length === 1) {
                     if (suggestionEl) suggestionEl.textContent = '';
                }
            }

            function evaluatePaymentsSum() {
                // Compare everything in USD.
                // Assumption: `shopping_total` is expressed in USD (UI shows $).
                // For payment amounts, if the payment method name is "divisas" we treat the entered amount as USD already.
                // For other methods we convert the entered amount to USD using `dollarRate` (local currency per USD): usd = amount / dollarRate.
                const totalUSD = parseFloat(shoppingTotalInput?.value || 0) || 0;
                let sumUSD = 0;
                document.querySelectorAll('.payment-amount-input').forEach(inp => {
                    const v = parseFloat(inp.value || 0) || 0;
                    const shapeName = String(inp.dataset.shapeName || '').trim().toLowerCase();
                    let vUSD = v;
                    if (shapeName !== 'divisas') {
                        // convert to USD if possible
                        const rate = getDollarRate();
                        if (rate > 0) {
                            vUSD = v / rate;
                        } // local currency to USD
                        else {
                            vUSD = v;
                        } // fallback if no rate available
                    }
                    sumUSD += vUSD;
                });
                const totalInput = shoppingTotalInput;
                // payments match in USD?
                paymentsOk = Math.abs(sumUSD - totalUSD) <= 0.01;
                if (totalInput) {
                    if (!paymentsOk) {
                        totalInput.classList.add('is-invalid');
                        if (paymentsErrorEl) {
                            paymentsErrorEl.classList.remove('d-none');
                            paymentsErrorEl.textContent =
                                'La suma (en USD) de los montos de pago no coincide con el total de la compra.';
                        }
                    } else {
                        totalInput.classList.remove('is-invalid');
                        if (paymentsErrorEl) {
                            paymentsErrorEl.classList.add('d-none');
                            paymentsErrorEl.textContent = '';
                        }
                    }
                }
                if (submitBtn) submitBtn.disabled = !paymentsOk;
                return paymentsOk;
            }

            // wire payment checkbox changes
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.shape-payment-checkbox').forEach(cb => cb.addEventListener('change',
                    updateShapePaymentInputs));
            });

            // Block form submission if payments don't match total
            const shoppingForm = document.getElementById('shoppingForm');
            if (shoppingForm) {
                shoppingForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // 1. Validate Header
                    if (!isStep1Valid()) {
                         const step1Error = document.getElementById('step1Error');
                         if(step1Error) {
                            step1Error.classList.remove('d-none');
                            step1Error.textContent = 'Complete los datos del Encabezado.';
                         }
                         document.getElementById('step-1').scrollIntoView({ behavior: 'smooth' });
                         return;
                    } else {
                         const step1Error = document.getElementById('step1Error');
                         if(step1Error) step1Error.classList.add('d-none');
                    }

                    // 2. Validate Products
                    const prodVal = isStep2Valid();
                    if (!prodVal.valid) {
                        const step2Error = document.getElementById('step2Error');
                        if (step2Error) {
                            step2Error.classList.remove('d-none');
                            step2Error.innerHTML = prodVal.messages.join('<br>');
                        }
                        document.getElementById('step-2').scrollIntoView({ behavior: 'smooth' });
                        return;
                    } else {
                         const step2Error = document.getElementById('step2Error');
                         if(step2Error) step2Error.classList.add('d-none');
                    }

                    // 3. Validate Payments
                    const ok = evaluatePaymentsSum();
                    if (!ok) {
                        if (paymentsErrorEl) {
                            paymentsErrorEl.classList.remove('d-none');
                            paymentsErrorEl.textContent = 'La suma de los montos de pago no coincide con el total.';
                        }
                        return;
                    }

                    this.submit();
                });
            }
            

            // initial step

        })();
    </script>
@endsection
