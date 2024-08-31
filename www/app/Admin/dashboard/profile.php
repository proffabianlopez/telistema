<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ( $_SESSION['user_idRol'] != 1) {
        header("Location:../../includes/404/404.php");
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../../login.php'; </script>";
}
////////////////////////////////
// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Mi Perfil');
define('PAGE', 'perfil');
include ('../../includes/header.php');
include ('../../dbConnection.php');
include ('../../Querys/querys.php');

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
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php include ('../../includes/menu.php') ?>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i
                                class="fa fa-bars"></i> </a>
                    </div>
                  

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Mi Perfil</h2>

                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
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
                                    <div class="form-group">
                                        <label for="mail">Email (no editable) </label>
                                        <p class="form-control" id="mail" name="mail">
                                            <?php if (isset($row['mail'])) {
                                                echo $row['mail'];
                                            } ?></p>
                                    </div>

                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <!-- Campo Cargo -->
                                    <div class="form-group">
                                        <label for="rol">Cargo <span class="text-danger">*</span></label>
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
                                        <label for="phone_user">Teléfono <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control validate-field vphone" id="phone_user"
                                            name="phone_user" placeholder="5491234567890" value="<?php if (isset($row['phone_user'])) {
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

                

            </div>
            <div class="footer">
                <div class="pull-right">

                </div>
                <div>
                    <strong>Copyright</strong> Telistema &copy; 2024
                </div>
            </div>

        </div>
    </div>


    <div id="small-chat">
        <a class="open-small-chat" onclick="openNewUserModal()">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>

    </div>
    <div id="edit-form-container" style="display: none;"></div>
    <?php
    include ('../../includes/footer.php');
    ?>
    <script>
        $(document).ready(function () {
            $('.footable').footable();
            $('.footable2').footable();

        });

        function openNewUserModal() {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "insertUsers.php?token=<?php echo $token; ?>", // Ruta al archivo de edición de usuario
                type: "GET",
                success: function (response) {
                    // Muestra el formulario de edición en el contenedor
                    $("#edit-form-container").html(response).slideDown();
                    // Abre el modal
                    $("#myModal6").modal("show");
                },
                error: function () {
                    alert("Error al cargar el formulario de edición.");
                }
            });
        }
    </script>

</body>

</html>