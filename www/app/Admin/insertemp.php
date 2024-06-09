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
include ('generate_config.php');
include ('endEmail.php');

$passwordGenerate = generatePassword();
if (isset($_REQUEST['submit'])) {

  // // Checking for Empty Fields

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name_user"])) {
      $msg = '<div class="alert alert-danger" role="alert">El campo Nombre es obligatorio </div>';
    } elseif (empty($_POST["surname_user"])) {
      $msg .= '<div class="alert alert-danger" role="alert">El campo Apellido es obligatorio </div>';
    } elseif (empty($_POST["user_password"])) {
      $msg .= '<div class="alert alert-danger" role="alert">Contraseña no generada </div>';
    } elseif (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
      $msg .= '<div class="alert alert-danger" role="alert">Correo electrónico no válido </div>';
    } else {
      $name = capitalizeWords($_REQUEST['name_user']);
      $surname = capitalizeWords($_REQUEST['surname_user']);
      $phone = trim($_REQUEST['phone_user']);
      $mail = trim($_REQUEST['mail']);
      $pass = password_hash($_REQUEST['user_password'], PASSWORD_DEFAULT);
      $state = 1;
      $role = 2;

      // Verifica si el correo ya existe en la base de datos
      $stmt = $conn->prepare(SQL_SELECT_TECHNIC_BY_EMAIL_STATE_ROL);
      $stmt->bind_param("s", $mail);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        $stmt->bind_result($existing_role, $existing_state);
        $stmt->fetch();

        if ($existing_state == 2) {
          // Actualizar usuario si está marcado como eliminado
          $update_stmt = $conn->prepare(SQL_UPDATE_TECHNIC_BY_EMAIL);
          $update_stmt->bind_param("ssssiis", $name, $surname, $phone, $pass, $state, $role, $mail);

          if ($update_stmt->execute()) {
            $result = enviarCorreoYRegistrar($name, $mail, $_POST["user_password"], $phone);
            if ($result['status'] == 'success') {
              $msg .= '<div class="alert alert-success" role="alert">' . $result['message'] . '</div>';
            } else {
              $msg .= '<div class="alert alert-danger" role="alert"> Datos registrados pero:' . $result['message'] . '</div>';
            }
          } else {
            $msg .= '<div class="alert alert-danger" role="alert"> Error al agregar! </div>';
          }
        } else {
          $msg = '<div class="alert alert-danger" role="alert">El correo ya existe en la base de datos con el Rol: ' . $existing_role . '</div>';
        }
      } else {
        // Prepara la consulta para insertar el nuevo usuario
        $stmt = $conn->prepare(SQL_INSERT_TECHNIC);
        $stmt->bind_param("sssssii", $name, $surname, $phone, $mail, $pass, $state, $role);

        if ($stmt->execute()) {
          $result = enviarCorreoYRegistrar($name, $mail, $_POST["user_password"], $phone);
          if ($result['status'] == 'success') {
            $msg .= '<div class="alert alert-success" role="alert">' . $result['message'] . '</div>';
          } else {
            $msg .= '<div class="alert alert-danger" role="alert">' . $result['message'] . '</div>';
          }
        } else {
          $msg .= '<div class="alert alert-danger" role="alert"> Error al agregar! </div>';
        }
      }
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
                    <label for="name_user">Apellido</label>
                    <input type="text" class="form-control" id="surname_user" name="surname_user">
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
                  <div style="display: none" class="form-group password-container">
                    <label for="user_password">Contraseña</label>
                    <input type="password" class="form-control" id="user_password" name="user_password"
                      value="<?php echo $passwordGenerate; ?>" readonly>
                    <span class="glyphicon glyphicon-eye-open toggle-password"></span>
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
                <div class="p-xxs font-italic bg-muted border-top-bottom text "> <spn class="font-bold" >NOTA:</spn>Al agregar un nuevo Técnico se enviaria al email las credenciales para que pueda iniciar sesión. El sistema genera automaticamente una contraseña</div>
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