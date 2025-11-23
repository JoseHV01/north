document.addEventListener('DOMContentLoaded', function() {
    const expressions = {
        document: /^[0-9]{8,12}$/,
        businessName: /.{4,}/,
        email: /^[a-zA-Z0-9.-_+@]{5,}\@[a-z-A-Z0-9]{3,}\.[a-zA-Z]{2,}$/,
        phone: /^[0-9]{10,12}$/,
        direction: /.{10,}/
    };

    const validateInput = (input) => {
        const type = input.dataset.validate;
        if (!type || !expressions[type]) return;

        const value = input.value.trim();
        const regex = expressions[type];
        
        // Handle optional fields
        const isOptional = input.dataset.optional === 'true';
        if (isOptional && value === '') {
             clearValidation(input);
             return;
        }

        const isValid = regex.test(value);
        
        // Find the error message element. 
        // We look for the specific class .validation-msg within the same form-group parent
        const formGroup = input.closest('.form-group');
        const errorMsg = formGroup ? formGroup.querySelector('.validation-msg') : null;

        if (isValid) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            if(errorMsg) {
                errorMsg.classList.remove('d-block');
                errorMsg.classList.add('d-none');
            }
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            if(errorMsg) {
                errorMsg.classList.remove('d-none');
                errorMsg.classList.add('d-block');
            }
        }
    };

    const clearValidation = (input) => {
        input.classList.remove('is-valid', 'is-invalid');
        const formGroup = input.closest('.form-group');
        const errorMsg = formGroup ? formGroup.querySelector('.validation-msg') : null;
        
        if(errorMsg) {
            errorMsg.classList.remove('d-block');
            errorMsg.classList.add('d-none');
        }
    };

    // Attach events using delegation to handle dynamic content if necessary, 
    // though direct attachment works for server-rendered modals.
    // We'll use direct attachment for simplicity but ensure we cover all inputs.
    const attachListeners = () => {
        document.querySelectorAll('input[data-validate]').forEach(input => {
            // Remove old listeners to avoid duplicates if re-initialized (though not expected here)
            input.removeEventListener('keyup', handleEvent);
            input.removeEventListener('blur', handleEvent);
            
            input.addEventListener('keyup', handleEvent);
            input.addEventListener('blur', handleEvent);
        });
    };

    const handleEvent = (e) => {
        validateInput(e.target);
    };

    attachListeners();

    // Clear validation when modal is closed
    // Using jQuery for Bootstrap 4 modal events as per the project's likely stack
    if (typeof $ !== 'undefined') {
        $('.modal').on('hidden.bs.modal', function () {
            const inputs = this.querySelectorAll('input[data-validate]');
            inputs.forEach(input => clearValidation(input));
            // Optional: reset form
            const form = this.querySelector('form');
            if(form) form.reset();
        });
        
        // Also clear when clicking the "Edit" button if it was manually handled before
        // But the hidden.bs.modal event handles the closing/resetting better.
    }
});
