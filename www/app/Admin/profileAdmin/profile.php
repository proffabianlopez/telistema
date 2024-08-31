<?php
session_start();

// Verificar si el usuario está logueado y activo
if (!isset($_SESSION['is_login']) || $_SESSION['state_user'] != 'activo') {
    echo "<script> location.href='../../login.php'; </script>";
    exit;
}

// Verificar el rol del usuario
if ($_SESSION['user_idRol'] != 1) {
    header("Location:../../includes/404/404.php");
    exit;
}

// Generar un token CSRF y guardarlo en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Mi Perfil');
define('PAGE', 'perfil');
include('../../includes/header.php');
include('../../dbConnection.php');
include('../../Querys/querys.php');

// Obtener los datos del usuario logueado
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare(SQL_SELECT_USER_BY_ID);
$stmt->bind_param("i", $user_id);
$stmt->execute();

// Obtener resultados de la consulta
$result = $stmt->get_result();
// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Obtener la fila como un array asociativo
    $row = $result->fetch_assoc();
} else {
    echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningún usuario con el ID proporcionado.</div>';
    exit;
}
?>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php include('../../includes/menu.php') ?>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Mi Perfil</h2>
                </div>
                <div class="col-lg-2"></div>
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
                                    <input type="text" class="form-control" id="id_user" name="id_user" value="<?php echo htmlspecialchars($row['id_user']); ?>" readonly>
                                </div>
                                <!-- Campo Nombre -->
                                <div class="form-group">
                                    <label for="name_user">Nombre <span class="text-danger"></span></label>
                                    <input type="text" class="form-control validate-field vname" id="name_user" name="name_user" value="<?php echo htmlspecialchars($row['name_user']); ?>">
                                </div>
                                <!-- Campo Apellido -->
                                <div class="form-group">
                                    <label for="surname_user">Apellido <span class="text-danger"></span></label>
                                    <input type="text" class="form-control validate-field vname" id="surname_user" name="surname_user" value="<?php echo htmlspecialchars($row['surname_user']); ?>">
                                </div>
                                <!-- Campo Mail -->
                                <div class="form-group">
                                    <label for="mail">Email (no editable)</label>
                                    <p class="form-control" id="mail" name="mail"><?php echo htmlspecialchars($row['mail']); ?></p>
                                </div>
                            </div>
                            <!-- Segunda columna -->
                            <div class="col-md-6">
                                <!-- Campo Cargo -->
                                <div class="form-group">
                                    <label for="user_role">Cargo</label>
                                    <p class="form-control" id="user_role">
                                        <?php
                    
                                        switch ($row['id_rol']) {
                                            case 1:
                                                echo 'Administrador';
                                                break;
                                            case 2:
                                                echo 'Técnico';
                                                break;
                                            default:
                                                echo 'Desconocido';
                                                break;
                                        }
                                        ?>
                                    </p>
                                </div>
                                <!-- Campo Teléfono -->
                                <div class="form-group">
                                    <label for="phone_user">Teléfono <span class="text-danger"></span></label>
                                    <input type="number" class="form-control validate-field vphone" id="phone_user" name="phone_user" placeholder="5491234567890" value="<?php echo htmlspecialchars($row['phone_user']); ?>" onkeypress="isInputNumber(event)">
                                </div>
                                <!-- Campo Generar nueva contraseña -->
                                <div class="form-group">
                                    <label> Generar una nueva contraseña?</label>
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="new_pass" name="new_pass">
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
                        <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
                    </div>
                    <!-- Mensaje de respuesta -->
                    <div class="text-center" id="response-message"></div>
                </form>
            </div>
            <div class="footer">
                <div class="pull-right"></div>
                <div>
                    <strong>Copyright</strong> Telistema &copy; 2024
                </div>
            </div>
        </div>
    </div>

    <?php include('../../includes/footer.php'); ?>
    <script>
        $(document).ready(function () {
            $('.footable').footable();
            $('.footable2').footable();
        });
    </script>
</body>
</html>
