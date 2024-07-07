<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ($_SESSION['user_idRol'] != 1) {
    header("Location:../../includes/404/404.php");
  }
  $rEmail = $_SESSION['mail'];
  $rolUser = $_SESSION['user_role'];
} else {
  echo "<script> location.href='../../login.php'; </script>";
}
////////////////////////////////

define('TITLE', 'Dashboard Admin');
define('PAGE', 'dashboard admin');
include('../../includes/header.php');
include('../../dbConnection.php');


// $sql = "SELECT max(request_id) FROM submitrequest_tb";
// $result = $conn->query($sql);
// $row = mysqli_fetch_row($result);
// $submitrequest = $row[0];

// $sql = "SELECT max(request_id) FROM assignwork_tb";
// $result = $conn->query($sql);
// $row = mysqli_fetch_row($result);
// $assignwork = $row[0];

// $sql = "SELECT * FROM technician_tb";
// $result = $conn->query($sql);
// $totaltech = $result->num_rows;

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
        <ul class="nav navbar-top-links navbar-right">
          <li>
            <a href="../../logout.php" id="logout">
              <i class="fa fa-sign-out"></i> Cerrar Sesión
            </a>
          </li>
        </ul>

      </nav>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-9">
        <h2>Inicio</h2>

      </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-3">
          <div class="widget style1 custom-bg-1">
            <div class="row">
              <div class="col-xs-4 text-center">
                <i class="fa fa-bell fa-5x"></i>
              </div>
              <div class="col-xs-8 text-right">

                <h2 class="font-bold">4</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">

          <div class="widget style1 custom-bg-2">
            <div class="row">
              <div class="col-xs-4">
                <i class="fa fa-check fa-5x"></i>
              </div>
              <div class="col-xs-8 text-right">
                <span> Ordenes Finalizadas </span>
                <h2 class="font-bold">26</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="widget style1 custom-bg-3">
            <div class="row">
              <div class="col-xs-4">
                <i class="fa fa-exclamation fa-5x"></i>
              </div>
              <div class="col-xs-8 text-right">
                <span> Ordenes Pendientes </span>
                <h2 class="font-bold">260</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="widget style1 custom-bg-4">
            <div class="row">
              <div class="col-xs-4">
                <i class="fa fa-exclamation-triangle fa-5x"></i>
              </div>
              <div class="col-xs-8 text-right">
                <span> Ordenes Prioritarias </span>
                <h2 class="font-bold">12</h2>
              </div>
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