<?php
session_start();
define('TITLE', 'Menus Nav');
define('PAGE', 'MenusNav');

if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_idRol'];
} else {
    echo "<script> location.href='../login.php'; </script>";
}
?>

<ul class="nav metismenu" id="side-menu">
    <li class="nav-header">
        <div class="dropdown profile-element">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo ucfirst($_SESSION['user_name']) ?></strong>
                    </span> <span class="text-muted text-xs block"><?php echo ucfirst($_SESSION['user_role']) ?><b class="caret"></b></span>
                </span>

                <div class="logo-element">
                    TL+
                </div>
    </li>

    <?php if ($rolUser == 1) { ?>

        <li class=" <?php if (PAGE == 'dashboard admin') {
                        echo 'active';
                    } ?>">
            <a href="../../Admin/dashboard/dashboard.php">
                <i class="bi bi-house"></i> <span class="nav-label">Inicio</span>
            </a>
        </li>
        <li class=" <?php if (PAGE == 'Ordenes Admin' || PAGE == 'Reportes Admin') {
                        echo 'active';
                    } ?>">
            <a href="#"><i class="bi bi-receipt"></i><span class="nav-label">Órdenes de Trabajo</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="../crudorders/order.php">Órdenes Asignadas</a></li>
                <li><a href="../crudorders/reportsOrders.php">Reportes </a></li>
                <li><a href="../crudorders/historyOrders.php">Historial </a></li>

            </ul>
        </li>
        <li class=" <?php if (PAGE == 'Usuarios' || PAGE == 'Clientes' || PAGE == 'Proveedores') {
                        echo 'active';
                    } ?>">
            <a href="#"><i class="bi bi-people-fill"></i><span class="nav-label">Miembros</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="../crudusers/users.php">Usuarios</a></li>
                <li><a href="../crudclients/clients.php">Clientes </a></li>
                <li><a href="../crudsuppliers/suppliers.php">Proveedores</a></li>
            </ul>
        </li>
        <li class=" <?php if (PAGE == 'Compras' || PAGE == 'Materiales') {
                        echo 'active';
                    } ?>">
            <a href="#"><i class="fa fa-shopping-cart"></i><span class="nav-label">Tienda</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="../crudbuys/buys.php">Compras</a></li>
                <li><a href="../crudmaterials/materials.php">Materiales </a></li>
            </ul>
        </li>

        <li class=" <?php if (PAGE == 'Actualización de Email' || PAGE == 'Perfil') {
                        echo 'active';
                    } ?>">
            <a href="#"><i class="fa fa-gears"></i><span class="nav-label">Configuraciones</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="../configsmtp/configEmailContact.php"><i class="fa fa-gears"></i>Email de Contacto</a></li>
                <li><a href="../../Admin/profileAdmin/AdminProfile.php">Perfil</a></li>
            </ul>
        </li>

    <?php } ?>

    <!-- TECNICO -->
    <?php if ($rolUser == 2) { ?>

        <li class=" <?php if (PAGE == 'dashboard tecnico') {
                        echo 'active';
                    } ?>">
            <a href="../../Technic/dashboard/dashboard.php">
                <i class="bi bi-house"></i> <span class="nav-label">Inicio</span>
            </a>
        </li>

        <li class=" <?php if (PAGE == 'Ordenes') {
                        echo 'active';
                    } ?>">
            <a href="#"><i class="bi bi-receipt"></i><span class="nav-label">Órdenes Asignadas</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level collapse">
                <li><a href="../../Technic/orders/ordersTechnic.php">Órdenes Asignadas</a></li>
                <li><a href="../../Technic/orders/historyOrders.php">Historial </a></li>
            </ul>
        </li>
        
        <li class=" <?php if (PAGE == 'Technic Profile') {
                        echo 'active';
                    } ?>">
            <a href="../../Technic/profiletechnical/TechnicProfile.php">
                <i class="bi bi-person-circle"></i></i><span class="nav-label">
                    Perfil <span class="sr-only">(current)</span></span>
            </a>
        </li>
    <?php } ?>

    <li>
        <a href="../../logout.php" id="logout-link">
            <i class="bi bi-door-closed"></i><span class="nav-label">
                Cerrar Sesión</span>
        </a>
    </li>

</ul>