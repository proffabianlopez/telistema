<?php
session_start();
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 2) {
        header("Location:../../includes/404/404.php");
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../../login.php'; </script>";
}
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Ordenes');
define('PAGE', 'Ordenes technic');

include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../../includes/header.php');

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
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i></a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="../../../logout.php">
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Ordenes de Trabajo</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="../dashboard/dashboard.php">Inicio</a>
                        </li>
                        <li class="active">
                            <strong>Ordenes de trabajo</strong>
                        </li>
                        <li>
                            <a href="historyOrders.php">Historial de Ordenes</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $id_technic = $_SESSION['user_id'];
                        $stmt = $conn->prepare(SQL_ORDER_BY_ID_TEC);
                        if ($stmt === false) {
                            die('Error en la preparación de la consulta: ' . $conn->error);
                        }
                        $stmt->bind_param("i", $id_technic);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $urgentOrders = [];
                        $normalOrders = [];

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if ($row["priority"] === "Urgente") {
                                    $urgentOrders[] = $row;
                                } else {
                                    $normalOrders[] = $row;
                                }
                            }

                            // Mostrar órdenes urgentes
                            foreach ($urgentOrders as $row) {
                                date_default_timezone_set('America/Argentina/Buenos_Aires');
                                $order_datetime = date('d-m-Y', strtotime($row['order_date']));
                    ?>
                                <div class="col-md-3">
                                    <div class="ibox">
                                        <div class="ibox-content product-box">
                                            <div class="product-imitation">
                                                Orden #<?php echo $row["id_order"]; ?>
                                            </div>
                                            <div class="product-desc">
                                                <span class="product-price">
                                                    Prioridad: <?php echo htmlspecialchars($row["priority"]); ?>
                                                </span>
                                                <small class="text-muted">Fecha : <?php echo $order_datetime; ?></small>
                                                <div class="small m-t-xs">
                                                    Dirección: <?php echo $row["address"] . " " . $row["height"]; ?><br>
                                                    Descripción: <?php echo $row["order_description"]; ?>
                                                </div>
                                                <div class="m-t text-right">
                                                    <?php 
                                                    echo '<button id="edit-' . $row["id_order"] . '-' . $token . '" data-crud="reports" class="modaledit-btn btn btn-xs btn-outline btn-primary" style="margin-right: 5px">Reporte</button>';   
                                                    echo '<button id="edit-' . $row["id_order"] . '-' . $token . '" data-crud="technicians" class="modaledit-btn btn btn-xs btn-outline btn-primary" style="margin-right: 5px">Info</button>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }

                            // Mostrar órdenes normales
                            foreach ($normalOrders as $row) {
                                date_default_timezone_set('America/Argentina/Buenos_Aires');
                                $order_datetime = date('d-m-Y', strtotime($row['order_date']));
                    ?>
                                <div class="col-md-3">
                                    <div class="ibox">
                                        <div class="ibox-content product-box">
                                            <div class="product-imitation">
                                                Orden #<?php echo $row["id_order"]; ?>
                                            </div>
                                            <div class="product-desc">
                                                <span class="product-price">
                                                    Prioridad: <?php echo htmlspecialchars($row["priority"]); ?>
                                                </span>
                                                <small class="text-muted">Fecha : <?php echo $order_datetime; ?></small>
                                                <div class="small m-t-xs">
                                                    Dirección: <?php echo $row["address"] . " " . $row["height"]; ?><br>
                                                    Descripción: <?php echo $row["order_description"]; ?>
                                                </div>
                                                <div class="m-t text-right">
                                                    <?php 
                                                    echo '<button id="edit-' . $row["id_order"] . '-' . $token . '" data-crud="reports" class="modaledit-btn btn btn-xs btn-outline btn-primary" style="margin-right: 5px">Reporte</button>';   
                                                    echo '<button id="edit-' . $row["id_order"] . '-' . $token . '" data-crud="technicians" class="modaledit-btn btn btn-xs btn-outline btn-primary" style="margin-right: 5px">Info</button>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        } else {
                            echo '<div class="col-md-12"><p>No hay órdenes de trabajo disponibles.</p></div>';
                        }
                    }
                    ?>
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
    <div id="edit-form-container" style="display: none;"></div>
<?php
include('../../includes/footer.php');
?>
</body>
</html>
