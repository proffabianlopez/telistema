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

define('TITLE', 'Update Tecnicos');
define('PAGE', 'Tecnicos');
include ('../dbConnection.php');
include ('../Querys/querys.php');
include ('generate_config.php');


// update
if (isset($_REQUEST['update'])) {

  // Checking for Empty Fields
  if (($_REQUEST['name_user'] == "") || ($_REQUEST['id_state_user'] == "") || ($_REQUEST['phone_user'] == "") || ($_REQUEST['mail'] == "")) {
    // msg displayed if required field missing
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';

  } else {
    // Assigning User Values to Variable
    $id = $_REQUEST['id_user'];
    $name = capitalizeWords(trim($_REQUEST['name_user']));
    $phone = trim($_REQUEST['phone_user']);
    $mail = trim($_REQUEST['mail']);
    $state = $_REQUEST['id_state_user'];

    $stmt = $conn->prepare(SQL_UPDATE_TECHNIC);
    $stmt->bind_param("sssii", $name, $phone, $mail, $state, $id);


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

  $id_user = $_REQUEST['id_user'];
  $stmt = $conn->prepare(SQL_SELECT_TECHNIC_BY_ID);
  $stmt->bind_param("i", $id_user);
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
                <i class="fa fa-sign-out"></i> Cerrar Sección
              </a>
            </li>
          </ul>

        </nav>
      </div>
      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">

          <h2>Técnicos</h2>
        </div>
        <div class="col-lg-2">

        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

          <div class="col-lg-5">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Actualizar Técnico</h5>

              </div>
              <div class="ibox-content">

                <form action="" method="POST">
                  <div class="form-group">
                    <label for="id_user">ID Técnico</label>
                    <input type="text" class="form-control" id="id_user" name="id_user" value="<?php if (isset($row['id_user'])) {
                      echo $row['id_user'];
                    } ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="name_user">Nombre</label>
                    <input type="text" class="form-control" id="name_user" name="name_user" value="<?php if (isset($row['name_user'])) {
                      echo $row['name_user'];
                    } ?>">
                  </div>
                  <div class="form-group">
                    <label for="phone_user">Teléfono</label>
                    <input type="text" class="form-control" id="phone_user" name="phone_user" value="<?php if (isset($row['phone_user'])) {
                      echo $row['phone_user'];
                    } ?>" onkeypress="isInputNumber(event)">
                  </div>
                  <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="email" class="form-control" id="mail" name="mail" value="<?php if (isset($row['mail'])) {
                      echo $row['mail'];
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
                    <a href="technician.php" class="btn btn-secondary">Cerrar</a>
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