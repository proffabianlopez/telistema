<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 1) {
        header("Location:../../includes/404/404.php");
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../../login.php'; </script>";
}
////////////////////////////////
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Proveedores');
define('PAGE', 'Proveedores');
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
                    <h2>Proveedores</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="../dashboard/dashboard.php">Inicio</strong></a>
                        </li>
                        <li>
                            <a href="../crudusers/users.php">Usuarios</a>
                        </li>
                        <li>
                            <a href="../crudclients/clients.php">Clientes</a>
                        </li>
                        <li class="active">
                            <strong>Proveedores</strong>
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
                                <h5>Lista de proveedores</h5>
                            </div>
                            <div class="ibox-content">


                                <?php

                                $sql = SQL_FROM_SUPPLIERS;
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo ' <table class="footable table table-stripped toggle-arrow-tiny">
                                <thead>
                                <tr>
                                    <th data-hide="all">Proveedor</th>
                                    <th data-toggle="true">Nombre</th>
                                    <th data-hide="phone">Teléfono</th>
                                    <th data-hide="phone">Email</th>
                                    <th data-hide="all">Dirección</th>
                                    <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ';
                                    while ($row = $result->fetch_assoc()) {

                                        echo '<tr>';
                                        echo '<td>' . $row["id_supplier"] . '</td>';
                                        echo '<td>' . $row["supplier_name"] . '</td>';
                                        echo '<td>' . $row["phone"] . '</td>';
                                        echo '<td>' . $row["mail"] . '</td>';
                                        echo '<td>' . $row["address"] . '</td>';
                                        echo '<td>
                                        <div class="btn-group" role="group">
                                            <button id="edit-' . $row["id_supplier"] . '-' . $token . '" data-crud="suppliers" class="btn btn-warning btn-xs  modaledit-btn " style="margin-right: 5px" >
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button id="delete-' . $row["id_supplier"] . '-' . $token . '" data-crud="suppliers" class="btn btn-danger btn-xs delete-btn" >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>';

                                    }

                                    echo '</tbody>
                                                </table>';
                                } else {
                                    echo "No se han encontrado proveedores registrados en el sistema hasta el momento.";
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
        <a class="open-small-chat" onclick="openNewSupplierModal()">
            <i class="bi bi-plus-lg"></i>
        </a>
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
        function openNewSupplierModal() {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "insertsupplier.php?token=<?php echo $token; ?>", // Ruta al archivo de edición de usuario
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