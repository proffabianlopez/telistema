<?php
// Inicia la sesión
session_start();

// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location: ../../includes/404.php");
    exit();
}

// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../configsmtp/generate_config.php');
$passwordGenerate = generatePassword();
?>

</body>
<div class="modal inmodal fase" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="bi bi-person-fill-add modal-icon"></i>
                <h4 class="modal-title">Registrar Nuevo Administrador</h4>
            </div>
            <div class="modal-body">

                <form id="change-admin-form" action="" method="POST">
                    <div class="form-group">
                        <label for="name_user">Nombre</label>
                        <input type="text" class="form-control" id="name_user" name="name_user">
                    </div>
                    <div class="form-group">
                        <label for="name_user">Apellido</label>
                        <input type="text" class="form-control" id="surname_user" name="surname_user">
                    </div>
                    <div class="form-group">
                        <label for="phone_user">Teléfono</label>
                        <input type="number" class="form-control" id="phone_user" name="phone_user" onkeypress="isInputNumber(event)">
                    </div>
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input type="email" class="form-control" id="mail" name="mail">
                    </div>
                    <div style="display: none" class="form-group password-container">
                        <label for="user_password">Contraseña</label>
                        <input type="password" class="form-control" id="user_password" name="user_password" value="<?php echo $passwordGenerate; ?>" readonly>
                        <span class="glyphicon glyphicon-eye-open toggle-password"></span>
                    </div>
                    <br>

                    <div class="modal-footer">
                        <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="text-center" id="response-message"></div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text ">
                    <spn class="font-bold">NOTA:</spn> Al agregar un nuevo Administrador se enviará al email las
                    credenciales para que pueda iniciar sesión. El sistema genera automaticamente una contraseña
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#change-admin-form').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            laddaButton = Ladda.create(document.querySelector('.ladda-button'));
            laddaButton.start();
            $.ajax({
                type: 'POST',
                url: 'adminController.php?token=<?php echo $token; ?>&action=add_admin', // La URL de tu archivo PHP
                data: formData,
                dataType: 'json',
                success: function(response) {
                    laddaButton.stop();
                    var messageContainer = $('#response-message');
                    if (response.status === 'success') {
                        messageContainer.html('<div class="alert alert-success">' + response.message + '</div>');
                    } else {
                        messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    laddaButton.stop();
                    console.log(xhr.responseText);
                    $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX: ' + error + '</div>');
                }
            });
        });
        $('.reload').click(function() {
            location.reload();
        });



    });
</script>

</body>

</html>