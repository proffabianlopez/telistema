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
include ('../../dbConnection.php');
include ('../../Querys/querys.php');

if (isset($_REQUEST['update'])) {

    // Checking for Empty Fields
    if (($_REQUEST['name_user'] == "") || ($_REQUEST['id_state_user'] == "") || ($_REQUEST['phone_user'] == "") || ($_REQUEST['mail'] == "")) {
        // msg displayed if required field missing
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';

    } else {
        // Assigning User Values to Variable
        $id = $_REQUEST['id_user'];
        $name = capitalizeWords(trim($_REQUEST['name_user']));
        $name = capitalizeWords(trim($_REQUEST['surname_user']));
        $phone = trim($_REQUEST['phone_user']);
        $mail = trim($_REQUEST['mail']);
        $state = $_REQUEST['id_state_user'];

        $stmt = $conn->prepare(SQL_UPDATE_ADMIN);
        $stmt->bind_param("sssii", $name, $phone, $mail, $state, $id);


        if ($stmt->execute()) {
            // below msg display on form submit success
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';

        } else {
            // below msg display on form submit failed
            $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
        }
    }
}
?>


<?php
if (isset($_GET['id'])) {

    $id_user = $_GET['id'];
    $stmt = $conn->prepare(SQL_SELECT_ADMIN_BY_ID);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();

    // Obtener resultados de la consulta
    $result = $stmt->get_result();

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Obtener la fila como un array asociativo
        $row = $result->fetch_assoc();
    } else {
        // Mostrar un mensaje si no se encuentra ningún cliente con el ID proporcionado
        echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningún cliente con ese ID.</div>';
    }

} else {
    echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se capto el ID.</div>';
}
?>

</body>
<div class="modal inmodal fase" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="bi bi-person-gear modal-icon"></i>
                <h4 class="modal-title">Editar Administrador</h4>
            </div>
            <div class="modal-body">

                <form id="change-admin-form" action="" method="POST">
                    <div style="display: none;" class="form-group">
                        <label for="id_user">ID Técnico</label>
                        <input type="text" class="form-control" id="id_user" name="id_user" value="<?php if (isset($row['id_user'])) {
                            echo $row['id_user'];
                        } ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name_user">Nombre</label>
                        <input type="text" class="form-control" id="name_user" name="name_user" value="<?php if (isset($row['name_user'])) {
                            echo $row['name_user'];
                        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="name_user">Apellido</label>
                        <input type="text" class="form-control" id="surname_user" name="surname_user" value="<?php if (isset($row['name_user'])) {
                            echo $row['surname_user'];
                        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone_user">Teléfono</label>
                        <input type="number" class="form-control" id="phone_user" name="phone_user" value="<?php if (isset($row['phone_user'])) {
                            echo $row['phone_user'];
                        } ?>" onkeypress="isInputNumber(event)">
                    </div>
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input type="email" class="form-control" id="mail" name="mail" value="<?php if (isset($row['mail'])) {
                            echo $row['mail'];
                        } ?>">
                    </div>
                    <div class="form-group">

                        <input type="checkbox" id="new_pass" name="new_pass"> <label for="new_pass"> Generar una nueva
                            contraseña</label>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="ladda-button btn btn-primary"
                            data-style="zoom-in">Actualizar</button>
                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="text-center" id="response-message"></div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text "> <span class="font-bold">NOTA:</span> Al
                    tiltar la casilla de Generar contraseña, se genra una nueva contraseña aleatoriamente y se enviara
                    al email del Administrador</div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        var laddaButton;

        $('#change-admin-form').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();

            laddaButton = Ladda.create(document.querySelector('.ladda-button'));
            laddaButton.start();

            $.ajax({
                type: 'POST',
                url: 'adminController.php?token=<?php echo $token; ?>&action=edit_admin', // La URL de tu archivo PHP
                data: formData,
                dataType: 'json',
                success: function (response) {
                    laddaButton.stop();
                    var messageContainer = $('#response-message');
                    if (response.status === 'success') {
                        messageContainer.html('<div class="alert alert-success">' + response.message + '</div>');
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

        $('.reload').click(function () {
            location.reload();
        });
    });

</script>

</body>

</html>