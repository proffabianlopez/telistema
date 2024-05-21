<?php
session_start();
include('dbConnection.php');
include('Querys/querys.php');

if(!isset($_SESSION['is_login'])){
  if(isset($_REQUEST['mail'])){
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
    if($result->num_rows == 1){
       $row = $result->fetch_assoc();
        if($row['state_user'] == 'inactivo'){
           $msg = '<div class="alert alert-warning mt-2" role="alert"> Cuenta inactiva </div>';
        }else if($row['state_user'] == 'activo'){
          // Usuario autenticado, obtener los datos del usuario
          $_SESSION['user_name'] = $row['name_user'];
          $_SESSION['user_role'] = $row['rol'];
          $_SESSION['state_user'] = $row['state_user'];
          $_SESSION['mail'] = $Email;
          $_SESSION['is_login'] = true;
          
          // Determinar el rol del usuario
          $Rol = $_SESSION['user_role'];
          
          if($Rol == 'admin'){             
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
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="css/all.min.css">

  <style>
    .custom-margin {
         margin-top: 8vh;
      }
   </style>
  <title>Login</title>
</head>

<body>
  <div class="mb-3 text-center mt-5" style="font-size: 30px;">
    <i class="fas fa-stethoscope"></i>
    <span>Sistema de gestión de mantenimiento en línea</span>
  </div>
  <p class="text-center" style="font-size: 20px;"> <i class="fas fa-user-secret text-danger"></i> <span>Acceso Interno</span>
  </p>
  <div class="container-fluid mb-5">
    <div class="row justify-content-center custom-margin">
      <div class="col-sm-6 col-md-4">
        <form action="" class="shadow-lg p-4" method="POST">
          <div class="form-group">
            <i class="fas fa-user"></i><label for="mail" class="pl-2 font-weight-bold">Email</label><input type="email"
              class="form-control" placeholder="Email" name="mail">
            <!--Add text-white below if want text color white-->
            <small class="form-text">Nunca compartiremos su correo electrónico con nadie más.</small>
          </div>
          <div class="form-group">
            <i class="fas fa-key"></i><label for="pass" class="pl-2 font-weight-bold">Contraseña</label><input type="password"
              class="form-control" placeholder="contraseña" name="pass">
          </div>
          <button type="submit" class="btn btn-outline-danger mt-3 btn-block shadow-sm font-weight-bold">Iniciar Sesión</button>
          <?php if(isset($msg)) {echo $msg; } ?>
        </form>
        <div class="text-center"><a class="btn btn-info mt-3 shadow-sm font-weight-bold" href="../index.php">Ir al Inicio</a></div>
      </div>
    </div>
  </div>

  <!-- Boostrap JavaScript -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/all.min.js"></script>
</body>

</html>