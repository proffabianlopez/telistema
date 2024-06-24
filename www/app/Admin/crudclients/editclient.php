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

define('TITLE', 'Clientes');
define('PAGE', 'Clientes');
include('../../dbConnection.php');
include('../../Querys/querys.php');

?>
<?php
if (isset($_POST['id'])) {

  $id_client = $_REQUEST['id'];
  $sql = SQL_CLIENT_BY_ID;
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_client);
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
<?php include('../../includes/header.php') ?>

<body>

<div class="modal inmodal fase" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="bi bi-person-gear modal-icon"></i>
                <h4 class="modal-title">Editar Cliente</h4>
            </div>
            <div class="modal-body">

                <form id="change-admin-form" action="" method="POST">
                <div style="display: none" class="form-group">
                      <label  for="client_name">Id Cliente</label>
                      <input type="text" class="form-control" id="id_client" name="id_client" value="<?php if (isset($row['id_client'])) {
                                                                                                        echo $row['id_client'];
                                                                                                      } ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="client_name">Nombre</label>
                      <input type="text" class="form-control" id="client_name" name="client_name" value="<?php if (isset($row['client_name'])) {
                                                                                                            echo $row['client_name'];
                                                                                                          } ?>">
                    </div>
                    <div class="form-group">
                      <label for="client_lastname">Apellido</label>
                      <input type="text" class="form-control" id="client_lastname" name="client_lastname" value="<?php if (isset($row['client_lastname'])) {
                                                                                                                    echo $row['client_lastname'];
                                                                                                                  } ?>">
                    </div>
                    <div class="form-group">
                      <label for="phone">Telefono</label>
                      <input type="text" class="form-control" id="phone" name="phone" value="<?php if (isset($row['phone'])) {
                                                                                                echo $row['phone'];
                                                                                              } ?>">
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
                      <label for="height">Altura</label>
                      <input type="text" class="form-control" id="height" name="height" value="<?php if (isset($row['height'])) {
                                                                                                  echo $row['height'];
                                                                                                } ?>">
                    </div>
                    <div class="form-group">
                      <label for="floor">Piso</label>
                      <input type="text" class="form-control" id="floor" name="floor" value="<?php if (isset($row['floor'])) {
                                                                                                echo $row['floor'];
                                                                                              } ?>">
                    </div>
                    <div class="form-group">
                      <label for="departament">Departamento</label>
                      <input type="text" class="form-control" id="departament" name="departament" value="<?php if (isset($row['departament'])) {
                                                                                                            echo $row['departament'];
                                                                                                          } ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="text-center" id="response-message"></div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text">
                        <span class="font-bold">NOTA:</span> Al editar una Cliente, asegúrese de revisar y actualizar correctamente todos los campos. Los cambios realizados se reflejarán inmediatamente en el sistema.
                    </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var laddaButton;

        $('#change-admin-form').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            laddaButton = Ladda.create(document.querySelector('.ladda-button'));
            laddaButton.start();

            $.ajax({
                type: 'POST',
                url: 'clientsController.php?token=<?php echo $token; ?>&action=edit_clients', // La URL de tu archivo PHP
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
                error: function() {
                    laddaButton.stop();
                    $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX</div>');
                }
            });
        });

        $('.reload').click(function() {
            location.reload();
        });
    });
</script>

</body>

</html>