<?php
session_start();
////////////////////////////////
// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
  // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
  header("Location:../../includes/404/404.php");
  exit();
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
    $email = $row['mail'];
  } else {
    // Mostrar un mensaje si no se encuentra ningún cliente con el ID proporcionado
    echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningún cliente con ese ID.</div>';
  }
}
?>

<body>

  <div class="modal inmodal fase" data-backdrop="static" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content animated bounceInRight">
        <div class="modal-header">
          <button type="button" class="close reload" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title">Editar Proveedor</h4>
        </div>
        <div class="modal-body">

          <form id="change-editsupplier-form" action="" method="POST">
            <!-- Contenedor principal flex -->
            <div class="container-fluid">
              <div class="row">
                <!-- Primera columna -->
                <div class="col-md-6">
                  <div style="display: none;" class="form-group">
                    <label for="id_supplier">ID Proveedor</label>
                    <input type="text" class="form-control" id="id_supplier" name="id_supplier" value="<?php if (isset($row['id_supplier'])) {
                      echo $row['id_supplier'];
                    } ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="supplier_name">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control validate-field vname" id="supplier_name" name="supplier_name"
                      value="<?php if (isset($row['supplier_name'])) {
                        echo $row['supplier_name'];
                      } ?>">
                  </div>
                  <div class="form-group">
                    <label for="mail">Email (no editable) </label>
                    <p class="form-control" id="mail" name="mail">
                      <?php if (isset($row['mail'])) {
                        echo $row['mail'];
                      } ?>
                    </p>
                  </div>
                  
                </div>
                <!-- Segunda columna -->
                <div class="col-md-6">
                  
                <div class="form-group">
                    <label for="phone">Teléfono <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control validate-field" id="phone" name="phone" value="<?php if (isset($row['phone'])) {
                      echo $row['phone'];
                    } ?>">
                  </div>
                  <div class="form-group">
                    <label for="address">Dirección <span class="text-danger">*</span></label>
                    <input type="text" class="form-control validate-field vaddress" id="address" name="address" value="<?php if (isset($row['address'])) {
                      echo $row['address'];
                    } ?>">
                  </div>

                </div>
              </div>
            </div>


            <div class="modal-footer">
              <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
              <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
            </div>
            <div class="text-center" id="response-message"></div>
          </form>
          <div class="p-xxs font-italic bg-muted border-top-bottom text">
            <span class="font-bold">NOTA:</span> Al editar un Proveedor, asegúrese de revisar y actualizar correctamente
            todos los campos. Los cambios realizados se reflejarán inmediatamente en el sistema.<br>
            <span class="text-danger">*</span> Campo Obligatorio
          </div>
        </div>
      </div>
    </div>

    <script>
        let token = '<?php echo $token; ?>';
        let email = '<?php echo $email; ?>';
    </script>
    <script src="../../js/main.js"></script>
    <script>

$(document).ready(function () {

    $('#mail').prop('readonly', true);
    $('#mail').attr('disabled', 'disabled');

});

</script>
<script>
      const input = document.querySelector("#phone");
      const iti = window.intlTelInput(input, {
        separateDialCode: true,
        preferredCountries: ["ar", "us", "br", "mx"],
        utilsScript: "../../js/utils.js"
      });

      // Detecta el cambio de bandera
      input.addEventListener("countrychange", function() {
        // Limpiar el campo de tel
        input.value = "";
      });

      // Cuando el formulario se envíe,se agrega el codigo de area
      document.getElementById('change-editsupplier-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const fullNumber = iti.getNumber();
        document.getElementById('phone').value = fullNumber;
        this.submit();
      });
    </script>
</body>

</html>