<?php
session_start();
include ('dbConnection.php');
include ('Querys/querys.php');

if (!isset($_SESSION['is_login'])) {
  if (isset($_REQUEST['mail'])) {
    $Email = trim($_REQUEST['mail']);
    $Password = trim($_REQUEST['pass']);

    // Preparar la consulta
    $sql = SQL_LOGIN;

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ss", $Email, $Password);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si se encontró una fila
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      if ($row['state_user'] == 'inactivo') {
        $msg = '<div class="alert alert-warning mt-2" role="alert"> Cuenta inactiva </div>';
      } else if ($row['state_user'] == 'activo') {
        // Usuario autenticado, obtener los datos del usuario
        $_SESSION['user_name'] = $row['name_user'];
        $_SESSION['user_role'] = $row['rol'];
        $_SESSION['state_user'] = $row['state_user'];
        $_SESSION['mail'] = $Email;
        $_SESSION['is_login'] = true;

        // Determinar el rol del usuario
        $Rol = $_SESSION['user_role'];

        if ($Rol == 'admin') {
          // Redireccionar a la página del panel de control del administrador
          echo "<script> location.href='Admin/dashboard.php'; </script>";
          exit;

        } elseif ($Rol == 'technic') {
          // Redireccionar a la página del perfil del técnico
          echo "<script> location.href='Technic/TechnicProfile.php'; </script>";
          exit;
        }
      }
    } else {
      // Usuario no encontrado, mostrar mensaje de error
      $msg = '<div class="alert alert-warning mt-2" role="alert"> Ingrese un correo electrónico y una contraseña válidos </div>';
    }
  }
} else {
  // Si el usuario ya está autenticado, redirigir al panel de control del administrador
  echo "<script> location.href='Admin/dashboard.php'; </script>";
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
            <p>Solo Peronal Autorizado</p>
            <form class="m-t" role="form" action="" method="POST">
                
            <div class="form-group">
                    <input type="email" class="form-control" name="mail" placeholder="Email" required="">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="pass" placeholder="Contraseña" required="">
                </div>
                <button type="submit" class="btn btn-success block full-width m-b">Login</button>
                <?php if(isset($msg)) {echo $msg; } ?>

            </form>
            <a  class="btn btn-danger block full-width m-b" href="../index.html">Volver a la pagina</a>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
