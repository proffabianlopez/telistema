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
                <div class="row m-b-lg m-t-lg ibox-content">
                    <div class="col-md-6">
                        <div class="profile-image">
                            <img src="../../../img/team-3.jpg" class="rounded-circle circle-border m-b-md" alt="profile">
                        </div>
                        <div class="profile-info">
                            <div class="">
                                <div>
                                    <h2 class="no-margins">
                                        <?php echo htmlspecialchars($row['name_user']); ?>
                                        <?php echo htmlspecialchars($row['surname_user']); ?>
                                    </h2>
                                    <h4>Perfil del Administrador</h4>
                                    <small>
                                        Técnico de mantenimiento informático con 3 años de experiencia en el sector,
                                        especializado en la gestión y ejecución de tareas de mantenimiento preventivo y correctivo.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <table class="table small m-b-xs">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>Email:</strong> <?php echo htmlspecialchars($row['mail']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Celular:</strong> <?php echo htmlspecialchars($row['phone_user']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Cargo:</strong>
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
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-3" role="group">
                        <button id="edit-<?php echo ($row["id_user"] . '-' . $token); ?>" data-crud="admin" class="btn btn-primary modaledit-btn ">
                            Modificar perfil
                        </button>
                        <button id="edit-<?php echo ($row["id_user"] . '-' . $token); ?>" data-crud="adminPassword" class="btn btn-primary modaledit-btn ">
                            Cambiar Contraseña
                        </button>
                    </div>

                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">

            </div>
            <div class="footer">
                <div class="pull-right"></div>
                <div>
                    <strong>Copyright</strong> Telistema &copy; 2024
                </div>
            </div>
        </div>
    </div>
    <div id="editpassword-form-container" style="display: none;"></div>
    <div id="edit-form-container" style="display: none;"></div>
    <script>
        let token = "<?php echo $token; ?>"
        let email = "<?php echo $row['mail']; ?>"
    </script>
    <?php include('../../includes/footer.php'); ?>
    <script>
        $(document).ready(function () {
            $('.footable').footable();
            $('.footable2').footable();
        });

        // Cambiar contraseña
       /* function openEditModal() {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "../crudusers/modalpass.php?token=<?php echo $token; ?>", // Ruta al archivo de edición de usuario
                type: "GET",
                success: function (response) {
                    // Muestra el formulario de edición en el contenedor
                    $("#editpassword-form-container").html(response).slideDown();
                    // Abre el modal
                    $("#myModal6").modal("show");
                },
                error: function () {
                    alert("Error al cargar el formulario de edición.");
                }
            });
        }*/
    </script>
</body>
</html>