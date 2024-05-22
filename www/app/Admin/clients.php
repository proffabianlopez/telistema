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

define('TITLE', 'Clientes');
define('PAGE', 'Clientes');
include('../includes/header.php'); 
include('../dbConnection.php');
include('../Querys/querys.php');

?>
<div class="col-sm-9 col-md-10 mt-5 text-center">
  <!--Table-->
  <p class=" bg-dark text-white p-2">Lista de Clientes</p>
  <?php

  $stmt = $conn->prepare(SQL_FROM_CLIENTS);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if($result->num_rows > 0){
    echo '<table class="table">
    <thead>
    <tr>
      <th scope="col">ID Cliente</th>
      <th scope="col">Nombre</th>
      <th scope="col">Apellido</th>
      <th scope="col">Teléfono</th>
      <th scope="col">Email</th>
      <th scope="col">Dirección</th>
      <th scope="col">Altura</th>
      <th scope="col">Piso</th>
      <th scope="col">Dpto.</th>
      <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>';
    while($row = $result->fetch_assoc()){

        echo 
          '<tr>';
            echo '<th scope="row">'.$row["id_client"].'</th>';
            echo '<td>'. $row["client_name"].'</td>';
            echo '<td>'.$row["client_lastname"].'</td>';
            echo '<td>'.$row["phone"].'</td>';
            echo '<td>'.$row["mail"].'</td>';
            echo '<td>'.$row["address"].'</td>';
            echo '<td>'.$row["height"].'</td>';
            echo '<td>'.$row["floor"].'</td>';
            echo '<td>'.$row["departament"].'</td>';
            echo '<td>
            <form action="editclient.php" method="POST" class="d-inline"> <input type="hidden" name="id_client" value='. $row["id_client"] .'><button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-pen"></i></button></form>  
            <form action="" method="POST" class="d-inline"><input type="hidden" name="id_client" value='. $row["id_client"] .'><button type="submit" class="btn btn-secondary" name="delete" value="Delete"><i class="far fa-trash-alt"></i></button></form></td>
          </tr>';
    }

    echo '</tbody>
    </table>';
  } else {
    echo "0 Result";
  }

  if(isset($_REQUEST['delete'])){
    $id_client = $_REQUEST['id_client'];

    $stmt = $conn->prepare(SQL_DELETE_CLIENT);
    
    // Asocia parámetros y ejecuta la consulta
    $stmt->bind_param("i", $id_client);
    
    if($stmt->execute()){
    
      echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
    } else {
        echo "Unable to Delete Data";
    }
  }
  ?>
</div>
</div>
<div><a class="btn btn-danger box" href="insertclient.php"><i class="fas fa-plus fa-2x"></i></a></div>
</div>
<?php
include('../includes/footer.php'); 
?>
