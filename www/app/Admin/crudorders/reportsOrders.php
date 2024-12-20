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

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Reportes');
define('PAGE', 'Reportes Admin');

include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../../includes/header.php');
?>

<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <?php include('../../includes/menu.php'); ?>
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
                <h2>Reportes de Órdenes</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="../dashboard/dashboard.php">Inicio</strong></a>
                    </li>
                    <li>
                        <a href="order.php">Órdenes Asignadas</a>
                    </li>
                    <li class="active">
                        <strong>Reportes</strong>
                    </li>
                    <li>
                        <a href="historyOrders.php">Historial de Ordenes</a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <?php
                                $stmt = $conn->prepare(SQL_SELECT_ORDERS_TECHNIC_ADMIN);
                                if ($stmt === false) {
                                    die('Error en la preparación de la consulta: ' . $conn->error);
                                }
                                $stmt->execute();
                                $result = $stmt->get_result();

                                $orders = [];

                                // Agrupar los datos por id_order
                                while ($row = $result->fetch_assoc()) {
                                    $id_order = $row["id_order"];
                                    if (!isset($orders[$id_order])) {
                                        $orders[$id_order] = [
                                            "id_order" => $id_order,
                                            "order_date" => $row["order_date"],
                                            "order_date_finalized" => $row["order_date_finalized"], // Asegúrate de que este campo esté presente
                                            "report_technic" => $row["report_technic"],
                                            "type_work" => $row["type_work"],
                                            "state_order" => $row["state_order"],
                                            "images" => []
                                        ];
                                    }
                                    if (!empty($row["name_image"])) {
                                        $orders[$id_order]["images"][] = $row["name_image"];
                                    }
                                }

                                if (count($orders) > 0) {
                                    echo '<table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">Órden</th>
                                            <th style="width: 300px;">Imagen</th>
                                            <th style="width: 150px;">Fechas</th>
                                            <th style="width: 100px;">Trabajos</th>
                                            <th style="width: 150px;">Reporte</th>
                                            <th style="width: 100px;">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                    foreach ($orders as $order) {
                                        // Formatear fechas
                                        $start_date = DateTime::createFromFormat('Y-m-d H:i:s', $order['order_date']);
                                        $end_date = DateTime::createFromFormat('Y-m-d H:i:s', $order['order_date_finalized']);
                                        $start_date_formatted = $start_date ? $start_date->format('d/m/Y') : 'Fecha no disponible';
                                        $end_date_formatted = $end_date ? $end_date->format('d/m/Y') : 'Fecha no disponible';

                                        echo '<tr>';
                                        echo '<td>' . $order["id_order"] . '</td>';
                                        echo '<td>';

                                        // Carrusel para las imágenes
                                        if (count($order["images"]) > 0) {
                                            echo '<div id="carousel_' . $order["id_order"] . '" class="carousel slide" data-ride="carousel" style="width: 350px; height: 250px; overflow: hidden;">';
                                            echo '<div class="carousel-inner">';

                                            foreach ($order["images"] as $index => $image) {
                                                echo '<div class="item ' . ($index == 0 ? 'active' : '') . '" style="width: 350px; height: 250px;">';
                                                echo '<img src="' . htmlspecialchars($image) . '" style="width: 100%; height: 100%; object-fit: contain;">';
                                                echo '</div>';
                                            }

                                            echo '</div>';

                                            if (count($order["images"]) > 1) {
                                                echo '<a class="left carousel-control" href="#carousel_' . $order["id_order"] . '" data-slide="prev">';
                                                echo '<span class="icon-prev"></span>';
                                                echo '</a>';
                                                echo '<a class="right carousel-control" href="#carousel_' . $order["id_order"] . '" data-slide="next">';
                                                echo '<span class="icon-next"></span>';
                                                echo '</a>';
                                            }

                                            echo '</div>';
                                        } 
                                        echo '</td>';
                                        echo '<td>' . $start_date_formatted . ' - ' . $end_date_formatted . '</td>';
                                        echo '<td>' . htmlspecialchars($order["type_work"]) . '</td>';
                                        echo '<td>' . htmlspecialchars($order["report_technic"]) . '</td>';
                                        echo '<td>' . $order["state_order"] . '</td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody></table>';

                                } else {
                                    echo '<div class="col-md-12"><p>No hay órdenes de trabajo disponibles.</p></div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

</body>
</html>
