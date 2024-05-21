<?php  
session_start();  
define('TITLE', 'Actualizar Clientes');
define('PAGE', 'Actualizar Datos');
include('../includes/header.php'); 
include('../dbConnection.php');
include('../Querys/querys.php');

 if(isset($_SESSION['is_login'])){
  $mail = $_SESSION['mail'];
 } else {
  echo "<script> location.href='login.php'; </script>";
 }
 // Actualización
if(isset($_REQUEST['clientupdate'])){
  // Verificación de campos vacíos
  if(($_REQUEST['client_name'] == "") || ($_REQUEST['mail'] == "")){
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
      
        if($stmt->execute()){
            // Mensaje mostrado en caso de éxito en la actualización
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Actualizado con éxito </div>';
        } else {
            // Mensaje mostrado en caso de fallo en la actualización
            $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo actualizar </div>';
        }
    }
}

 ?>
<div class="col-sm-6 mt-5  mx-3 jumbotron">
  <h3 class="text-center">Actualizar Detalles de Cliente</h3>
  <?php
  if(isset($_REQUEST['view'])){

    $id_client = $_REQUEST['id_client'];
    $sql = SQL_CLIENT_BY_ID;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_client);
    $stmt->execute();
    
    // Obtener resultados de la consulta
    $result = $stmt->get_result();
    
    // Verificar si hay resultados
    if($result->num_rows > 0) {
        // Obtener la fila como un array asociativo
        $row = $result->fetch_assoc();
    } else {
        // Mostrar un mensaje si no se encuentra ningún cliente con el ID proporcionado
        echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningún cliente con ese ID.</div>';
    }
    
  }
  ?>
  <form action="" method="POST">
    <div class="form-group">
        <label for="client_name">Id Cliente</label>
        <input type="text" class="form-control" id="id_client" name="id_client" value="<?php if(isset($row['id_client'])) {echo $row['id_client']; }?>"readonly>
      </div>
    <div class="form-group">
      <label for="client_name">Nombre</label>
      <input type="text" class="form-control" id="client_name" name="client_name" value="<?php if(isset($row['client_name'])) {echo $row['client_name']; }?>">
    </div>
    <div class="form-group">
      <label for="client_lastname">Apellido</label>
      <input type="text" class="form-control" id="client_lastname" name="client_lastname" value="<?php if(isset($row['client_lastname'])) {echo $row['client_lastname']; }?>">
    </div>
    <div class="form-group">
      <label for="phone">Telefono</label>
      <input type="text" class="form-control" id="phone" name="phone"value="<?php if(isset($row['phone'])) {echo $row['phone']; }?>">
    </div>
    <div class="form-group">
      <label for="mail">Email</label>
      <input type="email" class="form-control" id="mail" name="mail"value="<?php if(isset($row['mail'])) {echo $row['mail']; }?>">
    </div>
    <div class="form-group">
      <label for="address">Dirección</label>
      <input type="text" class="form-control" id="address" name="address"value="<?php if(isset($row['address'])) {echo $row['address']; }?>">
    </div>
    <div class="form-group">
      <label for="height">Altura</label>
      <input type="text" class="form-control" id="height" name="height"value="<?php if(isset($row['height'])) {echo $row['height']; }?>">
    </div>
    <div class="form-group">
      <label for="floor">Piso</label>
      <input type="text" class="form-control" id="floor" name="floor"value="<?php if(isset($row['floor'])) {echo $row['floor']; }?>">
    </div>
    <div class="form-group">
      <label for="departament">Departamento</label>
      <input type="text" class="form-control" id="departament" name="departament"value="<?php if(isset($row['departament'])) {echo $row['departament']; }?>">
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-danger" id="clientupdate" name="clientupdate">Actualizar</button>
      <a href="clients.php" class="btn btn-secondary">Cerrar</a>
    </div>
    <?php if(isset($msg)) {echo $msg; } ?>
  </form>
</div>

<?php
include('../includes/footer.php'); 
?>