<?php
session_start();
define('TITLE', 'Technic Profile');
define('PAGE', 'Technic Profile');
include ('../../dbConnection.php');
include ('../../Querys/querys.php');

// Verificar que el usuario esté autenticado y tenga el rol correcto
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 2) {
        header("Location:../../includes/404/404.php");
        exit;
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../../login.php'; </script>";
    exit;
}

// Generar un token CSRF y guardarlo en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

// Preparar y ejecutar la consulta para obtener los datos del técnico
$stmtr = $conn->prepare(SQL_SELEC_USERS);
$technic_id = $_SESSION['user_id'];
$stmtr->bind_param("i", $technic_id);
$stmtr->execute();
$result = $stmtr->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $surname = $row['surname_user'];
    $name_user = $row['name_user'];
    $mail = $row['mail'];
    $phone_user = $row['phone_user'];
    $avatar = $row['avatar_user'];
} else {
    $name_user = 'No disponible';
    $surname = 'No disponible';
    $mail = 'No disponible';
    $phone_user = 'No disponible';
    $avatar = "";
}
// Defino avatar por default si el usuario no tiene uno
if(!file_exists("../../img/avatars/" . $row['avatar_user']) || is_null($row['avatar_user'])) {
    $row['avatar_user'] = '../../img/avatars/default.png';
}

$stmtr->close();
?>
<?php include ('../../includes/header.php'); ?>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php include ('../../includes/menu.php'); ?>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Mi Perfil</h2>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="row m-b-lg m-t-lg ibox-content">
                <div class="col-md-6">
                    <a id="edit-<?php echo ($row["id_user"] . '-' . $token); ?>" data-crud="technicAvatar" class="modaledit-btn">
                        <div class="profile-image">
                            <img src="<?php echo htmlspecialchars($row['avatar_user']); ?>"  alt="Avatar de <?php echo htmlspecialchars($row['name_user']);?>" class="img-circle img-thumbnail">
                        </div>
                    </a>

                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    <?php echo htmlspecialchars($name_user); ?>
                                    <?php echo htmlspecialchars($surname); ?>
                                </h2>
                                <h4>Perfil del Técnico</h4>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            <td>
                            <strong>Nombre:</strong> <?php echo htmlspecialchars($name_user); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <strong>Apellido:</strong> <?php echo htmlspecialchars($surname); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Celular:</strong> <?php echo htmlspecialchars($phone_user); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <strong>Email:</strong> <?php echo htmlspecialchars($mail); ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

           

    <?php include ('../../includes/footer.php'); ?>
    <div id="edit-form-container" style="display: none;"></div>
    <!-- Sparkline -->
    <script>
        let token = "<?php echo $token; ?>"
        let email = "<?php echo $row['mail']; ?>"
    </script>
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });
        });

        //function openEditModal() {
        //    // Realiza una solicitud AJAX para obtener el formulario de edición
        //    $.ajax({
        //        url: "modalpass.php?token=<?php //echo $token; ?>//", // Ruta al archivo de edición de usuario
        //        type: "GET",
        //        success: function (response) {
        //            // Muestra el formulario de edición en el contenedor
        //            $("#edit-form-container").html(response).slideDown();
        //            // Abre el modal
        //            $("#myModal6").modal("show");
        //        },
        //        error: function () {
        //            alert("Error al cargar el formulario de edición.");
        //        }
        //    });
        //}
    </script>
</body>
</html>