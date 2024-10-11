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
    <div class="modal inmodal fade" data-backdrop="static" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
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
                                        <label for="name_user">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control validate-field vname" id="name_user"
                                            name="name_user" value="<?php if (isset($row['name_user'])) {
                                                echo $row['name_user'];
                                            } ?>" required>

                                    </div>
                                    <!-- Campo Apellido -->
                                    <div class="form-group">
                                        <label for="surname_user">Apellido <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control validate-field vname" id="surname_user"
                                            name="surname_user" value="<?php if (isset($row['surname_user'])) {
                                                echo $row['surname_user'];
                                            } ?>" required>

                                    </div>

                                    <!-- Campo Teléfono -->
                                    <div class="form-group">
                                        <label for="phone_user">Teléfono <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control validate-field iti__tel-input" id="phone_user"
                                            name="phone_user" value="<?php if (isset($row['phone_user'])) {
                                                echo $row['phone_user'];
                                            } ?>"required>

                                    </div>
                                   

                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <!-- Campo Cargo -->
                                    <div class="form-group">
                                        <label for="rol">Cargo</label>
                                        <select class="form-control" name="rol" id="rol" disabled>
                                            <option value="<?php echo $row["id_rol"]; ?>" selected>
                                                <?php echo ($row["id_rol"] === 1) ?
                                                    'Administrador' : 'Técnico'; ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="mail">Email </label>
                                        <p class="form-control" id="mail" name="mail" disabled>
                                            <?php if (isset($row['mail'])) {
                                                echo $row['mail'];
                                            } ?></p>
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
                        <span class="font-bold">NOTA:</span> Al editar un usuario, asegúrese de revisar y actualizar correctamente todos los campos. Los cambios realizados se verán reflejados de manera inmediata en el sistema. <br>
                        <span class="text-danger">*</span> Campo Obligatorio.
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
    <script>
      const input = document.querySelector("#phone_user");
      const iti = window.intlTelInput(input, {
        separateDialCode: true,
        preferredCountries: ["ar", "us", "br", "mx"],
        utilsScript: "../../js/utils.js"
      });

      // Detecta el cambio de bandera
      input.addEventListener("countrychange", function() {
        // Limpiar el campo de tel
        input.value = "";
      });

      // Cuando el formulario se envíe,se agrega el codigo de area
      document.getElementById('change-edituser-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const fullNumber = iti.getNumber();
        document.getElementById('phone_user').value = fullNumber;
        this.submit();
      });
    </script>

</body>

</html>