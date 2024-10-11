<?php
session_start();
////////////////////////////////
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
  header("Location:../../includes/404/404.php");
  exit();
}
////////////////////////////////
// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Agregar Nuevo Cliente');
define('PAGE', 'Clientes');

include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../configsmtp/generate_config.php');
?>

<body>

  <div class="modal inmodal fase" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content animated bounceInRight">
        <div class="modal-header">
          <button type="button" class="close reload" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title">Registrar Nuevo Cliente</h4>
        </div>
        <div class="modal-body">

          <form id="change-insertclient-form" action="" method="POST">
            <!-- Contenedor principal flex -->
            <div class="container-fluid">
              <div class="row">
                <!-- Primera columna -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="client_name">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control validate-field vname" id="client_name"
                      name="client_name">
                  </div>
                  <div class="form-group">
                    <label for="client_lastname">Apellido <span class="text-danger">*</span></label>
                    <input type="text" class="form-control validate-field vname" id="client_lastname"
                      name="client_lastname">
                  </div>
                  <div class="form-group">
                    <label for="phone">Teléfono <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control validate-field iti__tel-input" id="phone" name="phone">
                  </div>
                  <div class="form-group">
                    <label for="mail">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control validate-field vemail" id="mail" name="mail">
                  </div>
                </div>
                <!-- Segunda columna -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="address">Dirección <span class="text-danger">*</span></label>
                    <input type="text" class="form-control validate-field vaddress" id="address" name="address">
                  </div>
                  <div class="form-group">
                    <label for="height">Altura</label>
                    <input type="number" class="form-control validate-field vhousenumber" id="height" name="height">
                  </div>
                  <div class="form-group">
                    <label for="floor">Piso</label>
                    <input type="text" class="form-control validate-field vfloor_dep" id="floor" name="floor">
                  </div>
                  <div class="form-group">
                    <label for="departament">Departamento</label>
                    <input type="text" class="form-control validate-field vfloor_dep" id="departament"
                      name="departament">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Agregar</button>
                <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
              </div>
              <div class="text-center" id="response-message"></div>
          </form>
          <div class="p-xxs font-italic bg-muted border-top-bottom text">
              <span class="font-bold">NOTA:</span> Al agregar un nuevo cliente, asegúrese de completar todos los campos obligatorios. La información ingresada se actualizará de manera inmediata en el sistema.<br>
              <span class="text-danger">*</span> Campo obligatorio
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
  <script>
    //ABRIR LA VENTANA DE OPCINES CON CODIGO DE AREA
    const input = document.querySelector("#phone");
    const iti = window.intlTelInput(input, {
      separateDialCode: true,
      preferredCountries: ["ar", "us", "br", "mx"],
      utilsScript: "../../js/utils.js"
    });
    
    //GUARADAR EL CODIGO DE AREA Y EL NUMERO
    document.getElementById('change-insertclient-form').addEventListener('submit', function(event) {
      event.preventDefault();
      const fullNumber = iti.getNumber();
      console.log("Número completo con código de área:", fullNumber);
      document.getElementById('phone').value = fullNumber;
      this.submit();
    });
  </script>


</body>

</html>