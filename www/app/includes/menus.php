<?php
session_start();
define('TITLE', 'Menus Nav');
define('PAGE', 'MenusNav');

if($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
 $rEmail = $_SESSION['mail'];
 $rolUser = $_SESSION['user_role'];
} else {
 echo "<script> location.href='../login.php'; </script>";
}

// Determina la URL dashboard según el rol
$dashboard_url = '';
if ($rol == 'admin') {
    $dashboard_url = '../Admin/dashboard.php';
} elseif ($rol == 'technic') {
    $dashboard_url = '../Technic/TechnicProfile.php';
}

?>


<!-- Side Bar -->
 <div class="container-fluid mb-5" style="margin-top:40px;">
    <div class="row">
    <nav class="col-sm-3 col-md-2 bg-light sidebar py-5 d-print-none">
        <div class="sidebar-sticky">
        <ul class="nav flex-column">
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'dashboard') { echo 'active'; } ?> " href="<?php echo $dashboard_url; ?>">
            <i class="fas fa-tachometer-alt"></i>
            Inicio
        </a>
        </li>

        <!-- ADMIN -->
        <?php if ($rolUser == 'admin') { ?>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'work') { echo 'active'; } ?>" href="../Admin/work.php">
            <i class="fab fa-accessible-icon"></i>
            Ordenes de Trabajo
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'request') { echo 'active'; } ?>" href="../Admin/request.php">
            <i class="fas fa-align-center"></i>
            Solicitudes
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'assets') { echo 'active'; } ?>" href="../Admin/assets.php">
            <i class="fas fa-database"></i>
            Materiales
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'technician') { echo 'active'; } ?>" href="../Admin/technician.php">
            <i class="fab fa-teamspeak"></i>
            Technicos
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'Clientes') { echo 'active'; } ?>" href="../Admin/clients.php">
            <i class="fas fa-users"></i>
            Clientes
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'sellreport') { echo 'active'; } ?>" href="../Admin/soldproductreport.php">
            <i class="fas fa-table"></i>
            Reportes de Materiales
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'workreport') { echo 'active'; } ?>" href="../Admin/workreport.php">
            <i class="fas fa-table"></i>
            Reportes de Ordenes
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'Actualización de Email') { echo 'active'; } ?>" href="../Admin/configEmailContact.php">
        <i class="bi bi-envelope-at"></i>
            Email de Contacto
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'changepass') { echo 'active'; } ?>" href="../Admin/changepass.php">
            <i class="fas fa-key"></i>
            Cambiar Clave
        </a>
        </li>
        <?php } ?>

              <!-- TECNICO -->
        <?php if ($rolUser == 'technic') { ?>

            <a class="nav-link <?php if(PAGE == 'Technic Profile') { echo 'active'; } ?>" href="../Technic/TechnicProfile.php">
                <i class="fas fa-user"></i>
                Perfil <span class="sr-only">(current)</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php if(PAGE == 'SubmitTechnic') { echo 'active'; } ?>" href="../Technic/SubmitTechnic.php">
                <i class="fab fa-accessible-icon"></i>
                Enviar Pedido
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php if(PAGE == 'CheckStatus') { echo 'active'; } ?>" href="../Technic/CheckStatus.php">
                <i class="fas fa-align-center"></i>
                Estado Servicio
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php if(PAGE == 'Requesterchangepass') { echo 'active'; } ?>" href="../Technic/TechnicChangePass.php">
                <i class="fas fa-key"></i>
                Cambiar Clave
            </a>
            </li>

            <?php } ?>

        <li class="nav-item">
        <a class="nav-link" href="../logout.php">
            <i class="fas fa-sign-out-alt"></i>
            Cerrar Sesión
        </a>
        </li>
        </ul>
        </div>
    </nav>
