<?php // Inicia la sesión 
session_start();
// Verifica si la sesión está iniciada y el token es válido 
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location:../../includes/404/404.php");
    exit();
} // Genera un token CSRF y lo guarda en la sesión if (!isset($_SESSION['token']))
{
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../configsmtp/generate_config.php');
$passwordGenerate = generatePassword(); ?>

</body>
<div class="modal inmodal fase" data-backdrop="static" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Registrar Nuevo Usuario</h4>
            </div>
            <div class="modal-body">

                <form id="change-insertuser-form" action="" method="POST">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Primera columna -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name_user">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control validate-field vname" id="name_user" name="name_user">
                                </div>
                                <div class="form-group">
                                    <label for="name_user">Apellido <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control validate-field vname" id="surname_user" name="surname_user">
                                </div>
                                <div class="form-group">
                                    <label for="name_user">Cargo <span class="text-danger">*</span></label>

                                    <select class="form-control" name="rol" id="rol">
                                        <option value="1">Administrador</option>
                                        <option value="2">Técnico</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Segunda columna -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_user">Teléfono <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control validate-field iti__tel-input" id="phone_user" name="phone_user">
                                </div>
                            
                                <div class="form-group">
                                    <label for="mail">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control validate-field vemail" id="mail" name="mail">
                                </div>
                                <div style="display: none" class="form-group password-container">
                                    <label for="user_password">Contraseña</label>
                                    <input type="password" class="form-control validate-field" id="user_password" name="user_password"
                                        value="<?php echo $passwordGenerate; ?>" readonly>
                                    <span class="glyphicon glyphicon-eye-open toggle-password"></span>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>

                    <div class="modal-footer text-center">
                        <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Agregar</button>
                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="text-center" id="response-message"></div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text ">
                    <span class="font-bold">NOTA:</span> Al agregar un nuevo Usuario se enviará al email las
                    credenciales para que pueda iniciar sesión. El sistema genera automáticamente una contraseña<br>
                    <span class="text-danger">*</span> Campo Obligatorio
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
  const input = document.querySelector("#phone_user");
  const iti = window.intlTelInput(input, {
    separateDialCode: true,
    preferredCountries: ["ar", "us", "br", "mx"],
    utilsScript: "../../js/utils.js"
  });

  document.getElementById('change-insertclient-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const fullNumber = iti.getNumber();
    console.log("Número completo con código de área:", fullNumber);
    document.getElementById('phone_user').value = fullNumber;
    this.submit();
  });
  </script>
</body>

</html>