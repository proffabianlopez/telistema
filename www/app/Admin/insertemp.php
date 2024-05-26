<?php
session_start();
////////////////////////////////
if($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  
  if($_SESSION['user_role'] != 'admin') {
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
include('../includes/header.php'); 
include('../dbConnection.php');
include('../Querys/querys.php');

if(isset($_REQUEST['submit'])){

  // Checking for Empty Fields
  if(($_REQUEST['name_user'] == "") || ($_REQUEST['phone_user'] == "") || ($_REQUEST['mail'] == "")){
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
      
        if($stmt->execute()){
        // below msg display on form submit success
        $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Agregado Exitosamente! </div>';
      } else {
        // below msg display on form submit failed
        $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Error al agregar! </div>';
      }
    }
  }
?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Agregar Nuevo Técnico</h3>
  <form action="" method="POST">
    <div class="form-group">
      <label for="name_user">Nombre</label>
      <input type="text" class="form-control" id="name_user" name="name_user">
    </div>
    <div class="form-group">
      <label for="phone_user">Teléfono</label>
      <input type="text" class="form-control" id="phone_user" name="phone_user" onkeypress="isInputNumber(event)">
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
      <?php if(isset($msg)) {echo $msg; } ?>
    </div>
  </form>
</div>
<!-- Only Number for input fields -->
<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }
</script>
<?php
include('../includes/footer.php'); 
?>