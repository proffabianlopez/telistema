<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ($_SESSION['user_role'] != 'admin') {

    echo "<script> location.href='../includes/404.php'; </script>";

  }
  $rEmail = $_SESSION['mail'];
  $rolUser = $_SESSION['user_role'];

} else {

  echo "<script> location.href='../login.php'; </script>";

}
////////////////////////////////

define('TITLE', 'Actualizar Proveedores');
define('PAGE', 'Proveedores');
include ('../dbConnection.php');
include ('../Querys/querys.php');

// update
if (isset($_REQUEST['update'])) {

  // Checking for Empty Fields
  if (($_REQUEST['supplier_name'] == "") || ($_REQUEST['phone'] == "") || ($_REQUEST['mail'] == "") || ($_REQUEST['address'] == "")) {
    // msg displayed if required field missing
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';

  } else {
    $id = $_REQUEST['id_supplier'];
    $name = $_REQUEST['supplier_name'];
    $phone = $_REQUEST['phone'];
    $mail = $_REQUEST['mail'];
    $address = $_REQUEST['address'];
    $id_state = $_REQUEST['id_state_user'];

    $stmt = $conn->prepare(SQL_UPDATE_SUPPLIER);
    $stmt->bind_param("ssssii", $name, $phone, $mail, $address, $id_state, $id);

    if ($stmt->execute()) {
      // below msg display on form submit success
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';

    } else {
      // below msg display on form submit failed
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
    }
  }
}
?>


<?php
if (isset($_REQUEST['view'])) {

  $id_supplier = $_REQUEST['id_supplier'];
  $stmt = $conn->prepare(SQL_SELECT_SUPPLIER_BY_ID);
  $stmt->bind_param("i", $id_supplier);
  $stmt->execute();

  // Obtener resultados de la consulta
  $result = $stmt->get_result();

  // Verificar si hay resultados
  if ($result->num_rows > 0) {
    // Obtener la fila como un array asociativo
    $row = $result->fetch_assoc();
  } else {
    // Mostrar un mensaje si no se encuentra ningún cliente con el ID proporcionado
    echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningún cliente con ese ID.</div>';
  }

}
?>
<?php include ('../includes/header.php') ?>

<body>

  <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <?php include ('../includes/menu.php') ?>

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
              <a href="login.html">
                <i class="fa fa-sign-out"></i> Cerrar Sesión
              </a>
            </li>
          </ul>

        </nav>
      </div>
      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">

          <h2>Proveedores</h2>
        </div>
        <div class="col-lg-2">

        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

          <div class="col-lg-5">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Actualizar Proveedor</h5>

              </div>
              <div class="ibox-content">

                <form action="" method="POST">
                  <div class="form-group">
                    <label for="id_supplier">ID Proveedor</label>
                    <input type="text" class="form-control" id="id_supplier" name="id_supplier" value="<?php if (isset($row['id_supplier'])) {
                      echo $row['id_supplier'];
                    } ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="supplier_name">Nombre</label>
                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?php if (isset($row['supplier_name'])) {
                      echo $row['supplier_name'];
                    } ?>">
                  </div>
                  <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php if (isset($row['phone'])) {
                      echo $row['phone'];
                    } ?>" onkeypress="isInputNumber(event)">
                  </div>
                  <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="email" class="form-control" id="mail" name="mail" value="<?php if (isset($row['mail'])) {
                      echo $row['mail'];
                    } ?>">
                  </div>

                  <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php if (isset($row['address'])) {
                      echo $row['address'];
                    } ?>">
                  </div>



                  <div class="form-group">
                    <label for="state_user">Estado</label>
                    <select name="id_state_user" id="id_state_user" class="form-control">
                      <?php

                      $state = $row['id_state_user'];
                      $stmt = $conn->prepare(SQL_SELECT_STATE_BY_ID);
                      $stmt->bind_param("i", $state);
                      $stmt->execute();
                      $result = $stmt->get_result();

                      // Verificar si hay resultados
                      if ($result->num_rows > 0) {
                        // Obtener la fila como un array asociativo
                        $row_state = $result->fetch_assoc();
                        $name_state = $row_state["state_user"];
                        $id_state_user = $row_state["id_state_user"];
                      } else {
                        // Si no hay resultados, asignar un valor por defecto
                        $id_state_user = 0; // O el valor que desees
                      }

                      // Luego, obtén todos los estados de la tabla states_users
                      $stmt = $conn->prepare(SQL_SELECT_STATUS_USERS);
                      $stmt->execute();
                      $rows = $stmt->get_result();


                      // Itera sobre los estados para crear las opciones del select
                      foreach ($rows as $state) {
                        $stateName = $state["state_user"];
                        $stateId = $state["id_state_user"];
                        $selected = ($stateId == $id_state_user) ? "selected" : "";
                        echo "<option value='$stateId' $selected>$stateName</option>";
                      }
                      ?>
                    </select>
                  </div>


                  <div class="text-center">
                    <button type="submit" class="btn btn-danger" id="update" name="update">Actualizar</button>
                    <a href="suppliers.php" class="btn btn-secondary">Cerrar</a>
                  </div>
                  <?php if (isset($msg)) {
                    echo $msg;
                  } ?>
                </form>
              </div>

            </div>
          </div>

        </div>
      </div>
      <div class="footer">
        <div>
          <strong>Copyright</strong>  Telistema &copy; 2024
        </div>
      </div>

    </div>
  </div>



  <?php include ('../includes/footer.php'); ?>

  <!-- Only Number for input fields -->
  <script>
    function isInputNumber(evt) {
      var ch = String.fromCharCode(evt.which);
      if (!(/[0-9]/.test(ch))) {
        evt.preventDefault();
      }
    }
  </script>

</body>

</html>