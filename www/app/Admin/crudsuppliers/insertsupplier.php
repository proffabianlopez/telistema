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

define('TITLE', 'Agregar Nuevo Proveedor');
define('PAGE', 'Proveedores');

include('../../dbConnection.php');
include('../../Querys/querys.php');

if (isset($_REQUEST['submit'])) {
  // Verifica si hay campos vacíos
  if (($_REQUEST['supplier_name'] == "") || ($_REQUEST['phone'] == "") || ($_REQUEST['mail'] == "") || ($_REQUEST['address'] == "")) {
    // Muestra un mensaje si hay campos vacíos
    $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Completa todos los campos </div>';
  } else {
    // Asigna los valores del usuario a variables
    $name = $_REQUEST['supplier_name'];
    $phone = $_REQUEST['phone'];
    $mail = $_REQUEST['mail'];
    $address = $_REQUEST['address'];
    $id_state = $_REQUEST['id_state_user'];
    $id_state = 1; // ¿Este valor siempre será 1?

    // Prepara la consulta
    $stmt = $conn->prepare(SQL_INSERT_SUPPLIER);

    // Asocia parámetros y ejecuta la consulta
    $stmt->bind_param("ssssi", $name, $phone, $mail, $address, $id_state);

    if ($stmt->execute()) {
      // Muestra un mensaje si la inserción fue exitosa
      $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Agregado exitosamente </div>';
    } else {
      // Muestra un mensaje si la inserción falló
      $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo agregar </div>';
    }
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
                <i class="bi bi-person-fill-add modal-icon"></i>
                <h4 class="modal-title">Registrar Nuevo Proveedor</h4>
            </div>
            <div class="modal-body">

                <form id="change-admin-form" action="" method="POST">
                  <div class="form-group">
                    <label for="supplier_name">Nombre</label>
                    <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                  </div>
                  <div class="form-group">
                    <label for="phone">Telefono</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                  </div>
                  <div class="form-group">
                    <label for="mail">Email</label>
                    <input type="email" class="form-control" id="mail" name="mail">
                  </div>
                  <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address">
                  </div>
                  <div class="modal-footer">
                        <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Agregar</button>
                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="text-center" id="response-message"></div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text ">
                    <span class="font-bold">NOTA:</span> Al agregar un nuevo Proveedor, asegúrese de completar todos los campos obligatorios. La información ingresada se reflejará inmediatamente en el sistema.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#change-admin-form').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            laddaButton = Ladda.create(document.querySelector('.ladda-button'));
            laddaButton.start();
            $.ajax({
                type: 'POST',
                url: 'suppliersController.php?token=<?php echo $token; ?>&action=add_supplier', // La URL de tu archivo PHP
                data: formData,
                dataType: 'json',
                success: function(response) {
                    laddaButton.stop();
                    var messageContainer = $('#response-message');
                    if (response.status === 'success') {
                        messageContainer.html('<div class="alert alert-success">' + response.message + '</div>');
                    } else {
                        messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    laddaButton.stop();
                    console.log(xhr.responseText);
                    $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX: ' + error + '</div>');
                }
            });
        });
        $('.reload').click(function() {
            location.reload();
        });



    });
</script>

</body>

</html>>