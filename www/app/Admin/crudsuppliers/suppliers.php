<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_role'] != 'admin') {
        echo "<script> location.href='../../includes/404.php'; </script>";
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
include('../../includes/header.php');
include('../../dbConnection.php');
include('../../Querys/querys.php');

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
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="../../logout.php" id="logout">
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Proveedores</h2>

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

                                $stmt = $conn->prepare(SQL_FROM_SUPPLIERS);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    echo ' <table class="footable table table-stripped toggle-arrow-tiny">
                                <thead>
                                <tr>
                                    <th data-hide="all">Id</th>
                                    <th data-toggle="true">Nombre</th>
                                    <th data-hide="phone">Telefono</th>
                                    <th data-hide="phone">Email</th>
                                    <th data-hide="all">Direccion</th>
                                    <th data-hide="phone">Estado</th>
                                    <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ';
                                    while ($row = $result->fetch_assoc()) {
                                        $state = $row['id_state_user'];
                                        $stmt = $conn->prepare(SQL_SELECT_STATE_BY_ID);
                                        $stmt->bind_param("i", $state);
                                        $stmt->execute();
                                        $result_state = $stmt->get_result();

                                        // Verificar si hay resultados
                                        if ($result_state->num_rows > 0) {
                                            // Obtener la fila como un array asociativo
                                            $row_state = $result_state->fetch_assoc();
                                            $name_state = $row_state["state_user"];
                                        } else {
                                            // Si no hay resultados, asignar un valor por defecto
                                            $name_state = "Estado no encontrado"; // O el valor que desees
                                        }
                                        echo '<tr>';
                                        echo '<td>' . $row["id_supplier"] . '</td>';
                                        echo '<td>' . $row["supplier_name"] . '</td>';
                                        echo '<td>' . $row["phone"] . '</td>';
                                        echo '<td>' . $row["mail"] . '</td>';
                                        echo '<td>' . $row["address"] . '</td>';
                                        echo '<td>' . $name_state . '</td>';
                                        echo '<td>
                                                <div class="btn-group" role="group">
                                                    <form action="editsupplier.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id_supplier" value="' . $row["id_supplier"] . '">
                                                        <button type="submit" class="btn btn-warning btn-xs" name="view" value="View">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                    </form>
                                                    </div>
                                                    <button id="delete-' . $row["id_supplier"] . '-' . $token . '" data-crud="suppliers" class="btn btn-danger btn-xs delete-btn" >
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    </td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>
                                                </table>';
                                } else {
                                    echo "0 Result";
                                }
                                if (isset($_REQUEST['delete'])) {
                                    $id_supplier = $_REQUEST['id_supplier'];

                                    $stmt = $conn->prepare(SQL_DELETE_SUPPLIER);

                                    // Asocia parámetros y ejecuta la consulta
                                    $stmt->bind_param("i", $id_supplier);

                                    if ($stmt->execute()) {

                                        echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
                                    } else {
                                        echo "Unable to Delete Data";
                                    }
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
        <a class="open-small-chat" href="insertsupplier.php">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>



    <?php
    include('../../includes/footer.php');
    ?>
    <script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();

        });
    </script>
</body>

</html>