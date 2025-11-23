@extends('layouts.app')
@section('title', 'Ventas')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ url('sales') }}" class="fw-semibold mb-4 h4"style="color: #5D87FF">Ventas</a>

            <form id="formSales" action="{{ url('sales') }}" method="POST">
                {{ csrf_field() }}
                <!-- STEP 1: Cliente -->
                <div id="step-1">
                    <div class="row mt-4 gap-4 gap-md-0">
                        <div class="form-group col-12  mb-4 mb-lg-0">
                            <label for="selectCustomer" class="form-label">Cliente</label>
                            <select name="customer" class="form-control" id="selectCustomer" onchange="evaluateValueSelects()"
                                required>
                                <option value="0"></option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->document_type }} {{ $customer->document }}
                                        &nbsp;&nbsp; {{ $customer->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input id="total_sales" type="hidden" name="totalSales" value="0">
                    </div>
                    <div id="step1Error" class="alert alert-danger d-none mt-3"></div>
                </div>
                <!-- STEP 2: Productos -->
                <div id="step-2">
                    <div class="my-4 row">
                        <div class="col-12 col-md-6 form-group mt-4 mt-md-0">
                            <label class="form-label">Categoria</label>
                            <select class="form-control" id="selectCategory" disabled>
                                <option value="">- Seleccione -</option>
                                @foreach ($categorys as $category)
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

                        </div>
                    </div>
                </div>
                <!-- STEP 3: Pagos y Resumen -->
                <div id="step-3">
                    <div class="row mt-4">
                        <div class="form-group col-12 col-md-12 mb-4 mb-lg-0">
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
                                                <input type="checkbox" class="form-check-input me-2 shape-payment-checkbox"
                                                    name="shape_payment[]" value="{{ $shape_payment->id }}"
                                                    onchange="evaluateValueSelects()">
                                                {{ $shape_payment->name }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <small class="text-muted">Selecciona una o más formas de pago.</small>
                            <input type="hidden" name="shape_payment_input" id="shapePaymentHidden">
                        </div>
                    </div>
                    <div id="shapePaymentAmounts" class="mt-4 mb-5 row d-none"></div>

                    <div class="mt-4">
                        <h6>Resumen de Productos</h6>
                        <div class="table-responsive">
                            <table class="table">
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
                                            <span class="pt-2" style="font-weight: normal;">(Tasa BCV
                                                {{ Cache::get('bcv') }})</span>
                                        </th>
                                        <td id="totalIgtf" class="text-center"></td>
                                    </tr>

                                    <tr>
                                        <th>Total</th>
                                        <td id="total" class="text-center"></td>
                                    </tr>
                                    <tr id="container_error" class="d-none">
                                        <th colspan="2" class="text-danger text-sm">La suma de los montos no coincide
                                            con el total de la venta.</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <input type="hidden" name="totalSale" id="totalSale">
                    <input type="hidden" name="taxBase" id="taxBase">
                    <div class="d-flex justify-content-end align-items-center mt-4 gap-3">
                        <div>
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
        document.addEventListener('DOMContentLoaded', function() {
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
        // Ensure dollarRate is a number
        const dollarRate = parseFloat(@json($rates->firstWhere('name', 'BCV')->value ?? 0)) || 0;
        const shapesPayments = @json($shapes_payments);
    </script>
    <script>
        (() => {
            // Variables encapsuladas
            let optionSelected = document.querySelectorAll(".shape-payment-checkbox:checked").length;
            const optionSelectedCheck = document.querySelectorAll(".shape-payment-checkbox");
            const optionCustomer = document.getElementById("selectCustomer");
            const optionStates = document.getElementById("selectStates");
            const selectCategory = document.getElementById("selectCategory");
            const inputSearchProduct = document.getElementById("search_product");
            const btnSearch = document.getElementById("btn_search");
            const groupIgtf = document.getElementById("container_igtf");
            const containerSearch = document.getElementById("container_search");
            const containerIgtf = document.getElementById("igtf");
            const containerCategory = document.getElementById(
                "container_search_category"
            );
            const containerResult = document.getElementById("container_result");
            const containerSale = document.getElementById("container_sale");
            const containerBase = document.getElementById("base");
            const containerBaseCopy = document.getElementById("base_copy");
            const containerIgtfCopy = document.getElementById("igtf_copy");
            const containerIva = document.getElementById("iva");
            const bodyTable = document.getElementById("bodyTableResult");
            const TOTAL = document.getElementById("total");
            const IVA = document.getElementById("totalIva");
            const IGTF = document.getElementById("totalIgtf");
            let totalBase = 0;
            let listProducts = [],
                iva = 0,
                igtf = 0,
                ganance = 0,
                productsSale = [],
                resultsProducts = [];
            const metaToken = document.querySelector('meta[name="csrf-token"]').content;
            const headers = {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": metaToken
                }
            };

            // Fetch productos y tasas
            fetch("search", headers)
                .then(response =>
                    response.ok ? response.json() : Promise.reject(response.status)
                )
                .then(data => {
                    listProducts = data[0];
                    iva = data[1][0].value;
                    ganance = data[1][1].value;
                    igtf = data[1][2].value;
                })
                .catch(err => console.error("ERROR: ", err));

            // Event listeners
            btnSearch.addEventListener("click", searchProducts);
            optionSelectedCheck.forEach(checkbox => {
                checkbox.addEventListener("change", () => handleShapeChange(checkbox));
            });
            selectCategory.addEventListener("change", () => {
                clearSearch();
                resultsProducts = listProducts.filter(
                    p => p.id_category == selectCategory.value
                );
                visibleContainer("Categoria");
            });
            document.addEventListener("keydown", event => {
                if (event.key === "Enter") {
                    searchProducts();
                    event.preventDefault();
                }
            });

            // Funciones
            function handleShapeChange(checkbox) {
                if (checkbox.value == 2) {
                    groupIgtf.classList.remove("d-none");
                    containerIgtf.textContent = `${igtf} %`;
                    caculateTotalSale();
                    evaluateValueSelects();
                } else {
                    groupIgtf.classList.add("d-none");
                    containerIgtf.textContent = "";
                    IGTF.textContent = "";
                }
            }

            function searchProducts() {
                clearSearch();
                const val = inputSearchProduct.value.trim().toLowerCase();
                resultsProducts = listProducts.filter(p =>
                    p.description.toLowerCase().includes(val)
                );
                visibleContainer("Descripcion");
            }

            function clearSearch(clearAll = false) {
                if (clearAll) {
                    inputSearchProduct.value = "";
                    selectCategory.value = "";
                }
                resultsProducts = [];
                containerResult.innerHTML = "";
                containerSearch.classList.add("d-none");
            }

            function cancelSale() {
                productsSale.forEach(id => {
                    const fila = document.getElementById(`fila${id}`);
                    if (fila) fila.remove();
                    toggleProductBtn(id, false);
                });
                clearSearch(true);
                productsSale = [];
                bodyTable.innerHTML = "";
                containerSale.classList.add("d-none");
                containerCategory.classList.add("d-none");
            }

            function visibleContainer(searchParamet) {
                containerCategory.classList.remove("d-none");
                containerSearch.classList.remove("d-none");
                document.getElementById("paramet").textContent =
                    resultsProducts.length > 0 ?
                    `Por ${searchParamet}:` :
                    "Busqueda sin resultados";
                if (resultsProducts.length > 0) {
                    const frag = document.createDocumentFragment();
                    resultsProducts.forEach(p => {
                        const btn = document.createElement("button");
                        btn.id = p.id;
                        btn.type = "button";
                        btn.className = "btn btn-outline-secondary mb-2 me-1";
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
                    btn.classList.remove("btn-outline-secondary");
                    btn.classList.add("btn-success");
                    btn.disabled = true;
                } else {
                    btn.classList.add("btn-outline-secondary");
                    btn.classList.remove("btn-success");
                    btn.disabled = false;
                }
            }

            function toggleProductBtn(id, selected) {
                const btn = document.getElementById(id);
                if (btn) {
                    btn.classList.toggle("btn-success", selected);
                    btn.classList.toggle("btn-outline-secondary", !selected);
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
                productsSale.push(idProduct);
                const product = listProducts.find(p => p.id == idProduct);
                if (!product) return;
                containerIva.textContent = `${iva} %`;
                containerBase.textContent = 0;
                containerBaseCopy.textContent = `$ 0`;
                IVA.textContent = 0;
                TOTAL.textContent = 0;
                containerSale.classList.remove("d-none");
                const {
                    id,
                    description,
                    price,
                    existence
                } = product;
                const totalPriceProduct = (price * ganance) / 100 + price;
                const tr = document.createElement("tr");
                tr.id = `fila${id}`;
                tr.innerHTML = `
            <td>
                <input id="quantity${id}" name="quantity[]" type="number" class="form-control" min="0.5" step="0.01" max="${existence}" value="1" style="min-width: 4rem;" required>
                <input name="product_id[]" class="d-none" type="number" value="${id}">
            </td>
            <td style="min-width: 5rem;">${description}</td>
            <td style="min-width: 5rem;">$ ${totalPriceProduct.toFixed(
                2
            )}</td>
            <td style="min-width: 5rem;">$ 
                <span id="totalProduct${id}" name="total">0</span>
            </td>
            <td style="min-width: 3rem;">
                <button type="button" class="btn btn-danger m-1" data-toggle="tooltip" title="Descartar" onclick="removeProductOfList(${id})">
                    <span><i class="ti ti-trash"></i></span>
                </button>
            </td>`;
                bodyTable.appendChild(tr);
                document
                    .getElementById(`quantity${id}`)
                    .addEventListener("input", () =>
                        quantityProduct(id, totalPriceProduct.toFixed(2))
                    );
                quantityProduct(id, totalPriceProduct.toFixed(2));
                updateStep2NextState();
            }

            function updateStep2NextState() {
                const step2NextEl = document.getElementById('step2Next');
                if(step2NextEl) step2NextEl.disabled = productsSale.length === 0;
            }

            window.removeProductOfList = function(idProduct) {
                if (productsSale.length == 1) {
                    containerSale.classList.add("d-none");
                }
                productsSale = productsSale.filter(id => id !== idProduct);
                const fila = document.getElementById(`fila${idProduct}`);
                if (fila) fila.remove();
                toggleProductBtn(idProduct, false);
                updateStep2NextState();
            };

            function quantityProduct(idProduct, priceProduct) {
                const containerTotalProduct = document.getElementsByName("total");
                const quantity =
                    parseFloat(document.getElementById(`quantity${idProduct}`).value) ||
                    0;
                const totalForProduct = quantity * priceProduct;
                const total = document.getElementById(`totalProduct${idProduct}`);
                total.textContent =
                    totalForProduct > 0 ? totalForProduct.toFixed(2) : "0";
                totalBase = Array.from(containerTotalProduct).reduce(
                    (acc, el) => acc + parseFloat(el.textContent),
                    0
                );
                containerBase.textContent = totalBase.toFixed(2);
                containerBaseCopy.textContent = `$ ${totalBase.toFixed(2)}`;

                caculateTotalSale();
            }

            function caculateTotalSale() {
                const totalIva = (totalBase * iva) / 100;
                IVA.textContent = totalIva.toFixed(2);
                const totalWithIva = totalIva + totalBase;
                let total = document.getElementById("totalSale");
                document.getElementById("taxBase").value = totalBase;
                let quantityChecked = 0;
                optionSelectedCheck.forEach(checkbox => {
                    if (checkbox.value == 2) {
                        if (checkbox.checked) {
                            const totalIgtf = (totalWithIva * igtf) / 100;
                            const totalSale = totalWithIva + totalIgtf;
                            containerIgtfCopy.textContent = `$ ${totalWithIva.toFixed(2)}`;
                            IGTF.textContent = `${totalIgtf.toFixed(2)}`;
                            TOTAL.textContent = `${totalSale.toFixed(2)}`;
                            total.value = totalSale;
                            return;
                        }
                    } else {
                        TOTAL.textContent = `${totalWithIva.toFixed(2)}`;
                        total.value = totalWithIva;
                    }
                    if (checkbox.checked) {
                        quantityChecked++;
                    }
                });

                if (quantityChecked == 1) {
                    let inputTotal = document.getElementById("inputTotal");
                    if (inputTotal) {
                        inputTotal.value = TOTAL.textContent;
                    }
                }

                // Delegate payments validation to USD-based evaluator
                try{ evaluatePaymentsSum(); }catch(e){ /* ignore */ }
                try{ calculatePaymentLogic(null); }catch(e){ /* ignore */ }
            }

            // Evaluate payments sum in USD: convert non-divisas amounts (entered in Bs) to USD using dollarRate
            function evaluatePaymentsSum(){
                const inputs = Array.from(document.querySelectorAll('#shapePaymentAmounts .payment-amount-input'));
                if(inputs.length === 0){
                    // nothing to validate, keep submit enabled state as is
                    return true;
                }
                // TOTAL is displayed as USD
                const totalText = (TOTAL && TOTAL.textContent) ? TOTAL.textContent.replace(/[^0-9\.\-]/g,'') : '0';
                const totalUSD = parseFloat(totalText) || 0;
                const rate = parseFloat(dollarRate) || 0;

                let sumUSD = 0;
                inputs.forEach(inp => {
                    const v = parseFloat(inp.value || 0) || 0;
                    const label = (inp.closest('.form-group')?.querySelector('label')?.textContent || '').toLowerCase();
                    // if label includes 'divisas' or 'dolares' or 'usd' we treat entered amount as USD
                    if(label.includes('divisas') || label.includes('dolares') || label.includes('usd')){
                        sumUSD += v;
                    } else {
                        // convert local currency (Bs) to USD
                        if(rate > 0){ sumUSD += v / rate; }
                        else { sumUSD += v; }
                    }
                });

                const ok = Math.abs(sumUSD - totalUSD) <= 0.01;
                if(!ok){
                    document.getElementById("btn_save").disabled = true;
                    document.getElementById("container_error").classList.remove("d-none");
                } else {
                    document.getElementById("container_error").classList.add("d-none");
                    document.getElementById("btn_save").disabled = false;
                }
                return ok;
            }

            // Compute and display suggestion: missing USD and equivalent in Bs when 'divisas' selected
            function computePaymentsSuggestion(){
                const suggestionEl = document.getElementById('paymentsSuggestion');
                if(!suggestionEl) return;

                const inputs = Array.from(document.querySelectorAll('#shapePaymentAmounts .payment-amount-input'));
                const hasDivisasInput = inputs.some(inp => {
                    const label = (inp.closest('.form-group')?.querySelector('label')?.textContent || '').toLowerCase();
                    return label.includes('divisas') || label.includes('dolares') || label.includes('usd');
                });

                const totalText = (TOTAL && TOTAL.textContent) ? TOTAL.textContent.replace(/[^0-9\.\-]/g,'') : '0';
                const totalUSD = parseFloat(totalText) || 0;
                const rate = parseFloat(dollarRate) || 0;

                if(hasDivisasInput){
                    // sum current divisas amounts (USD) and others converted to USD
                    let divisasUSD = 0; let othersUSD = 0;
                    inputs.forEach(inp => {
                        const v = parseFloat(inp.value || 0) || 0;
                        const label = (inp.closest('.form-group')?.querySelector('label')?.textContent || '').toLowerCase();
                        if(label.includes('divisas') || label.includes('dolares') || label.includes('usd')){
                            divisasUSD += v;
                        } else {
                            if(rate > 0) othersUSD += v / rate; else othersUSD += v;
                        }
                    });
                    const currentSum = divisasUSD + othersUSD;
                    const missingUSD = Math.max(0, (totalUSD - currentSum));
                    const missingBs = rate > 0 ? (missingUSD * rate) : 0;
                    if(missingUSD <= 0.005){
                        suggestionEl.textContent = 'Montos completos — suma en dólares coincide con el total.';
                    } else {
                        suggestionEl.textContent = `Faltan ${missingUSD.toFixed(2)} USD (≈ ${missingBs.toFixed(2)} Bs). Ingresa ese monto en los otros métodos en bolívares.`;
                        // If there are non-divisas inputs that are empty (or 0), pre-fill the first one with the missing Bs
                        if(rate > 0){
                            const nonDivInputs = inputs.filter(inp => {
                                const label = (inp.closest('.form-group')?.querySelector('label')?.textContent || '').toLowerCase();
                                return !(label.includes('divisas') || label.includes('dolares') || label.includes('usd'));
                            });
                            if(nonDivInputs.length > 0){
                                // try to find first input with empty or zero value
                                let target = nonDivInputs.find(i => parseFloat(i.value||0) <= 0);
                                if(!target) target = nonDivInputs[0];
                                // only overwrite if it's empty or zero to avoid clobbering user input
                                if(target && parseFloat(target.value||0) <= 0){
                                    target.value = missingBs.toFixed(2);
                                    // trigger evaluations after autofill
                                    evaluatePaymentsSum();
                                    // re-run suggestion so text updates if needed
                                    // (avoid recursion by not calling computePaymentsSuggestion here)
                                }
                            }
                        }
                    }
                } else {
                    // No divisas selected: show total in bolivares suggestion
                    const totalBs = rate > 0 ? (totalUSD * rate) : totalUSD;
                    suggestionEl.textContent = `Total: ${totalUSD.toFixed(2)} USD ≈ ${totalBs.toFixed(2)} Bs.`;
                }
            }

            function evaluateValueSelects() {
                optionSelected = document.querySelectorAll(
                    ".shape-payment-checkbox:checked"
                ).length;

                // Safe checks: optionStates may not exist in this view (it's hidden),
                // so treat missing states as "ok" for enabling product search.
                const customerSelected = optionCustomer && parseInt(optionCustomer.value) > 0;
                const statesOk = !optionStates || optionStates.value != 0;

                // Enable product selection once a customer is selected (do not require payment check here)
                if (customerSelected && statesOk) {
                    selectCategory.disabled = false;
                    inputSearchProduct.disabled = false;
                    btnSearch.disabled = false;
                } else {
                    selectCategory.disabled = true;
                    inputSearchProduct.disabled = true;
                    btnSearch.disabled = true;
                }

                caculateTotalSale();
            }
            window.evaluateValueSelects = evaluateValueSelects;

            // --- Unified Form Validation on Submit ---
            const formSales = document.getElementById('formSales');
            if(formSales){
                formSales.addEventListener('submit', function(e){
                    e.preventDefault();
                    
                    // 1. Validate Customer
                    const customerSelected = optionCustomer && parseInt(optionCustomer.value) > 0;
                    if(!customerSelected){
                         const step1Error = document.getElementById('step1Error');
                         if(step1Error){
                            step1Error.classList.remove('d-none');
                            step1Error.textContent = 'Seleccione un cliente antes de continuar.';
                         }
                         document.getElementById('step-1').scrollIntoView({ behavior: 'smooth' });
                         return;
                    } else {
                         const step1Error = document.getElementById('step1Error');
                         if(step1Error) step1Error.classList.add('d-none');
                    }

                    // 2. Validate Products
                    const hasProducts = (productsSale && productsSale.length > 0) || (bodyTable && bodyTable.children.length > 0);
                    if(!hasProducts){
                        alert('Agrega al menos un producto antes de guardar.');
                        document.getElementById('step-2').scrollIntoView({ behavior: 'smooth' });
                        return;
                    }
                    // Validate quantities
                    let invalidProducts = [];
                    productsSale.forEach(id => {
                        const quantityEl = document.getElementById('quantity' + id);
                        if(quantityEl){
                            const qty = parseFloat(quantityEl.value) || 0;
                            if(qty < 0.5){
                                const productName = listProducts.find(p => p.id == id)?.description || ('Producto ' + id);
                                invalidProducts.push(productName + ' (cantidad: ' + qty + ')');
                                quantityEl.classList.add('is-invalid');
                            } else {
                                quantityEl.classList.remove('is-invalid');
                            }
                        }
                    });
                    if(invalidProducts.length > 0){
                        alert('Los siguientes productos tienen cantidad inválida (mínimo 0.5):\n\n' + invalidProducts.join('\n'));
                        return;
                    }

                    // 3. Validate Payments
                    const paymentsOk = evaluatePaymentsSum();
                    if(!paymentsOk){
                        document.getElementById('container_error').classList.remove('d-none');
                        document.getElementById('step-3').scrollIntoView({ behavior: 'smooth' });
                        return;
                    }

                    this.submit();
                });
            }

            function updateShapePaymentInputs() {
                const checked = Array.from(
                    document.querySelectorAll(".shape-payment-checkbox:checked")
                );
                const container = document.getElementById("shapePaymentAmounts");
                const hiddenInput = document.getElementById("shapePaymentHidden");
                const dropdownShapes = document.getElementById('dropdownShapes');

                container.innerHTML = "";
                hiddenInput.value = checked.map(cb => cb.value).join(",");

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
                    container.classList = "mt-4 mb-5 row";
                    checked.forEach(cb => {
                        const paymentName =
                            shapesPayments.find(sp => sp.id == cb.value)?.name ||
                            cb.parentNode.textContent.trim();
                        const safeName = String(paymentName).replace(/\"/g, '');
                        const inputDiv = document.createElement("div");
                        inputDiv.className = "col-12 col-md-4";
                        inputDiv.innerHTML = `
                    <div class="form-group">
                        <label class="form-label">${paymentName} - Monto</label>
                        <input type="number" name="amounts[${cb.value}]" data-shape-name="${safeName}" data-shape-id="${cb.value}" class="form-control payment-amount-input" min="0.01" step="0.01" required>
                    </div>`;
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
                    container.classList = "d-none";
                }
                // evaluate on change
                evaluatePaymentsSum();
            }

            function calculatePaymentLogic(triggerInput) {
                // Total is displayed in USD or Bs depending on context, but here we need USD total
                // The TOTAL element displays the final total (including IGTF if applicable).
                // We need to parse it.
                const totalText = (TOTAL && TOTAL.textContent) ? TOTAL.textContent.replace(/[^0-9\.\-]/g,'') : '0';
                const totalUSD = parseFloat(totalText) || 0;
                const rate = dollarRate; // Use the global dollarRate constant
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

            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".shape-payment-checkbox").forEach(cb => {
                    cb.addEventListener("change", updateShapePaymentInputs);
                });
            });
        })();
    </script>
@endsection
