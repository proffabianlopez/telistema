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

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
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
                    Prioridad: <?php echo $row["priority"]; ?>
                  </span>
                  <small class="text-muted">Fecha : <?php echo $order_datetime; ?></small>
                  <div class="small m-t-xs">
                    Dirección: <?php echo $row["address"] . " " . $row["height"]; ?><br>
                    Servidor: <?php echo $row["order_server"]; ?><br>
                    Descripción: <?php echo $row["order_description"]; ?>
                    
                  </div>
                  <div class="m-t text-right">
                  <form action="orderInfo.php" method="POST" style="display:inline;">
    <input type="hidden" name="id_order" value="<?php echo $row['id_order']; ?>">
    <button class="btn btn-xs btn-outline btn-primary" type="submit" name="view" value="View">
        Info <i class="fa fa-long-arrow-right"></i>
    </button>
</form>

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
<?php
include('../../includes/footer.php');
?>
</body>
</html>
