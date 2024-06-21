<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ($_SESSION['user_role'] != 'admin') {
    echo "<script> location.href='../../includes/404.php'; </script>";
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

      <div class="row m-t-lg">
        <div class="col-lg-6">
          <div class="ibox float-e-margins">

          </div>
        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-4">
            <div class="widget style1 lazur-bg">
              <div class="row">
                <div class="col-xs-4 text-center">
                  <i class="fa fa-bell fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                  <span>Ordenes Pendientes</span>
                  <h2 class="font-bold">5</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="widget style1 blue-bg">
              <div class="row">
                <div class="col-xs-4">
                  <i class="fa fa-check-square fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                  <span>Ordenes Completadas</span>
                  <h2 class="font-bold">4</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="widget style1 red-bg ">
              <div class="row">
                <div class="col-xs-4">
                  <i class="fa fa-exclamation-triangle fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                  <span>Ordenes a completar</span>
                  <h2 class="font-bold">260</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
          <div class="col-lg-4">
            <div class="ibox">
              <div class="ibox-content">
                <h3>Ordenes Pendientes</h3>
                <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>

                <div class="input-group">
                  <input type="text" placeholder="Add new task. " class="input input-sm form-control">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add task</button>
                  </span>
                </div>

                <ul class="sortable-list connectList agile-list" id="todo">
                  <li class="warning-element" id="task1">
                    Simply dummy text of the printing and typesetting industry.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                      <i class="fa fa-clock-o"></i> 12.10.2015
                    </div>
                  </li>
                  <li class="success-element" id="task2">
                    Many desktop publishing packages and web page editors now use Lorem Ipsum as their default.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 05.04.2015
                    </div>
                  </li>
                  <li class="info-element" id="task3">
                    Sometimes by accident, sometimes on purpose (injected humour and the like).
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 16.11.2015
                    </div>
                  </li>
                  <li class="danger-element" id="task4">
                    All the Lorem Ipsum generators
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                      <i class="fa fa-clock-o"></i> 06.10.2015
                    </div>
                  </li>
                  <li class="warning-element" id="task5">
                    Which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                      <i class="fa fa-clock-o"></i> 09.12.2015
                    </div>
                  </li>
                  <li class="warning-element" id="task6">
                    Packages and web page editors now use Lorem Ipsum as
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                      <i class="fa fa-clock-o"></i> 08.04.2015
                    </div>
                  </li>
                  <li class="success-element" id="task7">
                    Many desktop publishing packages and web page editors now use Lorem Ipsum as their default.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 05.04.2015
                    </div>
                  </li>
                  <li class="info-element" id="task8">
                    Sometimes by accident, sometimes on purpose (injected humour and the like).
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 16.11.2015
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="ibox">
              <div class="ibox-content">
                <h3>Ordenes a completar</h3>
                <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                <ul class="sortable-list connectList agile-list" id="inprogress">
                  <li class="success-element" id="task9">
                    Quisque venenatis ante in porta suscipit.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                      <i class="fa fa-clock-o"></i> 12.10.2015
                    </div>
                  </li>
                  <li class="success-element" id="task10">
                    Phasellus sit amet tortor sed enim mollis accumsan in consequat orci.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 05.04.2015
                    </div>
                  </li>
                  <li class="warning-element" id="task11">
                    Nunc sed arcu at ligula faucibus tempus ac id felis. Vestibulum et nulla quis turpis sagittis fringilla.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 16.11.2015
                    </div>
                  </li>
                  <li class="warning-element" id="task12">
                    Ut porttitor augue non sapien mollis accumsan.
                    Nulla non elit eget lacus elementum viverra.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                      <i class="fa fa-clock-o"></i> 09.12.2015
                    </div>
                  </li>
                  <li class="info-element" id="task13">
                    Packages and web page editors now use Lorem Ipsum as
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                      <i class="fa fa-clock-o"></i> 08.04.2015
                    </div>
                  </li>
                  <li class="success-element" id="task14">
                    Quisque lacinia tellus et odio ornare maximus.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 05.04.2015
                    </div>
                  </li>
                  <li class="danger-element" id="task15">
                    Enim mollis accumsan in consequat orci.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 11.04.2015
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="ibox">
              <div class="ibox-content">
                <h3>Ordenes Completadas</h3>
                <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
                <ul class="sortable-list connectList agile-list" id="completed">
                  <li class="info-element" id="task16">
                    Sometimes by accident, sometimes on purpose (injected humour and the like).
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 16.11.2015
                    </div>
                  </li>
                  <li class="warning-element" id="task17">
                    Ut porttitor augue non sapien mollis accumsan.
                    Nulla non elit eget lacus elementum viverra.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                      <i class="fa fa-clock-o"></i> 09.12.2015
                    </div>
                  </li>
                  <li class="warning-element" id="task18">
                    Which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                      <i class="fa fa-clock-o"></i> 09.12.2015
                    </div>
                  </li>
                  <li class="warning-element" id="task19">
                    Packages and web page editors now use Lorem Ipsum as
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                      <i class="fa fa-clock-o"></i> 08.04.2015
                    </div>
                  </li>
                  <li class="success-element" id="task20">
                    Many desktop publishing packages and web page editors now use Lorem Ipsum as their default.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 05.04.2015
                    </div>
                  </li>
                  <li class="info-element" id="task21">
                    Sometimes by accident, sometimes on purpose (injected humour and the like).
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 16.11.2015
                    </div>
                  </li>
                  <li class="warning-element" id="task22">
                    Simply dummy text of the printing and typesetting industry.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                      <i class="fa fa-clock-o"></i> 12.10.2015
                    </div>
                  </li>
                  <li class="success-element" id="task23">
                    Many desktop publishing packages and web page editors now use Lorem Ipsum as their default.
                    <div class="agile-detail">
                      <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                      <i class="fa fa-clock-o"></i> 05.04.2015
                    </div>
                  </li>
                </ul>
              </div>
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