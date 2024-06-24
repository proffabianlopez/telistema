<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_role'] != 'admin') {
        echo "<script> location.href='../includes/404.php'; </script>";
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../login.php'; </script>";
}
////////////////////////////////
// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Ordenes');
define('PAGE', 'Ordenes Admin');
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
                    <h2>Ordenes de trabajo</h2>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de ordenes de trabajo</h5>
                            </div>
                            <div class="ibox-content">
                                <?php
                                if (isset($_POST['id_client'])) {
                                    $_SESSION['id_client'] = $_POST['id_client'];
                                    $id_client = $_POST['id_client'];
                                    $stmt = $conn->prepare(SQL_ORDER_BY_ID);
                                    if ($stmt === false) {
                                        die('Error en la preparación de la consulta: ' . $conn->error);
                                    }
                                    $stmt->bind_param("i", $id_client);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        echo ' <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th data-hide="all">N° de Orden</th>
                                            <th data-hide="all">Cliente</th>
                                            <th data-toggle="true">Fecha y Hora</th>
                                            <th data-toggle="true">Descripción</th>
                                            <th data-toggle="true">Servidor</th>
                                            <th data-toggle="true">Prioridad</th>
                                            <th data-hide="all">Dirección</th>
                                            <th data-hide="all">Piso</th>
                                            <th data-hide="all">Dpto</th>
                                            <th data-hide="all">Estado</th>
                                            <th data-hide="all">Tecnico Asignado</th>
                                            <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        ';
                                        while ($row = $result->fetch_assoc()) {

                                            $order_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $row['order_date'] . ' ' . $row['order_hour']);
                                            $order_datetime_formatted = $order_datetime->format('d/m/Y H:i');
                                            echo '<tr>';
                                            echo '<td>' . $row["id_order"] . '</td>';
                                            echo '<td>' . $row["client_name"] . ' ' . $row['client_lastname'] . '</td>';
                                            echo '<td>' . $order_datetime_formatted . '</td>';
                                            echo '<td>' . $row["order_description"] . '</td>';
                                            echo '<td>' . $row["order_server"] . '</td>';
                                            echo '<td>' . $row["priority"] . '</td>';
                                            echo '<td>' . $row["address"] . ' ' . $row["height"] . '</td>';
                                            echo '<td>' . $row["floor"] . '</td>';
                                            echo '<td>' . $row["departament"] . '</td>';
                                            echo '<td>' . $row["state_order"] . '</td>';
                                            echo '<td>' . $row["name_user"] . ' ' . $row["surname_user"] . '</td>';
                                            echo '<td>
                                                    <div class="btn-group" role="group">
                                                         <button id="edit-' . $row["id_order"] .'*'.$row["id_client"]. '-' . $token . '" data-crud="orders" class="btn btn-warning btn-xs modaledit-btn" >
                                                       <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                     
                                                         <button id="delete-' . $row["id_order"] .'*'.$row["id_client"]. '-' . $token . '" data-crud="orders" class="btn btn-danger btn-xs delete-btn" >
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                    </div>
                                                </td>';
                                            echo '</tr>';
                                        }
                                        echo '</tbody>
                                        </table>';
                                    }
                                } else {
                                    echo "0 Resultado";
                                }
                                ?>
                                <tfoot>
                                    <tr>
                                        <td colspan="11">
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
        <a class="open-small-chat" onclick="openNewOrderModal()">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>

    <div id="edit-form-container" style="display: none;"></div>
    <?php
    include('../../includes/footer.php');
    ?>
    <script>
        $(document).ready(function () {
            $('.footable').footable();
            $('.footable2').footable();
        });
        function openNewOrderModal() {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "insertorder.php?token=<?php echo $token; ?>&&id_client=<?php echo $id_client; ?>", // Ruta al archivo de edición de usuario
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