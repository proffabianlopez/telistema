function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
        evt.preventDefault();
    }
}



$(document).ready(function () {
    $('.reload').click(function () {
        location.reload();
    });
    var laddaButton;
    // Regla personalizada para permitir solo letras en el campo
    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/i.test(value);
    }, "Solo se permiten letras en este campo.");


    $("#change-insertuser-form").validate({
        rules: {
            name_user: {
                required: true,
                minlength: 3,
                maxlength: 20,
                lettersonly: true
            },
            phone_user: {
                required: true,
                number: true,
                min: 99999999999,
                max: 999999999999
            },
            surname_user: {
                required: true,
                minlength: 3,
                maxlength: 20,
                lettersonly: true
            },
            mail: {
                required: true,
                maxlength: 100,
                minlength: 11,
                email: true
            },
        },
        messages: {
            name_user: {
                required: "Este campo es obligatorio.",
                minlength: "Por favor, ingrese al menos 3 caracteres.",
                minlength: "Por favor, ingrese un maximo de 20 caracteres.",
                lettersonly: "Solo se permite letras"
            },
            surname_user: {
                required: "Este campo es obligatorio.",
                minlength: "Por favor, ingrese al menos 3 caracteres.",
                maxlength: "Por favor, ingrese un maximo de 20 caracteres.",
                lettersonly: "Solo se permite letras"
            },
            mail: {
                required: "Este campo es obligatorio.",
                minlength: "Ingrese un email valido",
                maxlength: "Por favor, ingrese un maximo de 100 caracteres.",
                email: "Ingrese un email valido"
            },
            phone_user: {
                required: "Por favor, ingrese un número de teléfono.",
                number: "Por favor, ingrese un número válido.",
                min: "Formato invalido, ingrese el formato 5491122222333",
                max: "Formato invalido, ingrese el formato 5491122222333"
            },
        }
    });

    $('#change-insertuser-form').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        if (!$("#change-insertuser-form").valid()) {
        return; // Salir si el formulario no es válido
    }

        var laddaButton = Ladda.create(document.querySelector('.ladda-button'));
        laddaButton.start();
        $.ajax({
            type: 'POST',
            url: 'usersController.php?token='+token+'&action=add_user', // La URL de tu archivo PHP
            data: formData,
            dataType: 'json',
            success: function (response) {
                laddaButton.stop();
                var messageContainer = $('#response-message');
                if (response.status === 'success') {
                    $('#myModal6').modal('hide'); // Cierra el modal
                    setTimeout(function () {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: 'slideDown',
                            timeOut: 4000,
                            onHidden: function () {
                                location.reload();
                            }
                        };
                        toastr.success(response.message, 'ÉXITO');
                    });
                } else {
                    messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function (xhr, status, error) {
                laddaButton.stop();
                console.log(xhr.responseText);
                $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX: ' + error + '</div>');
            }
        });
    });

  // Validación del formulario
  $("#change-edituser-form").validate({
    rules: {
        name_user: {
            required: true,
            minlength: 3,
            maxlength: 20,
            lettersonly: true
        },
        phone_user: {
            required: true,
            number: true,
            min: 99999999999,
            max: 999999999999
        },
        surname_user: {
            required: true,
            minlength: 3,
            maxlength: 20,
            lettersonly: true
        },
        max: {
            required: true,
            maxlength: 4
        }
    },
    messages: {
        name_user: {
            required: "Este campo es obligatorio.",
            minlength: "Por favor, ingrese al menos 3 caracteres.",
            maxlength: "Por favor, ingrese un maximo de 20 caracteres.",
            lettersonly: "Solo se permite letras"
        },
        surname_user: {
            required: "Este campo es obligatorio.",
            minlength: "Por favor, ingrese al menos 3 caracteres.",
            maxlength: "Por favor, ingrese un maximo de 20 caracteres.",
            lettersonly: "Solo se permite letras"
        },
        phone_user: {
            required: "Por favor, ingrese un número de teléfono.",
            number: "Por favor, ingrese un número válido.",
            min: "Formato invalido, ingrese el formato 5491122222333",
            max: "Formato invalido, ingrese el formato 5491122222333"
        },
    }
});

// Manejador de envío del formulario
$('#change-edituser-form').on('submit', function (e) {
    e.preventDefault();
    var formData = $(this).serialize();

    if (!$("#change-edituser-form").valid()) {
        return; // Salir si el formulario no es válido
    }

    laddaButton = Ladda.create(document.querySelector('.ladda-button'));
    laddaButton.start();

    $.ajax({
        type: 'POST',
        url: 'usersController.php?token='+token+'&action=edit_user&email='+email, // La URL de tu archivo PHP
        data: formData,
        dataType: 'json',
        success: function (response) {
            laddaButton.stop();
            var messageContainer = $('#response-message');
            if (response.status === 'success') {
                $('#myModal6').modal('hide'); // Cierra el modal
                setTimeout(function () {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 4000,
                        onHidden: function () {
                            location.reload();
                        }
                    };
                    toastr.success(response.message, 'ÉXITO');
                });
            } else {
                messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        },
        error: function () {
            laddaButton.stop();
            $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX</div>');
        }
    });
});

});