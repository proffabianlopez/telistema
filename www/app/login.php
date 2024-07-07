<?php
session_start();
error_log("Inicio de aplicacion");
include('dbConnection.php');
include('Querys/querys.php');

if (!isset($_SESSION['is_login'])) {
  if (isset($_REQUEST['mail']) && isset($_REQUEST['pass'])) { // Asegúrate de que tanto mail como pass están configurados
    $Email = trim($_REQUEST['mail']);
    $Password = trim($_REQUEST['pass']);
    // Preparar la consulta
    $sql = SQL_LOGIN; // Asegúrate de usar la consulta correcta

    // Preparar la sentencia
    if ($stmt = $conn->prepare($sql)) {

      // Vincular parámetros
      $stmt->bind_param("s", $Email);

      // Ejecutar la consulta
      $stmt->execute();

      // Obtener el resultado
      $result = $stmt->get_result();

      // Verificar si se encontró una fila
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($Password, $row['user_password'])) {
          if ($row['state_user'] == 'inactivo') {
            $msg = '<div class="alert alert-warning mt-2" role="alert"> Cuenta inactiva </div>';
          } else if ($row['state_user'] == 'activo') {
            // Usuario autenticado, obtener los datos del usuario
            $_SESSION['user_name'] = $row['name_user'];
            $_SESSION['user_id'] = $row['id_user'];
            $_SESSION['user_surname'] = $row['surname_user'];
            $_SESSION['user_role'] = $row['rol'];
            $_SESSION['user_idRol'] = $row['id_rol'];
            $_SESSION['state_user'] = $row['state_user'];
            $_SESSION['mail'] = $Email;
            $_SESSION['is_login'] = true;

            // Determinar el rol del usuario
            $Rol = $_SESSION['user_idRol'];

            if ($Rol == 1) {
              // Redireccionar a la página del panel de control del administrador
              echo "<script> location.href='Admin/dashboard/dashboard.php'; </script>";
              exit;
            } elseif ($Rol == 2) {
              // Redireccionar a la página del perfil del técnico
              echo "<script> location.href='Technic/dashboard/dashboard.php'; </script>";
              exit;
            }
          }
        } else {
          // Contraseña incorrecta
          $msg = '<div class="alert alert-warning mt-2" role="alert"> Contraseña incorrecta </div>';
        }
      } else {
        // Usuario no encontrado, mostrar mensaje de error
        $msg = '<div class="alert alert-warning mt-2" role="alert"> Ingrese un correo electrónico y una contraseña válidos </div>';
      }
    } else {
      // Error al preparar la consulta
      $msg = '<div class="alert alert-danger mt-2" role="alert"> Error al preparar la consulta </div>';
    }
  } 
} else {
  // Si el usuario ya está autenticado, redirigir al panel de control del administrador
  echo "<script> location.href='Admin/dashboard/dashboard.php'; </script>";
  exit;
}

?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>TELISTEMA | Login</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">


  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="boostrap/node_modules/bootstrap-icons/font/bootstrap-icons.css">

</head>

<body class="gray-bg">


  <div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
      <div>

        <h1 class="logo-name">TL+</h1>

      </div>
      <h3><i class="bi bi-incognito"></i> Acceso Interno</h3>
      <!-- <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views. -->
      <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
      </p>
      <p>Solo Personal Autorizado</p>
      <form class="m-t" role="form" action="" method="POST">

        <div class="form-group">
          <input type="email" class="form-control" name="mail" placeholder="Email" required="">
        </div>

        <div class="form-group password-container">
          <input type="password" id="user_password" class="form-control" name="pass" placeholder="Contraseña" required="">
          <span class="glyphicon glyphicon-eye-open toggle-password"></span>
        </div>
        <button type="submit" class="btn btn-success block full-width m-b">Iniciar Sesión</button>
        <?php if (isset($msg)) {
          echo $msg;
        } ?>

      </form>
      <a class="btn btn-primary block full-width m-b" href="../index.html">Volver a la pagina</a>

    </div>
    </form>
  </div>
  <!-- Mainly scripts -->
  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/passShow.js"></script>

</body>

</html>