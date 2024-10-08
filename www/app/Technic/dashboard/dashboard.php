<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ($_SESSION['user_idRol'] != 2) {
    header("Location:../../includes/404/404.php");
  }
  $rEmail = $_SESSION['mail'];
  $rolUser = $_SESSION['user_role'];
} else {
  echo "<script> location.href='../../login.php'; </script>";
}
////////////////////////////////

define('TITLE', 'Dashboard');
define('PAGE', 'dashboard');
include('../../includes/header.php');
include('../../dbConnection.php');
include('../../Querys/querys.php');
// Preparar la consulta
$stmt = $conn->prepare(SQL_COUNT_ORDERS_WITH_STATE_TECHNIC);

$technic_id = $_SESSION['user_id']; 
$stmt->bind_param("i", $technic_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $criticas = $row['criticas'];
    $pendientes = $row['pendientes'];
    $anteriores = $row['anteriores'];
    
} else {
    $criticas = $pendientes = $realizadas = 0;
}
$stmt->close();

$stmtt = $conn->prepare(SQL_COUNT_ORDERS_FINISH);
$technic_id = $_SESSION['user_id']; 
$stmtt->bind_param("i", $technic_id);
$stmtt->execute();
$resulti = $stmtt->get_result();
if ($resulti->num_rows > 0) {
  $row = $resulti->fetch_assoc();
  $realizadas = $row['realizadas'];
} else {
  $realizadas = 0;
}
$stmtt->close();

?>
<div id="wrapper">

  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <?php include('../../includes/menu.php'); ?>
    </div>
  </nav>

  <div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
      <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
          <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
     

      </nav>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-9">
        <h2>Inicio</h2>

      </div>
    </div>
     
    

    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-12">
            <div class="widget red-bg p-lg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-bell fa-4x"></i>
                            <h1 class="m-xs"><?php echo $criticas; ?></h1>
                            <h2 class="font-bold no-margins">
                                Ordenes Urgentes Criticas
                                <br>
                                MAXIMA PRIORIDAD
                            </h2>
                           
                        </div>
            </div>
        </div>
       

        <div class="col-lg-4">
        <div class="widget navy-bg p-lg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-bell fa-4x"></i>
                            <h1 class="m-xs"><?php echo $pendientes; ?></h1>
                            <h2 class="font-bold no-margins">
                                Ordenes Pendientes Diarias
                                <br>
                                TERMINAR EN EL DIA
                            </h2>
                           
                        </div>
            </div>
        </div>
        

        <div class="col-lg-4">
            <div class="widget yellow-bg p-lg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-bell fa-4x"></i>
                            <h1 class="m-xs"><?php echo $anteriores; ?></h1>
                            <h2 class="font-bold no-margins">
                                Ordenes Pendientes Anteriores
                                <br>
                                A TERMINAR
                            </h2>
                           
                        </div>
            </div>
        </div>
         
        <div class="col-lg-4">
            <div class="widget blue-bg p-lg text-center">
                        <div class="m-b-md">
                            <i class="fa fa-bell fa-4x"></i>
                            <h1 class="m-xs"><?php echo $realizadas; ?></h1>
                            <h2 class="font-bold no-margins">
                                Ordenes realizadas
                                <br>
                                TERMINADAS
                            </h2>
                           
                        </div>
            </div>
        </div>

      </div>
    </div>
    <div class="footer">
      <div class="pull-right">

      </div>
      <div>
        <strong>Copyright</strong> Telistema &copy; 2024
      </div>
    </div>
  </div>
</div>

<?php
include('../../includes/footer.php');
?>

</body>


</html>