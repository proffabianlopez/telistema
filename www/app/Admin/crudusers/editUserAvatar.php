<?php
// Inicia la sesión
session_start();

// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location:../../includes/404/404.php");
    exit();
}

// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../configsmtp/generate_config.php');

if (isset($_POST['id'])) {
    $id_user = $_POST['id'];
    $stmt = $conn->prepare(SQL_SELECT_USER_BY_ID);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();

    // Obtener resultados de la consulta
    $result = $stmt->get_result();
    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Obtener la fila como un array asociativo
        $row = $result->fetch_assoc();
        $email = $row['mail'];
    } else {
        // Mostrar un mensaje si no se encuentra ningún cliente con el ID proporcionado
        echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningún cliente con ese ID.</div>';
    }
} else {
    echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se capto el ID.</div>';
}

$formId = ($_SESSION["userId_Rol"] === 1) ? "change-adminavatar-form" : "change-technicavatar-form";
?>

<body>
<div class="modal inmodal fade" data-backdrop="static" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Cambiar Avatar</h4>
            </div>
            <div class="modal-body">
                <form id="<?php echo $formId; ?>" role="<?php echo $formId; ?>" action="" method="POST">
                    <!-- Contenedor principal flex -->
                    <div class="container-fluid">
                        <!-- Primera columna -->
                        <div class="form-group">
                            <label for="avatar">Seleccione una imagen</label>
                            <input type="file" class="form-control validate-field vavatar" id="avatar" name="avatar" required>
                        </div>
                    </div>
                    <!-- Botones de acción -->
                    <div class="modal-footer text-center">
                        <button type="submit" class="ladda-button btn btn-primary"
                                data-style="zoom-in">Actualizar</button>
                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                    </div>
                    <!-- Mensaje de respuesta -->
                    <div class="text-center" id="response-message"></div>
                </form>

                <div class="p-xxs font-italic bg-muted border-top-bottom">
                    <span class="font-bold">NOTA:</span> Al subir una imágen, aseguresé de que el formato sea uno de los siguientes:
                        <b>JPG, JPEG, PNG, GIF, WEBP</b> y no pese más de <b>1MB (1024 KB)</b>.<br>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<script src="../../js/main.js"></script>
</body>

</html>