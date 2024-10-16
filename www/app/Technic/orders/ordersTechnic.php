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
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
          </div>
        </nav>
      </div>
      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
          <h2>Órdenes Asignadas</h2>
          <ol class="breadcrumb">
            <li>
              <a href="../dashboard/dashboard.php">Inicio</a>
            </li>
            <li class="active">
              <strong>Órdenes Asignadas</strong>
            </li>
            <li>
              <a href="historyOrders.php">Historial de Órdenes</a>
            </li>
          </ol>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <br>
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
            $orders = [];
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
              }

              // Función para ordenar las órdenes por prioridad y número de circuito
              function orderByPriorityAndCircuit($orders) {
                $urgentOrders = [];
                $normalOrders = [];

                // Separa las órdenes urgentes y normales
                foreach ($orders as $order) {
                  if ($order['priority'] === 'Urgente') {
                    $urgentOrders[] = $order; // Las órdenes urgentes van al array urgente
                  } else {
                    $normalOrders[] = $order; // Las normales van al array normal
                  }
                }

                // Ordena las órdenes normales por el número de circuito
                usort($normalOrders, function($a, $b) {
                  return $a['circuit_number'] <=> $b['circuit_number'];
                });

                // Combina las órdenes urgentes y las normales ordenadas
                return array_merge($urgentOrders, $normalOrders);
              }

              function displayOrders($orders, $token) {
                $orders = orderByPriorityAndCircuit($orders); 
                $counter = 1; // Inicializa un contador para enumerar los circuitos
                foreach ($orders as $row) {
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $order_datetime = date('d-m-Y', strtotime($row['order_date']));
                    $priority = $row['priority'];
            
                    // Definir estilos de fondo para el recuadro de prioridad
                    $priorityBackgroundStyle = ($priority == 'Urgente') ? 'background-color: #e0091d; padding: 5px;' : 'padding: 5px;';
            
                    // Definir clases para los botones según la prioridad
                    $reportButtonClass = ($priority == 'Urgente') ? 'btn-danger' : 'btn-primary';
                    $detailButtonClass = ($priority == 'Urgente') ? 'btn-danger' : 'btn-primary';
            ?>
                    <div class="col-md-3 order-box">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-imitation">
                                    Orden N° <?php echo $row["id_order"]; ?>
                                </div>
                                <div class="product-desc">
                                    <!-- Aplicar el estilo de fondo solo al texto de la prioridad -->
                                    <span class="product-price" style="<?php echo $priorityBackgroundStyle; ?>">
                                        <?php echo strtoupper($priority); ?>
                                    </span>
                                    <strong>N° De Circuito: <?php echo $counter;?></strong>
                                    <div class="small m-t-xs">
                                        <strong>Fecha: </strong><?php echo $order_datetime; ?><br>
                                        <strong>Dirección: </strong><?php echo $row["address"] . " " . $row["height"]; ?><br>
                                        <strong>Trabajo: </strong><?php echo $row["type_work"]; ?><br>
                                        <strong>Descripción: </strong><?php echo $row["order_description"]; ?>
                                    </div>
                                    <div class="m-t text-right">
                                        <?php
                                        // Botones con colores según la prioridad
                                        echo '<button id="edit-' . $row["id_order"] . '-' . $token . '" data-crud="reports" class="modaledit-btn btn btn-xs ' . $reportButtonClass . '" style="margin-right: 5px">
                                            Reporte
                                        </button>';
                                        echo '<button id="edit-' . $row["id_order"] . '-' . $token . '" data-crud="technicians" class="modaledit-btn btn btn-xs ' . $detailButtonClass . '" style="margin-right: 5px">
                                            Detalle
                                        </button>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    $counter++; // Incrementa el contador para el próximo circuito
                }
            }
            
            
              // Mostrar órdenes
              displayOrders($orders, $token);
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

  <?php include('../../includes/footer.php'); ?>
</body>

</html>
