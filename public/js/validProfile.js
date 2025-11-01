const inputs= document.querySelectorAll('.card-body .form-control');

const expressions = {
    Email:/^[a-zA-Z0-9.-_+@]{5,}\@[a-z-A-Z0-9]{3,}\.[a-zA-Z]{2,}$/,
    Password:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?!.*\s).{8,}$/,
    Ask:/^.{5,}$/
};

const validForm=(field)=>{
    switch (field.target.name) {
        case 'email':
            validateInput(
                expressions.Email,
                field.target,
                document.querySelector('#errorEmail'),
                document.querySelector('.card-body .mb-2 #inputEmail')
            );
        break;
        case 'new_password':
            validateInput(
                expressions.Password,
                field.target,
                document.querySelector('#errorPassword'),
                document.querySelector('.card-body .mb-2 #password_new')
            );
            validPassword();
        break;
        case 'repeat_new_password':
            validPassword();
        break;
    }
}

const validateInput=(expression,valueInput,idMenssage,idInput)=>{
    if (expression.test(valueInput.value)) {
        idMenssage.classList.add('d-none');
        idMenssage.classList.remove('d-block');
        idInput.classList.add('is-valid');
        idInput.classList.remove('is-invalid');
    } else {
        idMenssage.classList.remove('d-none');
        idMenssage.classList.add('d-block');
        idInput.classList.remove('is-valid');
        idInput.classList.add('is-invalid');
    }
};

const validPassword = () => {//validar contrasenas
	const codition = document.querySelector('.card-body .mb-2 #password_new').value !== document.querySelector('.card-body .mb-2 #password_new_two').value;

	if(codition){
		document.querySelector('.card-body .mb-2 #password_new_two').classList.add('is-invalid');
        document.querySelector('.card-body .mb-2 #password_new_two').classList.remove('is-valid');
        document.querySelector('#errorTwoPassword').classList.add('d-block');
        document.querySelector('#errorTwoPassword').classList.remove('d-none');
	} else {
        document.querySelector('.card-body .mb-2 #password_new_two').classList.remove('is-invalid');
        document.querySelector('.card-body .mb-2 #password_new_two').classList.add('is-valid');
        document.querySelector('#errorTwoPassword').classList.remove('d-block');
        document.querySelector('#errorTwoPassword').classList.add('d-none');
    }
}

inputs.forEach((input)=>{
    input.addEventListener('keyup',validForm);
    input.addEventListener('blur',validForm);
});