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
                <h2>Reportes de Ordenes</h2>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight ecommerce">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-container">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <?php
                                if (isset($_SESSION['user_id'])) {
    $id_technic = $_SESSION['user_id'];
    $stmt = $conn->prepare(SQL_SELECT_ORDERS_TECHNIC);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    $stmt->bind_param("i", $id_technic);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 90px;">Orden N°</th>
                        <th>Imagen</th>
                        <th>Fecha</th>
                        <th>Reporte</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';
        while ($row = $result->fetch_assoc()) {
            if ($row['report_technic'] !== null) {
                $order_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $row['order_date']);
                $order_datetime_formatted = $order_datetime->format('d/m/Y');
                $image_path = '' . htmlspecialchars($row["name_image"]);
                echo '<tr>';
                echo '<td>' . $row["id_order"] . '</td>';
                echo '<td>' . '<a href="' . $image_path . '" title="Image" data-gallery="" alt="Imagen" ><img src="' . $image_path . '" style="max-width: 200px; max-height: 200px;"></a>' . '</td>';
                echo '<td>' . $order_datetime_formatted . '</td>';
                echo '<td>' . htmlspecialchars($row["report_technic"]) . '</td>';
                echo '<td>' . $row["state_order"] . '</td>';
                echo '</tr>';
            }
        }
        echo '</tbody></table>';
    } else {
        echo '<div class="col-md-12"><p>No hay órdenes de trabajo disponibles.</p></div>';
    }
}

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2017
            </div>
        </div>
    </div>
</div>
<div id="fullscreen-img-container" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; justify-content:center; align-items:center;">
    <img id="fullscreen-img" style="max-width:200%; max-height:200%;" />
</div>

<?php include('../../includes/footer.php'); ?>

<script>
    $(document).ready(function(){
        $('.summernote').summernote();
        $('.input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fullscreenImgContainer = document.getElementById('fullscreen-img-container');
    const fullscreenImg = document.getElementById('fullscreen-img');

    document.querySelectorAll('table img').forEach(img => {
        img.addEventListener('click', function(event) {
            event.preventDefault();
            fullscreenImg.src = this.src;
            fullscreenImgContainer.style.display = 'flex';
        });
    });

    fullscreenImgContainer.addEventListener('click', function() {
        fullscreenImgContainer.style.display = 'none'; 
    });
});
</script>

</body>
</html>