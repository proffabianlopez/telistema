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

define('TITLE', 'Actualización de Email');
define('PAGE', 'Actualización de Email');

include('../dbConnection.php');
include('../Querys/configEmailFrm.php');


$sql = SQLSELECT_FRM_EMAIL;
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $smtp_host = $row['mail_host'];
    $smtp_port = $row['mail_port'];
    $smtp_user = $row['mail_username'];
    $smtp_pass = $row['mail_password'];
    $smtp_setfrom = $row['mail_setfrom'];
    $smtp_addaddress = $row['mail_addaddress'];
    $pagina_web = $row['webpage'];
}


if (isset($_REQUEST['emailupdate'])) {
    if ($result->num_rows != 0 or $result->num_rows != null) {
        if (empty($_REQUEST['smtp_host']) || empty($_REQUEST['smtp_port']) || empty($_REQUEST['smtp_user']) || empty($_REQUEST['smtp_pass']) || empty($_REQUEST['smtp_setfrom']) || empty($_REQUEST['smtp_addaddress']) || empty($_REQUEST['pagina_web'])) {
            $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Complete todos los campos</div>';
        } else {
            $smtp_host = $_REQUEST['smtp_host'];
            $smtp_port = (int) $_REQUEST['smtp_port'];  // Convertir a entero
            $smtp_user = $_REQUEST['smtp_user'];
            $smtp_pass = $_REQUEST['smtp_pass'];
            $smtp_setfrom = $_REQUEST['smtp_setfrom'];
            $smtp_addaddress = $_REQUEST['smtp_addaddress'];
            $pagina_web = $_REQUEST['pagina_web'];

            $stmt = $conn->prepare(SQLUPDATE_FRM_EMAIL);
            if ($stmt === false) {
                $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert">Error en la preparación de la consulta: ' . $conn->error . '</div>';
            } else {
                $stmt->bind_param("sisssss", $smtp_host, $smtp_port, $smtp_user, $smtp_pass, $smtp_setfrom, $smtp_addaddress, $pagina_web);

                if ($stmt->execute()) {
                    $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert">Actualizado correctamente</div>';
                } else {
                    $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert">No se puede actualizar: ' . $stmt->error . '</div>';
                }

                $stmt->close();
            }
        }
        
    } else {
        if (empty($_REQUEST['smtp_host']) || empty($_REQUEST['smtp_port']) || empty($_REQUEST['smtp_user']) || empty($_REQUEST['smtp_pass']) || empty($_REQUEST['smtp_setfrom']) || empty($_REQUEST['smtp_addaddress']) || empty($_REQUEST['pagina_web'])) {
            $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">Complete todos los campos</div>';
        } else {
            $smtp_host = $_REQUEST['smtp_host'];
            $smtp_port = (int) $_REQUEST['smtp_port'];  // Convertir a entero
            $smtp_user = $_REQUEST['smtp_user'];
            $smtp_pass = $_REQUEST['smtp_pass'];
            $smtp_setfrom = $_REQUEST['smtp_setfrom'];
            $smtp_addaddress = $_REQUEST['smtp_addaddress'];
            $pagina_web = $_REQUEST['pagina_web'];

            $stmt = $conn->prepare(SQLINSERT_FRM_EMAIL);
            if ($stmt === false) {
                $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert">Error en la preparación de la consulta: ' . $conn->error . '</div>';
            } else {
                $stmt->bind_param("sisssss", $smtp_host, $smtp_port, $smtp_user, $smtp_pass, $smtp_setfrom, $smtp_addaddress, $pagina_web);

                if ($stmt->execute()) {
                    $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert">Actualizado correctamente</div>';
                } else {
                    $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert">No se puede actualizar: ' . $stmt->error . '</div>';
                }

                $stmt->close();
            }
        }
    }
}
?>
<?php include('../includes/header.php') ?>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php include('../includes/menu.php') ?>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>

                    </div>
                    <ul class="nav navbar-top-links navbar-right">

                        <li>
                            <a href="../logout.php">
                                <i class="fa fa-sign-out"></i> Cerrar Sección
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">

                    <h2 class="text-center mb-4" style="font-weight: bold; color: #343a40;">Formulario de
                        Actualización de Configuración de Email</h2>
                    <p class="text-center mb-5" style="font-size: 1.1em; color: #6c757d;">Utilice este
                        formulario para actualizar la configuración del servidor SMTP utilizado para el
                        envío y recepción de correos electrónicos en su aplicación.</p>

                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">

                    <div class="col-lg-5">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>SMPT</h5>

                            </div>
                            <div class="ibox-content">

                                <form class="mx-5" method="POST">
                                    <div class="form-group">
                                        <label for="smtp_host">Host SMTP</label>
                                        <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="<?php echo htmlspecialchars($smtp_host); ?>" title="Ingrese el nombre del servidor SMTP que se utiliza para enviar correos electrónicos.">
                                    </div>
                                    <div class="form-group">
                                        <label for="smtp_port">Puerto SMTP</label>
                                        <input type="number" class="form-control" id="smtp_port" name="smtp_port" value="<?php echo htmlspecialchars($smtp_port); ?>" title="Ingrese el número de puerto que utiliza el servidor SMTP. Por lo general, es 25, 465 o 587.">
                                    </div>
                                    <div class="form-group">
                                        <label for="smtp_user">Usuario SMTP</label>
                                        <input type="text" class="form-control" id="smtp_user" name="smtp_user" value="<?php echo htmlspecialchars($smtp_user); ?>" title="Ingrese el nombre de usuario para autenticarse en el servidor SMTP.">
                                    </div>
                                    <div class="form-group">
                                        <label for="smtp_pass">Contraseña SMTP</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="smtp_pass" name="smtp_pass" value="<?php echo htmlspecialchars($smtp_pass); ?>" title="Ingrese la contraseña asociada al usuario SMTP.">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" id="togglePassword">Mostrar</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="smtp_setfrom">Email de envío</label>
                                        <input type="email" class="form-control" id="smtp_setfrom" name="smtp_setfrom" value="<?php echo htmlspecialchars($smtp_setfrom); ?>" title="Ingrese la dirección de correo electrónico desde la cual se enviarán los correos electrónicos.">
                                    </div>
                                    <div class="form-group">
                                        <label for="smtp_addaddress">Correo electrónico de recibo</label>
                                        <input type="email" class="form-control" id="smtp_addaddress" name="smtp_addaddress" value="<?php echo htmlspecialchars($smtp_addaddress); ?>" title="Ingrese la dirección de correo electrónico a la cual se enviarán las respuestas o notificaciones.">
                                    </div>
                                    <div class="form-group">
                                        <label for="pagina_web">Enlace de tu página</label>
                                        <input type="text" class="form-control" id="pagina_web" name="pagina_web" value="<?php echo htmlspecialchars($pagina_web); ?>" title="Ingrese la URL de su página web.">
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-block" name="emailupdate">Actualizar</button>
                                    <?php if (isset($passmsg)) {
                                        echo $passmsg;
                                    } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="footer">

                <div>
                    <strong>Copyright</strong> Telistema &copy; 2024
                </div>
            </div>

        </div>
    </div>


    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordField = document.getElementById('smtp_pass');
            var type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.textContent = this.textContent === 'Mostrar' ? 'Ocultar' : 'Mostrar';
        });
    </script>



    <?php include('../includes/footer.php'); ?>

</body>

</html>