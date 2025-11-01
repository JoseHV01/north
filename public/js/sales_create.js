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
        headers: { "X-CSRF-TOKEN": metaToken }
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
            resultsProducts.length > 0
                ? `Por ${searchParamet}:`
                : "Busqueda sin resultados";
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
        containerBaseCopy.textContent = `Bs. 0`;
        IVA.textContent = 0;
        TOTAL.textContent = 0;
        containerSale.classList.remove("d-none");
        const { id, description, price, existence } = product;
        const totalPriceProduct = (price * ganance) / 100 + price;
        const tr = document.createElement("tr");
        tr.id = `fila${id}`;
        tr.innerHTML = `
            <td>
                <input id="quantity${id}" name="quantity[]" type="number" class="form-control" min="1" max="${existence}" value="1" style="min-width: 4rem;" required>
                <input name="product_id[]" class="d-none" type="number" value="${id}">
            </td>
            <td style="min-width: 5rem;">${description}</td>
            <td style="min-width: 5rem;">Bs. ${totalPriceProduct.toFixed(
                2
            )}</td>
            <td style="min-width: 5rem;">Bs.
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
    }

    window.removeProductOfList = function(idProduct) {
        if (productsSale.length == 1) {
            containerSale.classList.add("d-none");
        }
        productsSale = productsSale.filter(id => id !== idProduct);
        const fila = document.getElementById(`fila${idProduct}`);
        if (fila) fila.remove();
        toggleProductBtn(idProduct, false);
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
        containerBaseCopy.textContent = `Bs. ${totalBase.toFixed(2)}`;
        
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
                    containerIgtfCopy.textContent = `Bs. ${totalWithIva.toFixed(2)}`;
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

        // Validar montos si hay más de una opción de pago seleccionada
        console.log(document.querySelectorAll(
            ".shape-payment-checkbox:checked"
        ).length);
        
        if (document.querySelectorAll(
            ".shape-payment-checkbox:checked"
        ).length > 1) {
            console.log('evaluando montos');
            
            let sumBs = 0;
            document.querySelectorAll('#shapePaymentAmounts input').forEach(input => {
                const value = parseFloat(input.value) || 0;
                const label = input.closest('.form-group').querySelector('label').textContent.toLowerCase();
                if (label.includes('divisas') || label.includes('dolares') || label.includes('usd')) {
                    sumBs += value * dollarRate;
                } else {
                    sumBs += value;
                }
            });
            console.log(Math.abs(sumBs - total.value));
            
            if (Math.abs(sumBs - total.value) > 0.01) {
                console.log('Suma de montos no coincide');
                
                document.getElementById("btn_save").disabled = true;
                document.getElementById("container_error").classList.remove("d-none");
                
            } else {
                console.log('Suma de montos coincide');
                 document.getElementById("container_error").classList = "d-none";
                document.getElementById("btn_save").disabled = false;
            }
        }
    }

    function evaluateValueSelects() {
        optionSelected = document.querySelectorAll(
            ".shape-payment-checkbox:checked"
        ).length;
       
        if (
            optionSelected > 0 &&
            parseInt(optionCustomer.value) > 0 &&
            optionStates.value != 0
        ) {
            selectCategory.disabled = false;
            inputSearchProduct.disabled = false;
            btnSearch.disabled = false;
            console.log('habilitado');
        } else {
            selectCategory.disabled = true;
            inputSearchProduct.disabled = true;
            btnSearch.disabled = true;
            console.log('deshabilitado');
        }
        caculateTotalSale();
    }
    window.evaluateValueSelects = evaluateValueSelects;

    function updateShapePaymentInputs() {
        const checked = Array.from(
            document.querySelectorAll(".shape-payment-checkbox:checked")
        );
        const container = document.getElementById("shapePaymentAmounts");
        const hiddenInput = document.getElementById("shapePaymentHidden");
        container.innerHTML = "";
        hiddenInput.value = checked.map(cb => cb.value).join(",");
        if (checked.length > 1) {
            container.classList = "mt-4 mb-5 row";
            checked.forEach(cb => {
                const paymentName =
                    shapesPayments.find(sp => sp.id == cb.value)?.name ||
                    cb.parentNode.textContent.trim();
                const inputDiv = document.createElement("div");
                inputDiv.className = "col-12 col-md-4";
                inputDiv.innerHTML = `
					<div class="form-group">
						<label class="form-label">${paymentName} - Monto</label>
						<input type="number" name="amounts[${cb.value}]" class="form-control" min="1" required onkeyup="evaluateValueSelects()">
					</div>`;
                container.appendChild(inputDiv);
            });
        } else {
            container.classList = "d-none";
            checked.forEach(cb => {
                const paymentName =
                    shapesPayments.find(sp => sp.id == cb.value)?.name ||
                    cb.parentNode.textContent.trim();
                const inputDiv = document.createElement("div");
                inputDiv.className = "col-12 col-md-4";
                inputDiv.innerHTML = `
					<div class="form-group">
						<label class="form-label">${paymentName} - Monto</label>
						<input type="number" name="amounts[${cb.value}]" id="inputTotal" class="form-control" min="1" required value="${TOTAL.textContent}" readonly>
					</div>`;
                container.appendChild(inputDiv);
            });
            
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".shape-payment-checkbox").forEach(cb => {
            cb.addEventListener("change", updateShapePaymentInputs);
        });
    });
})();
