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
?>

<body>
    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close reload" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">Editar Usuario</h4>
                </div>
                <div class="modal-body">
                    <form id="change-edituser-form" role="change-edituser-form" action="" method="POST">
                        <!-- Contenedor principal flex -->
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Primera columna -->
                                <div class="col-md-6">
                                    <!-- Campo ID User (oculto) -->
                                    <div style="display: none;" class="form-group">
                                        <label for="id_user">ID User</label>
                                        <input type="text" class="form-control" id="id_user" name="id_user" value="<?php if (isset($row['id_user'])) {
                                            echo $row['id_user'];
                                        } ?>" readonly>
                                    </div>
                                    <!-- Campo Nombre -->
                                    <div class="form-group">
                                        <label for="name_user">Nombre  <span class="text-danger" >*</span></label>
                                        <input type="text" class="form-control" id="name_user" name="name_user" value="<?php if (isset($row['name_user'])) {
                                            echo $row['name_user'];
                                        } ?>" required>

                                    </div>
                                    <!-- Campo Apellido -->
                                    <div class="form-group">
                                        <label for="surname_user">Apellido  <span class="text-danger" >*</span></label>
                                        <input type="text" class="form-control" id="surname_user" name="surname_user"
                                            value="<?php if (isset($row['surname_user'])) {
                                                echo $row['surname_user'];
                                            } ?>" required>

                                    </div>
                                    <!-- Campo Email -->
                                    <div class="form-group">
                                        <label for="mail">Email  <span class="text-danger" >*</span></label>
                                        <input type="email" class="form-control" id="mail" name="mail" value="<?php if (isset($row['mail'])) {
                                            echo $row['mail'];
                                        } ?>" readonly>

                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <!-- Campo Cargo -->
                                    <div class="form-group">
                                        <label for="rol">Cargo  <span class="text-danger" >*</span></label>
                                        <select class="form-control" name="rol" id="rol" required>
                                            <option value="1" <?php if ($row["id_rol"] === 1)
                                                echo 'selected'; ?>>
                                                Administrador</option>
                                            <option value="2" <?php if ($row["id_rol"] === 2)
                                                echo 'selected'; ?>>Técnico
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Campo Teléfono -->
                                    <div class="form-group">
                                        <label for="phone_user">Teléfono  <span class="text-danger" >*</span></label>
                                        <input type="number" class="form-control" id="phone_user" name="phone_user"
                                            placeholder="5491234567890" value="<?php if (isset($row['phone_user'])) {
                                                echo $row['phone_user'];
                                            } ?>" onkeypress="isInputNumber(event)" required>

                                    </div>
                                    <!-- Campo Generar nueva contraseña -->
                                    <div class="form-group">
                                        <label> Generar una nueva contraseña?</label>
                                        <div class="onoffswitch">
                                            <input type="checkbox" class="onoffswitch-checkbox" id="new_pass"
                                                name="new_pass">
                                            <label class="onoffswitch-label" for="new_pass">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
                        <span class="font-bold">NOTA:</span> Al tiltar la casilla de Generar contraseña, se genera una
                        nueva
                        contraseña aleatoriamente y se enviará al email del Usuario<br>
                        <span class="text-danger" >*</span> Campo Obligatorio
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let token = '<?php echo $token; ?>';
        let email = '<?php echo $email; ?>';
    </script>
    <script src="../../js/main.js"></script>
    <script>
    
        $(document).ready(function () {

            $('#mail').prop('readonly', true);
            $('#mail').attr('disabled', 'disabled');

        });

    </script>

</body>

</html>