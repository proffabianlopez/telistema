<?php
session_start();
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 1) {
        echo "<script> location.href='../includes/404.php'; </script>";
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_idRol'];
} else {
    echo "<script> location.href='../login.php'; </script>";
}

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
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Órdenes de trabajo</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="../dashboard/dashboard.php">Inicio</strong></a>
                        </li>
                        <li class="active">
                            <strong>Órdenes Asignadas</strong>
                        </li>
                        <li>
                            <a href="reportsOrders.php">Reportes</a>
                        </li>
                        <li>
                            <a href="historyOrders.php">Historial de Órdenes</a>
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
                                <h5>Lista de órdenes de trabajo</h5>
                            </div>
                            <div class="ibox-content">
                                <?php
                                $stmt = $conn->prepare(SQL_ORDER_BY_ID);
                                if ($stmt === false) {
                                    die('Error en la preparación de la consulta: ' . $conn->error);
                                }
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    echo ' <table class="footable table table-stripped toggle-arrow-tiny">
                                    <thead>
                                    <tr>
                                        <th data-hide="all">Órden</th>
                                        <th data-toggle="true">N° de Circuito</th>
                                        <th data-hide="all">Cliente</th>
                                        <th data-toggle="true">Técnico</th>
                                        <th data-toggle="true">Fecha</th>
                                        <th data-hide="phone">Prioridad</th>
                                        <th data-hide="phone">Tipo de Trabajo</th>
                                        <th data-hide="all">Dirección</th>
                                        <th data-hide="all">Piso</th>
                                        <th data-hide="all">Dpto</th>
                                        <th data-hide="all">Estado</th>
                                        <th data-hide="all">Descripción</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    ';
                                    while ($row = $result->fetch_assoc()) {
                                        $order_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $row['order_date']);
                                        $order_datetime_formatted = $order_datetime->format('d/m/Y');

                                        // Si son null, coloca un "-"
                                        $floor = isset($row["floor"]) && $row["floor"] !== '' ? $row["floor"] : '-';
                                        $departament = isset($row["departament"]) && $row["departament"] !== '' ? $row["departament"] : '-';

                                        echo '<tr>';
                                        echo '<td>' . $row["id_order"] . '</td>';
                                        echo '<td>' . $row["circuit_number"] . '</td>';
                                        echo '<td>' . $row["client_name"] . ' ' . $row['client_lastname'] . '</td>';
                                        echo '<td>' . $row["name_user"] . ' ' . $row["surname_user"] . '</td>';
                                        echo '<td>' . $order_datetime_formatted . '</td>';
                                        echo '<td>' . $row["priority"] . '</td>';
                                        echo '<td>' . $row["type_work"] . '</td>';
                                        echo '<td>' . $row["address"] . ' ' . $row["height"] . '</td>';
                                        echo '<td>' . $floor . '</td>';
                                        echo '<td>' . $departament . '</td>';
                                        echo '<td>' . $row["state_order"] . '</td>';
                                        echo '<td>' . $row["order_description"] . '</td>';
                                        echo '<td>
                                                <div class="btn-group" role="group">
                                                     <button id="edit-' . $row["id_order"] . '-' . $token . '" data-crud="orders" class="btn btn-warning btn-xs modaledit-btn" style="margin-right: 5px">
                                                   <i class="bi bi-pencil-square"></i>
                                                </button>
                                                 
                                                     <button id="delete-' . $row["id_order"] . '-' . $token . '" data-crud="orders" class="btn btn-danger btn-xs delete-btn">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                </div>
                                            </td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody>
                                    </table>';
                                } else {
                                    echo "No se han encontrado órdenes de trabajo registradas en el sistema hasta el momento.";
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
        $(document).ready(function() {
            $('.footable').footable();
            $('.footable2').footable();
        });

        function openNewOrderModal() {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "insertorder.php?token=<?php echo $token; ?>", // Ruta al archivo de inserción de orden
                type: "GET",
                success: function(response) {
                    // Muestra el formulario de inserción en el contenedor
                    $("#edit-form-container").html(response).slideDown();
                    // Abre el modal
                    $("#myModal6").modal("show");
                },
                error: function() {
                    alert("Error al cargar el formulario.");
                }
            });
        }
    </script>
</body>

</html>