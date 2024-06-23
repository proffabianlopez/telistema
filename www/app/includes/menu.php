<?php
session_start();
define('TITLE', 'Menus Nav');
define('PAGE', 'MenusNav');

if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../login.php'; </script>";
}

// Determina la URL dashboard según el rol
$dashboard_url = '';
if ($rolUser == 'admin') {
    $dashboard_url = 'dashboard.php';
} elseif ($rolUser == 'technic') {
    $dashboard_url = 'dashboard.php';
}

?>
<ul class="nav metismenu" id="side-menu">
    <li class="nav-header">
        <div class="dropdown profile-element">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo ucfirst($_SESSION['user_name']) ?></strong>
                    </span> <span class="text-muted text-xs block"><?php echo ucfirst($_SESSION['user_role']) ?><b class="caret"></b></span>
                </span> </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a href="../../logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
        <div class="logo-element">
            TL+
        </div>
    </li>

    <li class=" <?php if (PAGE == 'dashboard') {
                    echo 'active';
                } ?>">
        <a href="<?php echo $dashboard_url; ?>">
            <i class="bi bi-house"></i> <span class="nav-label">Inicio</span>
        </a>
    </li>
    <?php if ($rolUser == 'admin') { ?>
        <li class=" <?php if (PAGE == 'work') {
                        echo 'active';
                    } ?>">


                    <a  href="../crudorders/order.php">
                    <i class="bi bi-opencollective"></i><span class="nav-label">Ordenes de Trabajo</span>
                    </a>
                </li>
                <li class=" <?php if (PAGE == 'request') {


                        echo 'active';
                    } ?>">
                    <a  href="../crudbuys/buys.php">
                    <i class="fa fa-shopping-cart"></i><span class="nav-label">
                            Compras</span>
                    </a>
                </li>
                <li class=" <?php if (PAGE == 'Proveedores') {

                        echo 'active';
                    } ?>">
            <a href="../crudsuppliers/suppliers.php">
                <i class="bi bi-database"></i><span class="nav-label">Proveedores</span>

            </a>
        </li>
        <li class=" <?php if (PAGE == 'Materiales') {
                        echo 'active';
                    } ?>">

            <a href="../crudmaterials/materials.php">
                <i class="bi bi-database"></i><span class="nav-label">Productos</span>

            </a>
        </li>
        <li class=" <?php if (PAGE == 'Técnicos') {
                        echo 'active';
                    } ?>">
            <a href="../crudtechnics/technicians.php">
                <i class="bi bi-headset"></i><span class="nav-label">
                    Técnicos</span>

            </a>
        </li>
        <li class=" <?php if (PAGE == 'Clientes') {
                        echo 'active';
                    } ?>">
            <a href="../crudclients/clients.php">
                <i class="bi bi-people-fill"></i><span class="nav-label">
                    Clientes</span>
            </a>
        </li>
        <li class=" <?php if (PAGE == 'Admin') {
                        echo 'active';
                    } ?>">
            <a href="../crudadmins/admin.php">
                <i class="bi bi-people-fill"></i><span class="nav-label">
                    Administradores</span>
            </a>
        </li>
        <!-- <li class=" <?php if (PAGE == 'sellreport') {
                        echo 'active';
                    } ?>">
            <a href="../Admin/soldproductreport.php">
                <i class="bi bi-bootstrap-reboot"></i><span class="nav-label">
                    Reportes de Materiales</span>
            </a>
        </li>
        <li class=" <?php if (PAGE == 'workreport') {
                        echo 'active';
                    } ?>">
            <a href="../Admin/workreport.php">
                <i class="bi bi-bootstrap-reboot"></i><span class="nav-label">
                    Reportes de Ordenes</span>
            </a>
        </li> -->
        <li class=" <?php if (PAGE == 'Actualización de Email') {
                        echo 'active';
                    } ?>">
            <a href="../configsmtp/configEmailContact.php">
                <i class="bi bi-envelope-at"></i><span class="nav-label">
                    Email de Contacto</span>
            </a>
        <!-- </li>
        <li class=" <?php if (PAGE == 'changepass') {
                        echo 'active';
                    } ?>">
            <a href="../Admin/changepass.php">
                <i class="bi bi-key"></i><span class="nav-label">
                    Cambiar Clave</span>
            </a>
        </li> -->
    <?php } ?>

    <!-- TECNICO -->
    <?php if ($rolUser == 'technic') { ?>
        <li class=" <?php if (PAGE == 'Technic Profile') {
                        echo 'active';
                    } ?>">
            <a href="../Technic/TechnicProfile.php">
                <i class="bi bi-person-circle"></i></i><span class="nav-label">
                    Perfil <span class="sr-only">(current)</span></span>
            </a>
        </li>
        <li class=" <?php if (PAGE == 'SubmitTechnic') {
                        echo 'active';
                    } ?>">
            <a href="../Technic/SubmitTechnic.php">
                <i class="bi bi-person-wheelchair"></i><span class="nav-label">
                    Enviar Pedido</span>
            </a>
        </li>
        <li class=" <?php if (PAGE == 'CheckStatus') {
                        echo 'active';
                    } ?>">
            <a href="../Technic/CheckStatus.php">
                <i class="bi bi-list-nested"></i></i><span class="nav-label">
                    Estado Servicio</span>
            </a>
        </li>
        <!-- <li class=" <?php if (PAGE == 'Requesterchangepass') {
                        echo 'active';
                    } ?>">
            <a href="../Technic/TechnicChangePass.php">
                <i class="bi bi-key"></i><span class="nav-label">
                    Cambiar Clave</span>
            </a>
        </li> -->

    <?php } ?>

    <li>
        <a href="../../logout.php" id="logout-link">
            <i class="bi bi-door-closed"></i><span class="nav-label">
                Cerrar Sesión</span>
        </a>
    </li>

</ul>
