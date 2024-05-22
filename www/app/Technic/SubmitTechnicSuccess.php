<?php
session_start();
////////////////////////////////
if($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if($_SESSION['user_role'] != 'technic') {
      echo "<script> location.href='../includes/404.php'; </script>";
  }
  $rEmail = $_SESSION['mail'];
  $rolUser = $_SESSION['user_role'];
 } else {
  echo "<script> location.href='../login.php'; </script>";
 }
////////////////////////////////

define('TITLE', 'Success');
include('../includes/header.php'); 
include('../dbConnection.php');

$sql = "SELECT * FROM submitrequest_tb WHERE request_id = {$_SESSION['myid']}";
$result = $conn->query($sql);
if($result->num_rows == 1){
 $row = $result->fetch_assoc();
 echo "<div class='ml-5 mt-5'>
 <table class='table'>
  <tbody>
   <tr>
     <th>Request ID</th>
     <td>".$row['request_id']."</td>
   </tr>
   <tr>
     <th>Name</th>
     <td>".$row['requester_name']."</td>
   </tr>
   <tr>
   <th>Email ID</th>
   <td>".$row['requester_email']."</td>
  </tr>
   <tr>
    <th>Request Info</th>
    <td>".$row['request_info']."</td>
   </tr>
   <tr>
    <th>Request Description</th>
    <td>".$row['request_desc']."</td>
   </tr>

   <tr>
    <td><form class='d-print-none'><input class='btn btn-danger' type='submit' value='Print' onClick='window.print()'></form></td>
  </tr>
  </tbody>
 </table> </div>
 ";


} else {
  echo "Failed";
}
?>


<?php
include('../includes/footer.php'); 
$conn->close();
?>