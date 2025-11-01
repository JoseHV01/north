const inputs = document.querySelectorAll('.form-control');

const expressions = {
    Name: /^[a-zA-Z\s]{6,}$/,
    Rif: /^[A-Z]{1}\-[0-9]{7,8}\-[0-9]{1}&/,
    Email: /^[a-zA-Z0-9.-_+@]{5,}\@[a-z-A-Z0-9]{3,}\.[a-zA-Z]{2,}$/,
    Phone: /^[0-9]{10,11}$/,
    Direction:/.{10,}/
};

const validateForm= (field)=>{
    
    switch (field.target.name) {
        case 'name':
            validateInput(
                expressions.Name,
                field.target,
                document.querySelector('#inputCompanyName'),
                document.querySelector('#errorName')
            );        
        break;
        case 'rif':
            validateInput(
                expressions.Rif,
                field.target,
                document.querySelector('#inputRif'),
                document.querySelector('#errorRif')
            );          
        break;
        case 'email':
            validateInput(
                expressions.Email,
                field.target,
                document.querySelector('#inputEmail'),
                document.querySelector('#errorEmail')
            );
        break;
        case 'phone':
            validateInput(
                expressions.Phone,
                field.target,
                document.querySelector('#inputPhone'),
                document.querySelector('#errorPhone')
            );
        break;
        case 'direction':
            validateInput(
                expressions.Direction,
                field.target,
                document.querySelector('#inputDirection'),
                document.querySelector('#errorDirection')
            );
        break;
    }
};

const validateInput= (expression,valueInput,classInput,idP)=>{
    if (expression.test(valueInput.value)) {
        classInput.classList.add('is-valid');
        classInput.classList.remove('is-invalid');
        idP.classList.remove('d-block');
        idP.classList.add('d-none');
    } else {
        classInput.classList.add('is-invalid');
        classInput.classList.remove('is-valid');
        idP.classList.add('d-block');
        idP.classList.remove('d-none');
    }
};


inputs.forEach((input)=>{
    input.addEventListener('keyup', validateForm);
    input.addEventListener('blur', validateForm);
});