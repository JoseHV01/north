const inputs=document.querySelectorAll('.modal-body input');

const expressions={
    Name:/^[a-zA-Z\s]{5,50}$/
};

const validateForm=(field)=>{
    switch (field.target.id) {
        case 'inputName':
            validateInput(
                expressions.Name,
                field.target,
                $('.modal-body #inputName'),
                $('.modal-body #messageAggName')
            )
        break;
    
        case 'inputNameEdit':
            validateInput(
                expressions.Name,
                field.target,
                $('.modal-body #inputNameEdit'),
                $('.modal-body #messageEditName')
            )
        break;
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

inputs.forEach((input)=>{
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
                    $('#bodyModalEdit input'),
                    $('#bodyModalEdit p.text-danger')
                )
            break;
        }
    });
});