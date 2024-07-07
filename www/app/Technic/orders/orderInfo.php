<?php
session_start();
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ( $_SESSION['user_idRol'] != 2) {
        header("Location:../../includes/404/404.php");
        exit;
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../../login.php'; </script>";
    exit;
}

define('TITLE', 'Ordenes');
define('PAGE', 'Ordenes');

include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../../includes/header.php');

if (isset($_REQUEST['view'])) {
    $id_order = $_REQUEST['id_order'];
    $sql = SQL_SELECT_ORDER_BY_ID;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ninguna orden con ese ID.</div>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo TITLE; ?></title>
    <!-- Aquí van tus metadatos, estilos y scripts -->
</head>
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
                    <h2>Detalle de Orden</h2>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <?php if ($result->num_rows > 0): ?>
                                            <fieldset class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Fecha:</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="<?php echo date('d/m/Y', strtotime($row['order_date'])); ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Descripción:</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" rows="5" readonly><?php echo $row["order_description"]; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Dirección:</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="<?php echo $row["address"] . " " . $row["height"]; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Cliente:</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="<?php echo $row["client_name"] . " " . $row['client_lastname']; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Estado:</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" value="<?php echo $row["state_order"]; ?>" readonly>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        <?php else: ?>
                                            <div class="col-md-12"><p>No hay órdenes de trabajo disponibles.</p></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
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
    <?php include('../../includes/footer.php'); ?>
</body>
</html>
