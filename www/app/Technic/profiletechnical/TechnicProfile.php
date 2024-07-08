<?php
session_start();
define('TITLE', 'Technic Profile');
define('PAGE', 'Technic Profile');
include ('../../dbConnection.php');

////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if ( $_SESSION['user_idRol'] != 2) {
    header("Location:../../includes/404/404.php");
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

?>
<?php
include ('../../includes/header.php'); ?>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php
                include ('../../includes/menu.php'); ?>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">

            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i
                                class="fa fa-bars"></i> </a>
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
                    <h2>Perfil</h2>

                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">


                <div class="row m-b-lg m-t-lg">
                    <div class="col-md-6">
                        <div class="profile-info">
                            <div class="">
                                <div>
                                    <h2 class="no-margins">
                                    <?php if (isset($_SESSION['user_name'])) {
                                              echo $_SESSION['user_name'];
                                            } ?>

                                            <?php if (isset($_SESSION['user_name'])) {
                                           echo     $_SESSION['user_surname'];
                                            } ?>
                                    </h2>
                                    <br>
                                    <h4><strong>Email:</strong> <?php if (isset($_SESSION['mail'])) {
                                              echo $_SESSION['mail'];
                                            } ?></h4>
                                    <h4><strong>Cargo:</strong> <?php if (isset($_SESSION['user_role'])) {
                                              echo $_SESSION['user_role'];
                                            } ?></h4>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-primary" onclick="openEditModal()">
                        Cambiar contraseña
                    </button>
                </div>



            </div>
            <div class="footer">
                <div class="pull-right">

                </div>
                <div>
                    <strong>Copyright</strong> Telistema &copy; 2024
                </div>
            </div>

        </div>
    </div>



    <?php
    include ('../../includes/footer.php');
    ?>
<div id="edit-form-container" style="display: none;"></div>
    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script>
        $(document).ready(function () {


            $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });
        });

        function openEditModal() {
                // Realiza una solicitud AJAX para obtener el formulario de edición
                $.ajax({
                    url: "modalpass.php?token=<?php echo $token; ?>", // Ruta al archivo de edición de usuario
                    type: "GET",
                    success: function (response) {
                        // Muestra el formulario de edición en el contenedor
                        $("#edit-form-container").html(response).slideDown();
                        // Abre el modal
                        $("#myModal6").modal("show");
                    },
                    error: function () {
                        alert("Error al cargar el formulario de edición.");
                    }
                });
            }
    </script>

</body>

</html>