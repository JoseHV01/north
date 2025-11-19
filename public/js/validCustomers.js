const inputsCustomer = document.querySelectorAll(".form-group input");

const expressionsCustomer = {
    documentCustomers: /^[0-9]{8,12}$/,
    BusinessName: /.{4,}/,
    Email: /^[a-zA-Z0-9.-_+@]{5,}\@[a-z-A-Z0-9]{3,}\.[a-zA-Z]{2,}$/,
    Phone: /^[0-9]{10,12}$/
};

const validateFormCustomer = field => {
    switch (field.target.id) {
        case "inputEditDocument":
            validateInput(
                expressions.documentCustomers,
                field.target,
                $(".modal-body #inputEditDocument"),
                $(".modal-body #documentEditMessage")
            );
            break;
        case "inputEditBusinessName":
            validateInput(
                expressions.BusinessName,
                field.target,
                $(".modal-body #inputEditBusinessName"),
                $(".modal-body #nameEditMessage")
            );
            break;
        case "inputEditEmail":
            validateInput(
                expressions.Email,
                field.target,
                $(".modal-body #inputEditEmail"),
                $(".modal-body #emailEditMessage")
            );
            inputOptional(
                $(".modal-body #inputEditEmail"),
                $(".modal-body #emailEditMessage"),
                field.target.value
            );
            break;
        case "inputEditPhone":
            validateInput(
                expressions.Phone,
                field.target,
                $(".modal-body #inputEditPhone"),
                $(".modal-body #phoneEditMessage")
            );
            inputOptional(
                $(".modal-body #inputEditPhone"),
                $(".modal-body #phoneEditMessage"),
                field.target.value
            );
            break;
        case "inputEditPhoneSecondary":
            validateInput(
                expressions.Phone,
                field.target,
                $(".modal-body #inputEditPhoneSecondary"),
                $(".modal-body #phoneSecondaryEditMessage")
            );
            inputOptional(
                $(".modal-body #inputEditPhoneSecondary"),
                $(".modal-body #phoneSecondaryEditMessage"),
                field.target.value
            );
            break;
        case "inputAggDocumentC":
            validateInput(
                expressions.documentCustomers,
                field.target,
                $("#inputAggDocumentC"),
                $("#documentAggMessageC")
            );
            break;
        case "inputAggBusinessNameC":
            validateInput(
                expressions.BusinessName,
                field.target,
                $("#inputAggBusinessNameC"),
                $("#nameAggMessageC")
            );
            break;
        case "inputAggEmailC":
            validateInput(
                expressions.Email,
                field.target,
                $("#inputAggEmailC"),
                $("#emailAggMessageC")
            );
            inputOptional(
                $("#inputAggEmailC"),
                $("#emailAggMessageC"),
                field.target.value
            );
            break;
        case "inputAggPhoneC":
            validateInput(
                expressions.Phone,
                field.target,
                $("#inputAggPhoneC"),
                $("#phoneAggMessageC")
            );
            inputOptional(
                $("#inputAggPhoneC"),
                $("#phoneAggMessageC"),
                field.target.value
            );
            break;
        case "inputAggPhoneSecondaryC":
            validateInput(
                expressions.Phone,
                field.target,
                $("#inputAggPhoneSecondaryC"),
                $("#phoneSecondaryAggMessageC")
            );
            inputOptional(
                $("#inputAggPhoneSecondaryC"),
                $("#phoneSecondaryAggMessageC"),
                field.target.value
            );
            break;
    }
};

const inputOptionalCustomer = (
    inputOptional,
    messageOptional,
    optionalValue
) => {
    if (optionalValue.trim() === "") {
        inputOptional.removeClass("is-invalid");
        messageOptional.removeClass("d-block");
        messageOptional.addClass("d-none");
    }
};

const validateInputCustomer = (expresion, inputValue, inputId, idMessage) => {
    if (expresion.test(inputValue.value)) {
        inputId.removeClass("is-invalid");
        inputId.addClass("is-valid");
        idMessage.removeClass("d-block");
        idMessage.addClass("d-none");
    } else {
        inputId.removeClass("is-valid");
        inputId.addClass("is-invalid");
        idMessage.removeClass("d-none");
        idMessage.addClass("d-block");
    }
};

inputsCustomer.forEach(input => {
    input.addEventListener("keyup", validateForm);
    input.addEventListener("blur", validateForm);
});

//limpiar modal

const buttonsCustomer = document.querySelectorAll("button.btn-warning.m-1");

const clearModalCustomer = (input = [], messageError = []) => {
    for (let index = 0; index < input.length; index++) {
        if (input[index].classList.contains("is-valid")) {
            input[index].classList.remove("is-valid");
        }
        if (input[index].classList.contains("is-invalid")) {
            input[index].classList.remove("is-invalid");
        }
        if (messageError[index].classList.contains("d-block")) {
            messageError[index].classList.remove("d-block");
            messageError[index].classList.add("d-none");
        }
    }
};

buttonsCustomer.forEach(btn => {
    btn.addEventListener("click", () => {
        switch (btn.title) {
            case "Editar":
                clearModal(
                    $("#bodyModalEdit input, #bodyModalEdit textarea"),
                    $("#bodyModalEdit p.text-danger")
                );
                break;
        }
    });
});
