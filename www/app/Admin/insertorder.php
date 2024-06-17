<?php
session_start();

if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ($_SESSION['user_role'] != 'admin') {
    echo "<script> location.href='../includes/404.php'; </script>";
  }
  $rEmail = $_SESSION['mail'];
  $rolUser = $_SESSION['user_role'];
} else {
  echo "<script> location.href='../login.php'; </script>";
}

define('TITLE', 'Ordenes');
define('PAGE', 'Ordenes');
include ('../dbConnection.php');
include ('../Querys/querys.php');
include ('../includes/header.php');
include ('generate_config.php');

if (isset($_SESSION['id_client'])) {
  $id_client = $_SESSION['id_client'];
  if (isset($_POST['reqsubmit'])) {
      if ( empty(trim($_POST['order_date'])) || empty(trim($_POST['order_hour'])) || empty(trim($_POST['order_description'])) || empty(trim($_POST['order_server'])) || empty(trim($_POST['address'])) || empty(trim($_POST['height'])) || empty(trim($_POST['floor'])) || empty(trim($_POST['departament'])) || empty(trim($_POST['id_priority'])) || empty(trim($_POST['id_material'])) || empty(trim($_POST['admin_id'])) || empty(trim($_POST['technic_id']))
      ) {
          $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Completa todos los campos </div>';
      } else {
        
          $order_date = $_POST['order_date'];
          $order_hour = $_POST['order_hour'];
          $order_description = $_POST['order_description'];
          $order_server = $_POST['order_server'];
          $address = capitalizeWords($_POST['address']);
          $height = $_POST['height'];
          $floor = trim($_POST['floor']);
          $departament = trim($_POST['departament']);
          $id_priority = $_POST['id_priority'];
          $id_material = $_POST['id_material'];
          $id_state_order = 3;
          $admin_id = $_POST['admin_id'];
          $technic_id = $_POST['technic_id'];
          
          $stmt = $conn->prepare(SQL_INSERT_ORDER);
          if ($stmt === false) {
              die('Error en la preparación de la consulta: ' . $conn->error);
          }
          $stmt->bind_param("sssisissiiiiii", $order_date, $order_hour, $order_description, $order_server, $address, $height, $floor, $departament, $id_client, $id_priority, $id_material, $id_state_order,$admin_id,$technic_id);
          if ($stmt->execute()) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Agregado exitosamente </div>';
          } else {
              $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo agregar </div>';
          }
      }
  }
} else {
  $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> ID de cliente no especificado </div>';
} 
?>
<body>
  <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <?php include ('../includes/menu.php') ?>
      </div>
    </nav>
    <div id="page-wrapper" class="gray-bg">
      <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
          <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          </div>
          <ul class="nav navbar-top-links navbar-right">
            <li>
              <a href="login.html">
                <i class="fa fa-sign-out"></i> Cerrar Sección
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
          <h2>Ordenes</h2>
        </div>
        <div class="col-lg-2">
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-5">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Ingresar una Nueva Orden</h5>
              </div>
              <div class="ibox-content">
                <form action="" method="POST">
                  <div class="form-group">
                    <label for="admin_id">Administrador</label>
                    <?php
                    if ($rolUser != 'admin') {
                      $id_rol = 2;
                    } else {
                      $id_rol = 1;
                    }
                    $stmt = $conn->prepare(SQL_SELECT_ADMINS_ORDER_BY_ID);
                    $stmt->bind_param("i", $id_rol);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                      $row_admin = $result->fetch_assoc();
                      $admin_id = $row_admin["id_user"];
                      $admin_name = $row_admin["name_user"];
                      $admin_lastname = $row_admin["surname_user"];
                    }
                    ?>
                    <input type="text" class="form-control" id="admin_id_display" value="<?php echo htmlspecialchars($admin_name . ' ' . $admin_lastname); ?>" readonly>
                    <input type="hidden" id="admin_id" name="admin_id" value="<?php echo htmlspecialchars($admin_id); ?>">
                  </div>
                  <div class="form-group">
                    <label for="id_client">Cliente</label>
                    <?php
                  $stmt = $conn->prepare(SQL_SELECT_CLIENT_BY_ID);
                  $stmt->bind_param("i", $id_client);
                  $stmt->execute();
                  $result = $stmt->get_result();
                
                  if ($result->num_rows > 0) {
                    $row_client = $result->fetch_assoc();
                    $id_client = $row_client["id_client"];
                    $client_name = $row_client["client_name"];
                    $client_lastname = $row_client["client_lastname"];
                  } 
                ?>
                    <input type="text" class="form-control" id="id_client" name="id_client" value="<?php echo htmlspecialchars($client_name . ' ' . $client_lastname); ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="order_date">Fecha</label>
                    <?php
                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $today = date('Y-m-d');
                    $maxDate = date('Y-m-d', strtotime('+1 years'));
                    ?>
                    <input type="date" class="form-control" id="order_date" name="order_date" min="<?php echo $today; ?>" max="<?php echo $maxDate; ?>">
                  </div>
                  <div class="form-group">
                    <label for="order_hour">Hora</label>
                    <input type="time" class="form-control" id="order_hour" name="order_hour">
                  </div>
                  <div class="form-group">
                    <label for="order_description">Descripcion</label>
                    <input type="text" class="form-control" id="order_description" name="order_description">
                  </div>
                  <div class="form-group">
                    <label for="order_server">Servidor</label>
                    <input type="number" class="form-control" id="order_server" name="order_server">
                  </div>
                  <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address">
                  </div>
                  <div class="form-group">
                    <label for="height">Altura</label>
                    <input type="text" class="form-control" id="height" name="height">
                  </div>
                  <div class="form-group">
                    <label for="floor">Piso</label>
                    <input type="text" class="form-control" id="floor" name="floor">
                  </div>
                  <div class="form-group">
                    <label for="departament">Departamento</label>
                    <input type="text" class="form-control" id="departament" name="departament">
                  </div>
                  <div class="form-group">
                    <label for="id_priority">Prioridad</label>
                    <select name="id_priority" id="id_priority" class="form-control">
                      <?php
                      $priority = $row['id_priority'];
                      $stmt = $conn->prepare(SQL_SELECT_PRIORITYS_ORDER_BY_ID);
                      $stmt->bind_param("i", $priority);
                      $stmt->execute();
                      $result = $stmt->get_result();
                      if ($result->num_rows > 0) {
                        $row_state = $result->fetch_assoc();
                        $id_priority = $row_state["id_priority"];
                        $name_state = $row_state["priority"];
                      } else {
                        $id_priority = 1; 
                      }

                      $stmt = $conn->prepare(SQL_SELECT_PRIORITYS_ORDERS);
                      $stmt->execute();
                      $rows = $stmt->get_result();
                      foreach ($rows as $state) {
                        $priorityName = $state["priority"];
                        $priorityId = $state["id_priority"];
                        $selected = ($priorityId == $id_priority) ? "selected" : "";
                        echo "<option value='$priorityId' $selected>$priorityName</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="technic_id">Tecnico Asignado</label>
                    <select name="technic_id" id="technic_id" class="form-control">
                      <?php
                      $user = $row['id_user'];
                      $stmt = $conn->prepare(SQL_SELECT_TECNS_ORDER_BY_ID);
                      $stmt->bind_param("i", $user);
                      $stmt->execute();
                      $result = $stmt->get_result();

                      if ($result->num_rows > 0) {
                      $row_user = $result->fetch_assoc();
                      $technic_id = $row_user["id_user"];
                      $name_technic = $row_user["name_user"];
                      }

                      $stmt = $conn->prepare(SQL_SELECT_TECNS_ORDERS);
                      $stmt->execute();
                      $rows = $stmt->get_result();
                      foreach ($rows as $user) {
                        if ($user["id_rol"] == 2) { 
                          $technicName = $user["name_user"] . ' ' . $user["surname_user"];
                          $technicId = $user["id_user"];
                          $selected = ($technicId == $technic_id) ? "selected" : "";
                          echo "<option value='$technicId' $selected>$technicName</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="id_material">Material</label>
                    <select name="id_material" id="id_material" class="form-control">
                      <?php
                      $material = $row['id_material'];
                      $stmt = $conn->prepare(SQL_SELECT_MATERIALS_ORDER_BY_ID);
                      $stmt->bind_param("i", $material);
                      $stmt->execute();
                      $result = $stmt->get_result();

                      if ($result->num_rows > 0) {
                        $row_material = $result->fetch_assoc();
                        $id_material = $row_material["id_material"];
                        $name_material = $row_material["material_name"];
                        
                      }
                      $stmt = $conn->prepare(SQL_SELECT_MATERIALS_ORDERS);
                      $stmt->execute();
                      $rows = $stmt->get_result();
                      foreach ($rows as $material) {
                        $materialName = $material["material_name"];
                        $materialId = $material["id_material"];
                        $selected = ($materialId == $id_material) ? "selected" : "";
                        echo "<option value='$materialId' $selected>$materialName</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-danger" id="reqsubmit" name="reqsubmit">Agregar</button>
                    <a href="clients.php" class="btn btn-secondary">Cerrar</a>
                  </div>
                  <?php if (isset($msg)) {
                    echo $msg;
                  } ?>
                </form>
              </div>
            </div>
          </div>
          </div>
        </div>
        <div class="footer">
          <div>
            <strong>Copyright</strong>  Telistema &copy; 2024
          </div>
        </div>
      </div>
    </div>
    <?php include ('../includes/footer.php'); ?>
</body>
</html> |