<?php
session_start();
////////////////////////////////
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
  // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
  header("Location:../../includes/404/404.php");
  exit();
} // Genera un token CSRF y lo guarda en la sesión if (!isset($_SESSION['token']))
{
  $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
////////////////////////////////
// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Agregar Nuevo Proveedor');
define('PAGE', 'Proveedores');

include ('../../dbConnection.php');
include ('../../Querys/querys.php');

?>


<body>

  <div class="modal inmodal fase" data-backdrop="static"  id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content animated bounceInRight">
        <div class="modal-header">
          <button type="button" class="close reload" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title">Registrar Nuevo Proveedor</h4>
        </div>
        <div class="modal-body">

          <form id="change-insertsupplier-form" action="" method="POST">
            <!-- Contenedor principal flex -->
            <div class="container-fluid">
              <div class="row">
                <!-- Primera columna -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="supplier_name">Razón Soacial o Nombre <span class="text-danger" >*</span></label>
                    <input type="text" class="form-control validate-field vname" id="supplier_name" name="supplier_name">
                  </div>
                  <div class="form-group">
                    <label for="phone">Telefono <span class="text-danger" >*</span></label>
                    <input type="text" class="form-control validate-field vphone" id="phone" name="phone">
                  </div>
                </div>
                <!-- Segunda columna -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="mail">Email <span class="text-danger" >*</span></label>
                    <input type="email" class="form-control validate-field vemail" id="mail" name="mail">
                  </div>
                  <div class="form-group">
                    <label for="address">Dirección <span class="text-danger" >*</span></label>
                    <input type="text" class="form-control validate-field vaddress" id="address" name="address">
                  </div>
                </div>
              </div>
            </div>
            <!-- Botones de acción -->
            <div class="modal-footer">
              <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Agregar</button>
              <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
            </div>
            <div class="text-center" id="response-message"></div>
          </form>
          <div class="p-xxs font-italic bg-muted border-top-bottom text ">
            <span class="font-bold">NOTA:</span> Al agregar un nuevo Proveedor, asegúrese de completar todos los campos
            obligatorios. La información ingresada se reflejará inmediatamente en el sistema. <br>
            <span class="text-danger" >*</span> Campo Obligatorio
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    let token = '<?php echo $token; ?>';
    let email = '';
</script>
<script src="../../js/main.js"></script>

</body>

</html>>