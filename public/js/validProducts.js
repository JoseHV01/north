const inputs = document.querySelectorAll('.form-group .form-control');

const expressions={
    Description:/^[a-zA-Z0-9\s]{5,150}$/,
    ExistenceMinime:/^[0-9]+$/
};
const validateForm=(field)=>{
    switch (field.target.id) {
        case 'inputEditDescription':
            validateInput(
                expressions.Description,
                field.target,
                $('.modal-body #inputEditDescription'),
                $('.modal-body #messageDescriptionEdit')
            )
        break;
        case 'inputEditExistenceMinime':
            validateInput(
                expressions.ExistenceMinime,
                field.target,
                $('.modal-body #inputEditExistenceMinime'),
                $('.modal-body #messageExistenceEdit')
            )
            inputOptional(
                $('.modal-body #inputEditExistenceMinime'),
                $('.modal-body #messageExistenceEdit'),
                field.target.value,
            );
        break;
        case 'inputAggDescription':
            validateInput(
                expressions.Description,
                field.target,
                $('.modal-body #inputAggDescription'),
                $('.modal-body #messageDescriptionAgg')
            )
        break;
        case 'inputAggExistenceMinime':
            validateInput(
                expressions.ExistenceMinime,
                field.target,
                $('.modal-body #inputAggExistenceMinime'),
                $('.modal-body #messageExistenceAgg')
            );
            inputOptional(
                $('.modal-body #inputAggExistenceMinime'),
                $('.modal-body #messageExistenceAgg'),
                field.target.value,
            );
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

inputs.forEach((input)=>{
    input.addEventListener('keyup', validateForm);
    input.addEventListener('blur', validateForm);
});

//limpiar modal

const buttons=document.querySelectorAll('button.btn-warning.mx-1');


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