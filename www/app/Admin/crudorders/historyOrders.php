<?php
session_start();
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ( $_SESSION['user_idRol'] != 1) {
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
define('PAGE', 'Ordenes Admin');

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
          <ul class="nav navbar-top-links navbar-right">
            <li>
              
            </li>
          </ul>
        </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
          <h2>Historial de Ordenes</h2>
          <ol class="breadcrumb">
                    <li>
                        <a href="../dashboard/dashboard.php">Inicio</a>
                    </li>
                    <li>
                        <a href="order.php">Ordenes de trabajo</a>
                    </li>
                    <li class="active">
                        <strong>Historial de Ordenes</strong>
                    </li>

                </ol>
        </div>
      </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Historial de Ordenes de trabajo</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a  href="ordersAdmin.php">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <?php
                                if (isset($_SESSION['user_id'])) {
                                  $stmt = $conn->prepare(SQL_ALL_ORDERS_MONTH);
                                  if ($stmt === false) {
                                      die('Error en la preparación de la consulta: ' . $conn->error);
                                  }
                                  
                                  // Ejecuta la consulta sin parámetros
                                  if (!$stmt->execute()) {
                                      die('Error en la ejecución de la consulta: ' . $stmt->error);
                                  }
                                  
                                  $result = $stmt->get_result();
                                  if ($result->num_rows > 0) {
                                      echo '<table class="table table-striped table-bordered table-hover dataTables-example">';
                                      echo '<thead><tr><th>N° de Orden</th><th>Cliente</th><th>Fecha</th><th>Descripción</th><th>Dirección</th><th>Estado</th><th>Tecnico</th></tr></thead>';
                                      echo '<tbody>';
                                      
                                      while ($row = $result->fetch_assoc()) {
                                          $order_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $row['order_date']);
                                          $order_datetime_formatted = $order_datetime->format('d/m/Y H:i');
                                          $floor = $row["floor"] ? $row["floor"] : '-';
                                          $departament = $row["departament"] ? $row["departament"] : '-';
                                          
                                          echo '<tr>';
                                          echo '<td>' . $row["id_order"] . '</td>';
                                          echo '<td>' . $row["client_name"] . ' ' . $row['client_lastname'] . '</td>';
                                          echo '<td>' . $order_datetime_formatted . '</td>';
                                          echo '<td>' . $row["order_description"] . '</td>';
                                          echo '<td>' . $row["address"] . ' ' . $row["height"] . '</td>';
                                          echo '<td>' . $row["state_order"] . '</td>';
                                          echo '<td>' . $row["name_user"] . ' ' . $row["surname_user"] . '</td>';
                                          echo '</tr>';
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