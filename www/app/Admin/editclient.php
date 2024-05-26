<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ($_SESSION['user_role'] != 'admin') {
    echo "<script> location.href='../includes/404.php'; </script>";
  }
  $rEmail = $_SESSION['mail'];
  $rolUser = $_SESSION['user_role'];
} else {
  echo "<script> location.href='../login.php'; </script>";
}
////////////////////////////////

define('TITLE', 'Clientes');
define('PAGE', 'Clientes');
include ('../dbConnection.php');
include ('../Querys/querys.php');

// Actualización
if (isset($_REQUEST['clientupdate'])) {
  // Verificación de campos vacíos
  if (($_REQUEST['client_name'] == "") || ($_REQUEST['mail'] == "")) {
    // Mensaje mostrado si falta campo requerido
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Complete los campos </div>';
  } else {
    // Asignación de valores de usuario a variables
    $id_client = $_REQUEST['id_client'];
    $name = $_REQUEST['client_name'];
    $lastname = $_REQUEST['client_lastname'];
    $phone = $_REQUEST['phone'];
    $mail = $_REQUEST['mail'];
    $address = $_REQUEST['address'];
    $height = $_REQUEST['height'];
    $floor = $_REQUEST['floor'];
    $departament = $_REQUEST['departament'];

    $sql = SQL_UPDATE_CLIENT;

    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $name, $lastname, $phone, $mail, $address, $height, $floor, $departament, $id_client);

    if ($stmt->execute()) {
      // Mensaje mostrado en caso de éxito en la actualización
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Actualizado con éxito </div>';
    } else {
      // Mensaje mostrado en caso de fallo en la actualización
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo actualizar </div>';
    }
  }
}

?>
<?php
if (isset($_REQUEST['view'])) {

  $id_client = $_REQUEST['id_client'];
  $sql = SQL_CLIENT_BY_ID;
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_client);
  $stmt->execute();

  // Obtener resultados de la consulta
  $result = $stmt->get_result();

  // Verificar si hay resultados
  if ($result->num_rows > 0) {
    // Obtener la fila como un array asociativo
    $row = $result->fetch_assoc();
  } else {
    // Mostrar un mensaje si no se encuentra ningún cliente con el ID proporcionado
    echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningún cliente con ese ID.</div>';
  }

}
?>
<?php include ('../includes/header.php') ?>

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
            <form role="search" class="navbar-form-custom" action="search_results.html">
              <div class="form-group">
                <input type="text" placeholder="Search for something..." class="form-control" name="top-search"
                  id="top-search">
              </div>
            </form>
          </div>
          <ul class="nav navbar-top-links navbar-right">
            <li>
              <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
              </a>
              <ul class="dropdown-menu dropdown-messages">
                <li>
                  <div class="dropdown-messages-box">
                    <a href="profile.html" class="pull-left">
                      <img alt="image" class="img-circle" src="img/a7.jpg">
                    </a>
                    <div class="media-body">
                      <small class="pull-right">46h ago</small>
                      <strong>Mike Loreipsum</strong> started following <strong>Monica
                        Smith</strong>. <br>
                      <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                    </div>
                  </div>
                </li>
                <li class="divider"></li>
                <li>
                  <div class="dropdown-messages-box">
                    <a href="profile.html" class="pull-left">
                      <img alt="image" class="img-circle" src="img/a4.jpg">
                    </a>
                    <div class="media-body ">
                      <small class="pull-right text-navy">5h ago</small>
                      <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica
                        Smith</strong>. <br>
                      <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                    </div>
                  </div>
                </li>
                <li class="divider"></li>
                <li>
                  <div class="dropdown-messages-box">
                    <a href="profile.html" class="pull-left">
                      <img alt="image" class="img-circle" src="img/profile.jpg">
                    </a>
                    <div class="media-body ">
                      <small class="pull-right">23h ago</small>
                      <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                      <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                    </div>
                  </div>
                </li>
                <li class="divider"></li>
                <li>
                  <div class="text-center link-block">
                    <a href="mailbox.html">
                      <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                    </a>
                  </div>
                </li>
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
              </a>
              <ul class="dropdown-menu dropdown-alerts">
                <li>
                  <a href="mailbox.html">
                    <div>
                      <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                      <span class="pull-right text-muted small">4 minutes ago</span>
                    </div>
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="profile.html">
                    <div>
                      <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                      <span class="pull-right text-muted small">12 minutes ago</span>
                    </div>
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="grid_options.html">
                    <div>
                      <i class="fa fa-upload fa-fw"></i> Server Rebooted
                      <span class="pull-right text-muted small">4 minutes ago</span>
                    </div>
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <div class="text-center link-block">
                    <a href="notifications.html">
                      <strong>See All Alerts</strong>
                      <i class="fa fa-angle-right"></i>
                    </a>
                  </div>
                </li>
              </ul>
            </li>


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

          <h2>Clientes</h2>
        </div>
        <div class="col-lg-2">

        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

          <div class="col-lg-5">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Actualizar Cliente</h5>

              </div>
              <div class="ibox-content">

                <form class="mx-5" method="POST">
                  <form action="" method="POST">
                    <div class="form-group">
                      <label for="client_name">Id Cliente</label>
                      <input type="text" class="form-control" id="id_client" name="id_client" value="<?php if (isset($row['id_client'])) {
                        echo $row['id_client'];
                      } ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="client_name">Nombre</label>
                      <input type="text" class="form-control" id="client_name" name="client_name" value="<?php if (isset($row['client_name'])) {
                        echo $row['client_name'];
                      } ?>">
                    </div>
                    <div class="form-group">
                      <label for="client_lastname">Apellido</label>
                      <input type="text" class="form-control" id="client_lastname" name="client_lastname" value="<?php if (isset($row['client_lastname'])) {
                        echo $row['client_lastname'];
                      } ?>">
                    </div>
                    <div class="form-group">
                      <label for="phone">Telefono</label>
                      <input type="text" class="form-control" id="phone" name="phone" value="<?php if (isset($row['phone'])) {
                        echo $row['phone'];
                      } ?>">
                    </div>
                    <div class="form-group">
                      <label for="mail">Email</label>
                      <input type="email" class="form-control" id="mail" name="mail" value="<?php if (isset($row['mail'])) {
                        echo $row['mail'];
                      } ?>">
                    </div>
                    <div class="form-group">
                      <label for="address">Dirección</label>
                      <input type="text" class="form-control" id="address" name="address" value="<?php if (isset($row['address'])) {
                        echo $row['address'];
                      } ?>">
                    </div>
                    <div class="form-group">
                      <label for="height">Altura</label>
                      <input type="text" class="form-control" id="height" name="height" value="<?php if (isset($row['height'])) {
                        echo $row['height'];
                      } ?>">
                    </div>
                    <div class="form-group">
                      <label for="floor">Piso</label>
                      <input type="text" class="form-control" id="floor" name="floor" value="<?php if (isset($row['floor'])) {
                        echo $row['floor'];
                      } ?>">
                    </div>
                    <div class="form-group">
                      <label for="departament">Departamento</label>
                      <input type="text" class="form-control" id="departament" name="departament" value="<?php if (isset($row['departament'])) {
                        echo $row['departament'];
                      } ?>">
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-danger" id="clientupdate"
                        name="clientupdate">Actualizar</button>
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

</html>