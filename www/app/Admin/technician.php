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

define('TITLE', 'Tecnicos');
define('PAGE', 'Tecnicos');
include('../includes/header.php'); 
include('../dbConnection.php');

?>
<div class="col-sm-9 col-md-10 mt-5 text-center">
  <!--Table-->
  <p class=" bg-dark text-white p-2">Lista de Técnicos</p>
  <?php
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
 echo '<table class="table">
  <thead>
   <tr>
    <th scope="col">ID Técnico</th>
    <th scope="col">Nombre</th>
    <th scope="col">Teléfono</th>
    <th scope="col">Email</th>
    <th scope="col">Estado</th>
    <th scope="col">Action</th>
   </tr>
  </thead>
  <tbody>';
  while($row = $result->fetch_assoc()){
   echo '<tr>';
    echo '<th scope="row">'.$row["id_user"].'</th>';
    echo '<td>'. $row["name_user"].'</td>';
    echo '<td>'.$row["phone_user"].'</td>';
    echo '<td>'.$row["mail"].'</td>';
    echo '<td>'.$row["id_state_user"].'</td>';
    echo '<td><form action="editemp.php" method="POST" class="d-inline"> <input type="hidden" name="id_user" value='. $row["id_user"] .'><button type="submit" class="btn btn-info mr-3" name="view" value="View"><i class="fas fa-pen"></i></button></form>  <form action="" method="POST" class="d-inline"><input type="hidden" name="id_user" value='. $row["id_user"] .'><button type="submit" class="btn btn-secondary" name="delete" value="Eliminar"><i class="far fa-trash-alt"></i></button></form></td>
   </tr>';
  }

 echo '</tbody>
 </table>';
} else {
  echo "0 Result";
}
if(isset($_REQUEST['delete'])){
  $sql = "DELETE FROM Tecnicos_tb WHERE empid = {$_REQUEST['id']}";
  if($conn->query($sql) === TRUE){
    // echo "Record Deleted Successfully";
    // below code will refresh the page after deleting the record
    echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
    } else {
      echo "Unable to Delete Data";
    }
  }
?>
</div>
</div>
<div><a class="btn btn-danger box" href="insertemp.php"><i class="fas fa-plus fa-2x"></i></a>
</div>
</div>

<?php
include('../includes/footer.php'); 
?>