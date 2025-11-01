// Validate form generic
$(document).ready(function() {
    $('#formEdit').validate();
});

$(document).ready(function() {
    $('#form').validate();
});

// Validate form new user
$(document).ready(function() {
    $('#formUser').validate({
        rules: {
            inputAnswer_2: {
                required: true
            },
        },
        messages: {
            inputAnswer_2: {
                required: "sirvio",
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});

// Validate form billis sales
$(document).ready(function() {
    $('#formSales').validate();
});

