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

    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s']+$/i.test(value);
    }, "Solo se permiten letras en este campo.");

    function setupFormValidation(formId) {
        $(formId).validate({
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
                    min: 999999999999,
                    max: 9999999999999
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
    }

    function handleFormSubmit(formId, actionUrl) {
        $(formId).on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
    
            if (!$(formId).valid()) {
                return; // Salir si el formulario no es válido
            }
    
            var laddaButton = Ladda.create(document.querySelector('.ladda-button'));
            laddaButton.start();
    
            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: formData,
                dataType: 'json',
                success: function (response) {
                    var messageContainer = $('#response-message');
    
                    if (response.status === "user_in_deleted") {
                        swal({
                            title: "Este email ya estuvo registrado",
                            text: "El email ya existe en la base de datos con estado eliminado. ¿Deseas actualizarlo?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Sí, actualizar",
                            cancelButtonText: "No, cancelar"
                        }, function (isConfirm) {
                            if (isConfirm) {
                                // Mantén el laddaButton activo aquí
                                $.ajax({
                                    type: "POST",
                                    url: actionUrl + '&isUpdate=true',
                                    data: formData,
                                    dataType: "json",
                                    success: function (updateResponse) {
                                        laddaButton.stop(); // Detén el laddaButton aquí
                                        if (updateResponse.status === "success") {
                                            $('#myModal6').modal('hide'); // Cierra el modal
                                            setTimeout(function () {
                                                toastr.options = {
                                                    closeButton: true,
                                                    progressBar: true,
                                                    showMethod: 'slideDown',
                                                    timeOut: 1500,
                                                    onHidden: function () {
                                                        location.reload();
                                                    }
                                                };
                                                toastr.success( updateResponse.message, '¡Actualizado!');
                                            });
                                        } else {
                                            swal({
                                                title: "Error",
                                                text: updateResponse.message,
                                                type: "error"
                                            });change
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        laddaButton.stop(); // Detén el laddaButton aquí
                                        console.error(xhr.responseText);
                                        swal({
                                            title: "Error",
                                            text: "Hubo un problema al actualizar.",
                                            type: "error"
                                        });
                                    }
                                });
                            } else {
                                laddaButton.stop(); // Detén el laddaButton si se cancela
                            }
                        });
                    } else if (response.status === 'success') {
                        laddaButton.stop(); // Detén el laddaButton aquí
                        $('#myModal6').modal('hide'); // Cierra el modal
                        setTimeout(function () {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                showMethod: 'slideDown',
                                timeOut: 1500,
                                onHidden: function () {
                                    location.reload();
                                }
                            };
                            toastr.success(response.message, 'ÉXITO');
                        });
                    } else {
                        laddaButton.stop(); // Detén el laddaButton aquí
                        messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function (xhr, status, error) {
                    laddaButton.stop(); // Detén el laddaButton aquí
                    console.log(xhr.responseText);
                    $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX: ' + error + '</div>');
                }
            });
        });
    }
    
    
    // Configurar validación y envío para cada formulario
    setupFormValidation("#change-insertuser-form");
    handleFormSubmit("#change-insertuser-form", 'usersController.php?token=' + token + '&action=add_user');

    setupFormValidation("#change-edituser-form");
    handleFormSubmit("#change-edituser-form", 'usersController.php?token=' + token + '&action=edit_user&email=' + email);
});
