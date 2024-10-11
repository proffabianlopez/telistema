<?php
// Inicia la sesión
session_start();

// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location: ../../login.php");
    exit();
}

// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>

    <style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="modal inmodal fase" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close reload" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <i class="bi bi-lock modal-icon"></i>
                    <h4 class="modal-title">Cambiar Contraseña</h4>
                </div>
                <div class="modal-body">

                    <form id="change-password-form" class="m-t">
                        <div class="form-group password-container">
                            <input type="password" id="user_password_current" class="form-control user_password"
                                name="current_pass" placeholder="Contraseña Actual">
                            <span class="glyphicon glyphicon-eye-open toggle-password"></span>
                        </div>
                        <div class="form-group password-container">
                            <input type="password" id="user_password_new" class="form-control user_password"
                                name="new_pass" placeholder="Nueva Contraseña">
                            <span class="glyphicon glyphicon-eye-open toggle-password"></span>
                        </div>
                        <div class="form-group password-container">
                            <input type="password" id="user_password_repeat" class="form-control user_password"
                                name="repeat_pass" placeholder="Repite Contraseña">
                            <span class="glyphicon glyphicon-eye-open toggle-password"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                        <div class="text-center" id="response-message"></div>
                    </form>
                    <div class="p-xxs font-italic bg-muted border-top-bottom text "> <span
                            class="font-bold">NOTA:</span> Una contraseña segura debe contener por lo menos una mayúscula, números, un carácter especial y tener una longitud de 12 caracteres.</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Función para alternar la visibilidad de la contraseña
            function togglePasswordVisibility(button) {
                var passwordField = $(button).siblings('input');
                var passwordFieldType = passwordField.attr('type');

                // Alternar el tipo de campo de entrada
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(button).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                } else {
                    passwordField.attr('type', 'password');
                    $(button).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                }
            }

            // Asignar el evento click a cada botón de alternar visibilidad
            $('.toggle-password').click(function () {
                togglePasswordVisibility(this);
            });
        });

        $(document).ready(function () {
            $('#change-password-form').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '../crudusers/passwordCheck.php?token=<?php echo $token; ?>', // La URL de tu archivo PHP
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        var messageContainer = $('#response-message');
                        if (response.status === 'success') {
                            $("#myModal6").modal("hide"); // Cierra el modal
                            setTimeout(function () {
                                toastr.options = {
                                    closeButton: true,
                                    progressBar: true,
                                    showMethod: "slideDown",
                                    timeOut: 2500,
                                   
                                };
                                toastr.success(response.message, "ÉXITO");
                            });
                        } else {
                            messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function () {
                        $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX</div>');
                    }
                });
            });
            $('.reload').click(function () {
                location.reload();
            });
        });
    </script>

</body>

</html>