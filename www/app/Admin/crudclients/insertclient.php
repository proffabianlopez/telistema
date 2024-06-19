<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ($_SESSION['user_role'] != 'admin') {
    echo "<script> location.href='../../includes/404.php'; </script>";
  }
  $rEmail = $_SESSION['mail'];
  $rolUser = $_SESSION['user_role'];
} else {
  echo "<script> location.href='../../login.php'; </script>";
}
////////////////////////////////

define('TITLE', 'Agregar Nuevo Cliente');
define('PAGE', 'Clientes');

include('../../dbConnection.php');
include('../../Querys/querys.php');

if (isset($_REQUEST['reqsubmit'])) {
  // Verifica si hay campos vacíos
  if (($_REQUEST['client_name'] == "") || ($_REQUEST['client_lastname'] == "") || ($_REQUEST['phone'] == "") || ($_REQUEST['mail'] == "") || ($_REQUEST['address'] == "") || ($_REQUEST['height'] == "") || ($_REQUEST['floor'] == "") || ($_REQUEST['departament'] == "")) {
    // Muestra un mensaje si hay campos vacíos
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Completa todos los campos </div>';
  } else {
    // Asigna los valores del usuario a variables
    $name = $_REQUEST['client_name'];
    $lastname = $_REQUEST['client_lastname'];
    $phone = $_REQUEST['phone'];
    $mail = $_REQUEST['mail'];
    $address = $_REQUEST['address'];
    $height = $_REQUEST['height'];
    $floor = $_REQUEST['floor'];
    $departament = $_REQUEST['departament'];
    $id_state = $_REQUEST['id_state_user'];
    $id_state = 1; // ¿Este valor siempre será 1?

    // Prepara la consulta
    $stmt = $conn->prepare(SQL_INSERT_CLIENT);

    // Asocia parámetros y ejecuta la consulta
    $stmt->bind_param("ssssssssi", $name, $lastname, $phone, $mail, $address, $height, $floor, $departament, $id_state);

    if ($stmt->execute()) {
      // Muestra un mensaje si la inserción fue exitosa
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Agregado exitosamente </div>';
    } else {
      // Muestra un mensaje si la inserción falló
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo agregar </div>';
    }
  }
}
?>
<?php include('../../includes/header.php') ?>

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
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          </div>
          <ul class="nav navbar-top-links navbar-right">
            <li>
              <a href="login.html">
                <i class="fa fa-sign-out"></i> Cerrar Sesión
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
                <h5>Ingresar Nuevo clientes</h5>

              </div>
              <div class="ibox-content">
                <form action="" method="POST">
                  <div class="form-group">
                    <label for="client_name">Nombre</label>
                    <input type="text" class="form-control" id="client_name" name="client_name">
                  </div>
                  <div class="form-group">
                    <label for="client_lastname">Apellido</label>
                    <input type="text" class="form-control" id="client_lastname" name="client_lastname">
                  </div>
                  <div class="form-group">
                    <label for="phone">Telefono</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                  </div>
                  <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="email" class="form-control" id="mail" name="mail">
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
          <strong>Copyright</strong> Telistema &copy; 2024
        </div>
      </div>

    </div>
  </div>



  <?php include('../../includes/footer.php'); ?>

</body>

</html>