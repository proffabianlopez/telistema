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
// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Clientes');
define('PAGE', 'Clientes');
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
                            <a id="logout">
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Clientes</h2>

                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de clientes</h5>

                            </div>
                            <div class="ibox-content">


                                <?php

                                $stmt = $conn->prepare(SQL_FROM_CLIENTS);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    echo ' <table class="footable table table-stripped toggle-arrow-tiny">
                                <thead>
                                <tr>
                                    <th data-hide="all">Id</th>
                                    <th data-toggle="true">Nombre</th>
                                    <th data-hide="phone">Apellido</th>
                                    <th data-hide="phone">Telefono</th>
                                    <th data-hide="all">Email</th>
                                    <th data-hide="all">Direccion</th>
                                    <th data-hide="all">Piso</th>
                                    <th data-hide="all">Altura</th>
                                    <th data-hide="all">Dpto</th>
                                    <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ';
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . $row["id_client"] . '</td>';
                                        echo '<td>' . $row["client_name"] . '</td>';
                                        echo '<td>' . $row["client_lastname"] . '</td>';
                                        echo '<td>' . $row["phone"] . '</td>';
                                        echo '<td>' . $row["mail"] . '</td>';
                                        echo '<td>' . $row["address"] . '</td>';
                                        echo '<td>' . $row["height"] . '</td>';
                                        echo '<td>' . $row["floor"] . '</td>';
                                        echo '<td>' . $row["departament"] . '</td>';
                                        echo '<td>
                                                <div class="btn-group" role="group">
                                                    <button id="edit-' . $row["id_client"] . '-' . $token . '" data-crud="clients" class="btn btn-warning btn-xs modaledit-btn" >
                                                            <i class="bi bi-pencil-square"></i>
                                                     </button>
                                                   <button id="delete-' . $row["id_client"] . '-' . $token . '" data-crud="clients" class="btn btn-danger btn-xs delete-btn" >
                                                            <i class="bi bi-trash"></i>
                                                  </button>
                                                    
                                                    <form action="../crudorders/order.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="id_client" value="' . $row["id_client"] . '">
                                                    <button class="btn btn-primary btn-xs" name="order" value="Order">
                                                    <i class="bi bi-receipt"></i>
                                                    </button>
                                                    </form>

                                                </div>
                                                
                                            </td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>
                                    </table>';
                                } else {
                                    echo "0 Resultado";
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
        <a class="open-small-chat" onclick="openNewClientsModal()">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>

    <div id="edit-form-container" style="display: none;"></div>

    <?php
    include('../../includes/footer.php');
    ?>
    <script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();

        

        });

        function openNewClientsModal() {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "insertclient.php?token=<?php echo $token; ?>", // Ruta al archivo de edición de usuario
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