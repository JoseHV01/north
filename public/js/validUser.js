const inputs=document.querySelectorAll('#modalAgg input');

const expressions={
    Name:/^[a-zA-Z]{5,50}$/,
    Email:/^[A-Za-z0-9.,-_@+]{5,}\@[a-zA-Z]{3,}\.[a-zA-Z0-9]{2,}$/,
    Password:/^(?!.*\s).{8,}$/,
    Ask:/^.{5,}$/
};

const validateForm=(field)=>{
    switch (field.target.id) {
        case 'inputName':
            validateInput(
                expressions.Name,
                field.target,
                $('#modalAgg #inputName'),
                $('#messageName')
            )
        break;
        case 'inputEmail':
            validateInput(
                expressions.Email,
                field.target,
                $('#modalAgg #inputEmail'),
                $('#messageEmail')
            )
        break;
        case 'inputPassword':
            validateInput(
                expressions.Password,
                field.target,
                $('#modalAgg #inputPassword'),
                $('#messagePassword')
            )
            validPassword();
        break;
        case 'inputPasswordRepeat':

            validPassword();
        break;
        case 'inputAsk_1':
            validateInput(
                expressions.Ask,
                field.target,
                $('#modalAgg #inputAsk_1'),
                $('#messageAsk_n1')
            )
        break;
        case 'inputAsk_2':
            validateInput(
                expressions.Ask,
                field.target,
                $('#modalAgg #inputAsk_2'),
                $('#messageAsk_n2')
            )
        break;
        case 'inputAsk_3':
            validateInput(
                expressions.Ask,
                field.target,
                $('#modalAgg #inputAsk_3'),
                $('#messageAsk_n3')
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

const validPassword=()=>{
    const condition = $('#inputPassword').val() === $('#inputPasswordRepeat').val();

    if (condition) {
        $('#modalAgg #inputPasswordRepeat').addClass('is-valid');
        $('#modalAgg #inputPasswordRepeat').removeClass('is-invalid');
        $('#modalAgg #messagePasswordRepeat').removeClass('d-block');
        $('#modalAgg #messagePasswordRepeat').addClass('d-none');
    } else {
        console.log('si')
        $('#modalAgg #inputPasswordRepeat').addClass('is-invalid');
        $('#modalAgg #inputPasswordRepeat').removeClass('is-valid');
        $('#modalAgg #messagePasswordRepeat').addClass('d-block');
        $('#modalAgg #messagePasswordRepeat').removeClass('d-none');
    }
};

inputs.forEach((input)=>{
    input.addEventListener('keyup', validateForm);
    input.addEventListener('blur', validateForm);
});