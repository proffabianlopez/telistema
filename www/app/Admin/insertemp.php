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

define('TITLE', 'Agregar Técnicos');
define('PAGE', 'Técnicos');
include ('../dbConnection.php');
include ('../Querys/querys.php');

if (isset($_REQUEST['submit'])) {

  // Checking for Empty Fields
  if (($_REQUEST['name_user'] == "") || ($_REQUEST['phone_user'] == "") || ($_REQUEST['mail'] == "")) {
    // msg displayed if required field missing
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
  } else {

    $name = $_REQUEST['name_user'];
    $phone = $_REQUEST['phone_user'];
    $mail = $_REQUEST['mail'];
    $pass = $_REQUEST['user_password'];
    $state = 1;
    $role = 2;

    // Prepara la consulta
    $stmt = $conn->prepare(SQL_INSERT_TECHNIC);
    // Asocia parámetros y ejecuta la consulta
    $stmt->bind_param("ssssii", $name, $phone, $mail, $pass, $state, $role);

    if ($stmt->execute()) {
      // below msg display on form submit success
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Agregado Exitosamente! </div>';
    } else {
      // below msg display on form submit failed
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Error al agregar! </div>';
    }
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

          <h2>Técnicos</h2>
        </div>
        <div class="col-lg-2">

        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

          <div class="col-lg-5">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Ingresar Nuevo Técnico</h5>

              </div>
              <div class="ibox-content">
                <form action="" method="POST">
                  <div class="form-group">
                    <label for="name_user">Nombre</label>
                    <input type="text" class="form-control" id="name_user" name="name_user">
                  </div>
                  <div class="form-group">
                    <label for="phone_user">Teléfono</label>
                    <input type="text" class="form-control" id="phone_user" name="phone_user"
                      onkeypress="isInputNumber(event)">
                  </div>
                  <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="email" class="form-control" id="mail" name="mail">
                  </div>
                  <div class="form-group">
                    <label for="user_password">Contraseña</label>
                    <input type="password" class="form-control" id="user_password" name="user_password">
                  </div>
                  <br>
                  <div class="text-center">
                    <button type="submit" class="btn btn-danger" id="submit" name="submit">Agregar</button>
                    <a href="technician.php" class="btn btn-secondary">Cerrar</a>
                  </div>
                  <div class="text-center">
                    <?php if (isset($msg)) {
                      echo $msg;
                    } ?>
                  </div>
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
  <!-- Only Number for input fields -->
  <script>
    function isInputNumber(evt) {
      var ch = String.fromCharCode(evt.which);
      if (!(/[0-9]/.test(ch))) {
        evt.preventDefault();
      }
    }
  </script>

</body>

</html>