<?php
session_start();
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ( $_SESSION['user_idRol'] != 2) {
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

define('TITLE', 'Órdenes');
define('PAGE', 'Ordenes technic');

include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../../includes/header.php');


?>
<html>
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
          <h2>Historial de Órdenes</h2>
          <ol class="breadcrumb">
                    <li>
                        <a href="../dashboard/dashboard.php">Inicio</a>
                    </li>
                    <li>
                        <a href="ordersTechnic.php">Órdenes de trabajo</a>
                    </li>
                    <li class="active">
                        <strong>Historial de Órdenes</strong>
                    </li>

                </ol>
        </div>
      </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Historial de Órdenes de trabajo</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a  href="ordersTechnic.php">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
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
                                        echo ' <table class="table table-striped table-bordered table-hover dataTables-example" >
                                                    <thead>
                                                        <tr>
                                                            <th data-toggle="true">Órden</th>
                                                            <th data-hide="all">Cliente</th>
                                                            <th data-toggle="true">Fecha</th>
                                                            <th data-toggle="true">Descripción</th>
                                                            <th data-hide="all">Dirección</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        ';
                                                    while ($row = $result->fetch_assoc()) {
                                                        $order_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $row['order_date']);
                                                            $order_datetime_formatted = $order_datetime->format('d/m/Y H:i');
                                                            $floor = isset($row["floor"]) && $row["floor"] !== '' ? $row["floor"] : '-';
                                                            $departament = isset($row["departament"]) && $row["departament"] !== '' ? $row["departament"] : '-';
                                                        
                                                            echo '<tr>';
                                                            echo '<td>' . $row["id_order"] . '</td>';
                                                            echo '<td>' . $row["client_name"] . ' ' . $row['client_lastname'] . '</td>';
                                                            echo '<td>' . $order_datetime_formatted . '</td>';
                                                            echo '<td>' . $row["order_description"] . '</td>';
                                                            echo '<td>' . $row["address"] . ' ' . $row["height"] . '</td>';
                                                            echo '<td>'  . $row["state_order"] .  '</td>';
                                                        }
                                                        echo '</tbody>
                                                    </table>';
                                                }
                                    }else {
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
        <?php
        include('../../includes/footer.php');
        ?>
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'HistorialOrdenes'},
                    {extend: 'pdf', title: 'HistorialOrdenes'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });
    </script>
</body>
</html>
