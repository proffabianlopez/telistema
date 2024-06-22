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

// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];


define('TITLE', 'Actualizar Proveedores');
define('PAGE', 'Proveedores');
include ('../../dbConnection.php');
include ('../../Querys/querys.php');


if (isset($_POST['id'])) {

  $id_supplier = $_REQUEST['id'];
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

<body>

  <div class="modal inmodal fase" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content animated bounceInRight">
        <div class="modal-header">
          <button type="button" class="close reload" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <i class="bi bi-person-gear modal-icon"></i>
          <h4 class="modal-title">Editar Proveedor</h4>
        </div>
        <div class="modal-body">

          <form id="change-admin-form" action="" method="POST">
            <div style="display: none;" class="form-group">
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
              } ?>"
                onkeypress="isInputNumber(event)">
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


            <div class="modal-footer">
              <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
              <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
            </div>
            <div class="text-center" id="response-message"></div>
          </form>
          <div class="p-xxs font-italic bg-muted border-top-bottom text">
                        <span class="font-bold">NOTA:</span> Al editar un Proveedor, asegúrese de revisar y actualizar correctamente todos los campos. Los cambios realizados se reflejarán inmediatamente en el sistema.
                    </div>
      </div>
    </div>
  </div>

  <script>
    function isInputNumber(evt) {
      var ch = String.fromCharCode(evt.which);
      if (!(/[0-9]/.test(ch))) {
        evt.preventDefault();
      }
    }

    $(document).ready(function () {
      var laddaButton;

      $('#change-admin-form').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        laddaButton = Ladda.create(document.querySelector('.ladda-button'));
        laddaButton.start();

        $.ajax({
          type: 'POST',
          url: 'suppliersController.php?token=<?php echo $token; ?>&action=edit_supplier', // La URL de tu archivo PHP
          data: formData,
          dataType: 'json',
          success: function (response) {
            laddaButton.stop();
            var messageContainer = $('#response-message');
            if (response.status === 'success') {
              messageContainer.html('<div class="alert alert-success">' + response.message + '</div>');
            } else {
              messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
            }
          },
          error: function () {
            laddaButton.stop();
            $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX</div>');
          }
        });
      });

      $('.reload').click(function () {
        location.reload();
      });
    });
  </script>

</body>

</html>