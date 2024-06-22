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

define('TITLE', 'Agregar Nuevo Cliente');
define('PAGE', 'Clientes');

include('../../dbConnection.php');
include('../../Querys/querys.php');
include ('../configsmtp/generate_config.php');
// if (isset($_REQUEST['reqsubmit'])) {
//   // Verifica si hay campos vacíos
//   if (($_REQUEST['client_name'] == "") || ($_REQUEST['client_lastname'] == "") || ($_REQUEST['phone'] == "") || ($_REQUEST['mail'] == "") || ($_REQUEST['address'] == "") || ($_REQUEST['height'] == "") || ($_REQUEST['floor'] == "") || ($_REQUEST['departament'] == "")) {
//     // Muestra un mensaje si hay campos vacíos
//     $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Completa todos los campos </div>';
//   } else {
//     // Asigna los valores del usuario a variables
//     $name = $_REQUEST['client_name'];
//     $lastname = $_REQUEST['client_lastname'];
//     $phone = $_REQUEST['phone'];
//     $mail = $_REQUEST['mail'];
//     $address = $_REQUEST['address'];
//     $height = $_REQUEST['height'];
//     $floor = $_REQUEST['floor'];
//     $departament = $_REQUEST['departament'];
//     $id_state = $_REQUEST['id_state_user'];
//     $id_state = 1; // ¿Este valor siempre será 1?

//     // Prepara la consulta
//     $stmt = $conn->prepare(SQL_INSERT_CLIENT);

//     // Asocia parámetros y ejecuta la consulta
//     $stmt->bind_param("ssssssssi", $name, $lastname, $phone, $mail, $address, $height, $floor, $departament, $id_state);

//     if ($stmt->execute()) {
//       // Muestra un mensaje si la inserción fue exitosa
//       $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Agregado exitosamente </div>';
//     } else {
//       // Muestra un mensaje si la inserción falló
//       $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo agregar </div>';
//     }
//   }
// }
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
                <h4 class="modal-title">Registrar Nuevo Cliente</h4>
            </div>
            <div class="modal-body">

                <form id="add-product-form" action="" method="POST">
                  <div class="form-group">
                    <label for="client_name">Nombre</label>
                    <input type="text" class="form-control" id="client_name" name="client_name">
                  </div>
                  <div class="form-group">
                    <label for="client_lastname">Apellido</label>
                    <input type="text" class="form-control" id="client_lastname" name="client_lastname">
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
                  <div class="form-group">
                    <label for="height">Altura</label>
                    <input type="text" class="form-control" id="height" name="height">
                  </div>
                  <div class="form-group">
                    <label for="floor">Piso</label>
                    <input type="text" class="form-control" id="floor" name="floor">
                  </div>
                  <div class="form-group">
                    <label for="departament">Departamento</label>
                    <input type="text" class="form-control" id="departament" name="departament">
                  </div>
                  <div class="modal-footer">
                        <button type="submit" class="ladda-button btn btn-primary"
                            data-style="zoom-in">Agregar</button>
                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="text-center" id="response-message"></div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text ">
                    <span class="font-bold">NOTA:</span> Al agregar un nuevo Cliente, asegúrese de completar todos los campos obligatorios. La información ingresada se reflejará inmediatamente en el sistema.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#add-product-form').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var laddaButton = Ladda.create(document.querySelector('.ladda-button'));
        laddaButton.start();
        $.ajax({
            type: 'POST',
            url: 'clientsController.php?token=<?php echo $token; ?>&action=add_client',
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
            error: function (xhr, status, error) {
                laddaButton.stop();
                console.log(xhr.responseText);
                $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX: ' + error + '<br>' + xhr.responseText + '</div>');
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