<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 1) {
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
                <?php
                    $stmt = $conn->prepare(SQL_FROM_ORDERS);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $pendientes = [];
                    $confirmadas = [];
                    $completas = [];
                    $canceladas = []; 

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['state_order'] == 'Pendiente') {
                                $pendientes[] = $row;
                            } elseif ($row['state_order'] == 'Confirmada') {
                                $confirmadas[] = $row;
                            } elseif ($row['state_order'] == 'Realizada') {
                                $completas[] = $row;
                            } elseif ($row['state_order'] == 'Cancelada') { 
                                $canceladas[] = $row;
                            }
                        }
                    }
                ?>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Pendientes</h3>
                            <ul class="sortable-list connectList agile-list">
                                <?php foreach ($pendientes as $row): ?>
                                    <li class="danger-element" id="task<?= $row['id_order'] ?>" style="cursor: default;">
                                        <strong>Orden: </strong><?= $row["id_order"] ?><br>
                                        <strong>Descripción: </strong><?= $row["order_description"] ?><br>
                                        <strong>Fecha: </strong><?= date('d/m/Y', strtotime($row["order_date"])) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Confirmadas</h3>
                            <ul class="sortable-list connectList agile-list">
                                <?php foreach ($confirmadas as $row): ?>
                                    <li class="info-element" id="task<?= $row['id_order'] ?>" style="cursor: default;">
                                        <strong>Orden: </strong><?= $row["id_order"] ?><br>
                                        <strong>Descripción: </strong><?= $row["order_description"] ?><br>
                                        <strong>Fecha: </strong><?= date('d/m/Y', strtotime($row["order_date"]))?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Canceladas</h3>
                            <ul class="sortable-list connectList agile-list">
                                <?php foreach ($canceladas as $row): ?>
                                    <li class="warning-element" id="task<?= $row['id_order'] ?>" style="cursor: default;">
                                        <strong>Orden: </strong><?= $row["id_order"] ?><br>
                                        <strong>Descripción: </strong><?= $row["order_description"] ?><br>
                                        <strong>Fecha: </strong><?= date('d/m/Y', strtotime($row["order_date"]))?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Realizadas</h3>
                            <ul class="sortable-list connectList agile-list">
                                <?php foreach ($completas as $row): ?>
                                    <li class="success-element" id="task<?= $row['id_order'] ?>" style="cursor: default;">
                                        <strong>Orden: </strong><?= $row["id_order"] ?><br>
                                        <strong>Descripción: </strong><?= $row["order_description"] ?><br>
                                        <strong>Fecha: </strong><?= date('d/m/Y', strtotime($row["order_date"]))?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
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

<div id="edit-form-container" style="display: none;"></div>
<?php
include('../../includes/footer.php');
?>

</body>

</html>
