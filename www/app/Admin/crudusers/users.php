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

define('TITLE', 'Usuarios');
define('PAGE', 'Usuarios');
include ('../../includes/header.php');
include ('../../dbConnection.php');
include ('../../Querys/querys.php');

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
                    <h2>Usuarios</h2>
                    <ol class="breadcrumb">
                        <li class="active">
                            <a href="users.php"><strong>Usuarios</strong></a>
                        </li>
                        <li>
                            <a href="../crudclients/clients.php">Clientes</a>
                        </li>
                        <li>
                            <a href="../crudsuppliers/suppliers.php">Proveedores</a>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de usuarios</h5>

                            </div>
                            <div class="ibox-content">


                                <?php
                                $sql = SQL_SELECT_USERS;
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo ' <table class="footable table table-stripped toggle-arrow-tiny">
                                    <thead>
                                    <tr>
                                        <th data-hide="all">Usuario</th>
                                        <th data-toggle="true">Nombre</th>
                                        <th data-toggle="true">Apellido</th>
                                        <th data-hide="all">Email</th>
                                        <th data-hide="all">Teléfono</th>
                                        <th data-hide="phone">Cargo</th>
                                        <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    ';

                                    // Imprimir los datos de cada técnico
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row['id_user'] != $_SESSION['user_id']) {

                                            echo '<tr>';
                                            echo '<td>' . $row["id_user"] . '</td>';
                                            echo '<td>' . $row["name_user"] . '</td>';
                                            echo '<td>' . $row["surname_user"] . '</td>';
                                            echo '<td>' . $row["mail"] . '</td>';
                                            echo '<td>' . $row["phone_user"] . '</td>';
                                            echo '<td>' . $row["rol"] . '</td>';
                                            echo '<td>
                                                    <div class="btn-group" role="group">
                                                        <button id="edit-' . $row["id_user"] . '-' . $token . '" data-crud="users" class="btn btn-warning btn-xs  modaledit-btn" style="margin-right: 5px" >
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <button id="delete-' . $row["id_user"] . '-' . $token . '" data-crud="users" class="btn btn-danger btn-xs delete-btn" style="margin-right: 5px">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                        <button id="edit-' . $row["id_user"] . '-' . $token . '" data-crud="technicPassword" class="btn btn-primary btn-xs modaledit-btn">
                                                            <i class="bi bi-key"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>';

                                        }
                                    }

                                    echo '</tbody>
                                                </table>';
                                } else {
                                    echo "No se han encontrado usuarios registrados en el sistema hasta el momento.";
                                }
                                ?>



                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                </tfoot>


                            </div>
                        </div>
                    </div>
                </div>

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