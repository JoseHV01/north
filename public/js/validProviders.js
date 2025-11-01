const inputs=document.querySelectorAll('.form-group input');

const expressions = {
    documentCustomers: /^[0-9]{7,10}$/,
    BusinessName: /.{6,}/,
    Email: /^[a-zA-Z0-9.-_+@]{5,}\@[a-z-A-Z0-9]{3,}\.[a-zA-Z]{2,}$/,
    Phone: /^[0-9]{10,12}$/,
    Direction:/.{10,}/
};

const validateForm=(field)=>{
    switch (field.target.id){
        case 'inputEditDocument':
            validateInput(
                expressions.documentCustomers,
                field.target,
                $('.modal-body #inputEditDocument'),
                $('.modal-body #documentEditMesssage')
            )
        break;
        case 'inputEditBusinessName':
            validateInput(
                expressions.BusinessName,
                field.target,
                $('.modal-body #inputEditBusinessName'),
                $('.modal-body #nameEditMessage')
            )
        break;
        case 'inputEditEmail':
            validateInput(
                expressions.Email,
                field.target,
                $('.modal-body #inputEditEmail'),
                $('.modal-body #emailEditMessage')
            )
            inputOptional(
                $('.modal-body #inputEditEmail'),
                $('.modal-body #emailEditMessage'),
                field.target.value
            )
        break;
        case 'inputEditPhone':
            validateInput(
                expressions.Phone,
                field.target,
                $('.modal-body #inputEditPhone'),
                $('.modal-body #phoneEditMessage')
            )
            inputOptional(
                $('.modal-body #inputEditPhone'),
                $('.modal-body #phoneEditMessage'),
                field.target.value
            )
        break;
        case 'inputEditPhoneSecondary':
            validateInput(
                expressions.Phone,
                field.target,
                $('.modal-body #inputEditPhoneSecondary'),
                $('.modal-body #phoneSecondaryEditMessage')
            )
            inputOptional(
                $('.modal-body #inputEditPhoneSecondary'),
                $('.modal-body #phoneSecondaryEditMessage'),
                field.target.value
            )
        break;
        case 'editDirectionProvider':
            validateInput(
                expressions.Direction,
                field.target,
                $('.modal-body #editDirectionProvider'),
                $('.modal-body #editDirectionProviderMessage')
            )
        break;
        case 'inputAggDocument':
            validateInput(
                expressions.documentCustomers,
                field.target,
                $('#inputAggDocument'),
                $('#documentAggMessage')
            )
        break;
        case 'inputAggBusinessName':
            validateInput(
                expressions.BusinessName,
                field.target,
                $('#inputAggBusinessName'),
                $('#nameAggMessage')
            )
        break;
        case 'inputAggEmail':
            validateInput(
                expressions.Email,
                field.target,
                $('#inputAggEmail'),
                $('#emailAggMessage')
            )
            inputOptional(
                $('#inputAggEmail'),
                $('#emailAggMessage'),
                field.target.value
            )
        break;
        case 'inputAggPhone':
            validateInput(
                expressions.Phone,
                field.target,
                $('#inputAggPhone'),
                $('#phoneAggMessage')
            )
            inputOptional(
                $('#inputAggPhone'),
                $('#phoneAggMessage'),
                field.target.value
            )
        break;
        case 'inputAggPhoneSecundary':
            validateInput(
                expressions.Phone,
                field.target,
                $('#inputAggPhoneSecundary'),
                $('#phoneSecondaryAggMessage')
            )
            inputOptional(
                $('#inputAggPhoneSecundary'),
                $('#phoneSecondaryAggMessage'),
                field.target.value
            )
        break;
        case 'aggDirectionProvider':
            validateInput(
                expressions.Direction,
                field.target,
                $('#aggDirectionProvider'),
                $('#aggDirectionProviderMessage')
            )
        break;
    }
};

const inputOptional=(inputOptional, messageOptional, optionalValue)=>{
    if (optionalValue.trim() === '') {
        inputOptional.removeClass('is-invalid');       
        messageOptional.removeClass('d-block');
        messageOptional.addClass('d-none');     
    }
    
};

const validateInput = (expresion, inputValue, inputId, idMessage)=>{
    if (expresion.test(inputValue.value)){
        inputId.removeClass('is-invalid');
        inputId.addClass('is-valid');
        idMessage.removeClass('d-block');
        idMessage.addClass('d-none');
    }else{
        inputId.removeClass('is-valid');
        inputId.addClass('is-invalid');
        idMessage.removeClass('d-none');
        idMessage.addClass('d-block');
    }
};

inputs.forEach((input) => {
    input.addEventListener('keyup',validateForm);
    input.addEventListener('blur',validateForm);   
});

//limpiar modal

const buttons=document.querySelectorAll('button.btn-warning.m-1');


const clearModal=(input=[], messageError=[])=>{
    for (let index = 0; index < input.length; index++) {
        if (input[index].classList.contains('is-valid')) {
            input[index].classList.remove('is-valid');
        }
        if (input[index].classList.contains('is-invalid')) {
            input[index].classList.remove('is-invalid');
        }
        if (messageError[index].classList.contains('d-block')) {
            messageError[index].classList.remove('d-block');            
            messageError[index].classList.add('d-none');
        }
        
    }
};

buttons.forEach(btn=>{
    btn.addEventListener('click', ()=>{
        switch (btn.title) {        
            case 'Editar':
                clearModal(
                    $('#bodyModalEdit input, #bodyModalEdit textarea'),
                    $('#bodyModalEdit p.text-danger')
                )
            break;
        }
    });
});