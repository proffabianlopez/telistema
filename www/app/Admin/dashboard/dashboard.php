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
include('../../Querys/querys.php');

////////////////////////////////
$sql = SQL_COUNT_ORDERS_WITH_STATE30;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $confirmadas = $row['confirmadas'];
  $pendientes = $row['pendientes'];
  $realizadas = $row['realizadas'];
  $totalordenes=$row['total_orders'];
  $ordenescriticas=$row['criticas'];
  $porcentaje_confirmadas = $row['porcentaje_confirmadas'];
  $porcentaje_pendientes = $row['porcentaje_pendientes'];
  $porcentaje_realizadas = $row['porcentaje_realizadas'];
  $porcentaje_criticas=$row['porcentaje_criticas'];
  
} else {
  $confirmadas = $pendientes = $realizadas =$totalordenes=$ordenescriticas= 0;
}
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
           
          </li>
        </ul>

      </nav>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
      <div class="col-lg-9">
        <h2>Inicio</h2>

      </div>
    </div>
    <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-success pull-right">Mensual</span>
                                <h5>Ordenes Pendientes</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $pendientes; ?></h1>
                                <div class="stat-percent font-bold text-success"><?php echo $porcentaje_pendientes; ?>% <i class="fa fa-bolt"></i></div> <!-- calcular el porcentaje sobre el total de ordenes-->
                                <small>Total Pendientes</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Mensual</span>
                                <h5>Ordenes Prioritarias</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $ordenescriticas; ?></h1> 
                                <div class="stat-percent font-bold text-info"><?php echo $porcentaje_criticas; ?>% <i class="fa fa-level-up"></i></div>
                                <small>Pendientes Criticas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-primary pull-right">Mensual</span>
                                <h5>Ordenes Realizadas</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $realizadas; ?></h1>
                                <div class="stat-percent font-bold text-navy"><?php echo $porcentaje_realizadas; ?>% <i class="fa fa-level-up"></i></div>
                                <small>Total de Ordenes</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                            <span class="label label-success pull-right">Mensual</span>
                                <h5>Total de Ordenes</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $totalordenes;?></h1>
                                <div class="stat-percent font-bold text-danger"><i class="fa fa-level-up"></i></div>
                                <small>Total</small>
                            </div>
                        </div>
            </div>
        </div>
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Custom responsive table </h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#">Config option 1</a>
                    </li>
                    <li><a href="#">Config option 2</a>
                    </li>
                </ul>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-9 m-b-xs">
                    <div data-toggle="buttons" class="btn-group">
                        <label class="btn btn-sm btn-white"> <input type="radio" id="option1" name="options"> Day </label>
                        <label class="btn btn-sm btn-white active"> <input type="radio" id="option2" name="options"> Week </label>
                        <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> Month </label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Project </th>
                        <th>Name </th>
                        <th>Phone </th>
                        <th>Company </th>
                        <th>Completed </th>
                        <th>Task</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Project <small>This is example of project</small></td>
                        <td>Patrick Smith</td>
                        <td>0800 051213</td>
                        <td>Inceptos Hymenaeos Ltd</td>
                        <td><span class="pie" style="display: none;">0.52/1.561</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 14.933563796318165 11.990700825968545 Z" fill="#1ab394"></path><path d="M 8 8 L 14.933563796318165 11.990700825968545 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                        <td>20%</td>
                        <td>Jul 14, 2013</td>
                        <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Alpha project</td>
                        <td>Alice Jackson</td>
                        <td>0500 780909</td>
                        <td>Nec Euismod In Company</td>
                        <td><span class="pie" style="display: none;">6,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 12.702282018339785 14.47213595499958 Z" fill="#1ab394"></path><path d="M 8 8 L 12.702282018339785 14.47213595499958 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                        <td>40%</td>
                        <td>Jul 16, 2013</td>
                        <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Project <small>This is example of project</small></td>
                        <td>Patrick Smith</td>
                        <td>0800 051213</td>
                        <td>Inceptos Hymenaeos Ltd</td>
                        <td><span class="pie" style="display: none;">0.52/1.561</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 14.933563796318165 11.990700825968545 Z" fill="#1ab394"></path><path d="M 8 8 L 14.933563796318165 11.990700825968545 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                        <td>20%</td>
                        <td>Jul 14, 2013</td>
                        <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Gamma project</td>
                        <td>Anna Jordan</td>
                        <td>(016977) 0648</td>
                        <td>Tellus Ltd</td>
                        <td><span class="pie" style="display: none;">4,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 15.48012994148332 10.836839096340286 Z" fill="#1ab394"></path><path d="M 8 8 L 15.48012994148332 10.836839096340286 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                        <td>18%</td>
                        <td>Jul 22, 2013</td>
                        <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Project <small>This is example of project</small></td>
                        <td>Patrick Smith</td>
                        <td>0800 051213</td>
                        <td>Inceptos Hymenaeos Ltd</td>
                        <td><span class="pie" style="display: none;">0.52/1.561</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 14.933563796318165 11.990700825968545 Z" fill="#1ab394"></path><path d="M 8 8 L 14.933563796318165 11.990700825968545 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                        <td>20%</td>
                        <td>Jul 14, 2013</td>
                        <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>

        </div>
        </div>
        </div>
    <!-- <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row">
        <div class="col-lg-4">
          <div class="widget style1 custom-bg-1">
            <div class="row">
              <div class="col-xs-4 text-center">
                <i class="fa fa-check-square-o fa-5x"></i>
              </div>
              <div class="col-xs-8 text-right">
                <span> Ordenes Confirmadas </span>
                <h2 class="font-bold"><?php echo $confirmadas; ?></h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">

          <div class="widget style1 custom-bg-2">
            <div class="row">
              <div class="col-xs-4">
                <i class="fa fa-check fa-5x"></i>
              </div>
              <div class="col-xs-8 text-right">
                <span> Ordenes Finalizadas </span>
                <h2 class="font-bold"><?php echo $realizadas; ?></h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="widget style1 custom-bg-3">
            <div class="row">
              <div class="col-xs-4">
                <i class="fa fa-exclamation fa-5x"></i>
              </div>
              <div class="col-xs-8 text-right">
                <span> Ordenes Pendientes </span>
                <h2 class="font-bold"><?php echo $pendientes; ?></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
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