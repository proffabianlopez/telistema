<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
    <?php echo TITLE ?>
    </title>

     <!-- Bootstrap CSS para icons-->
     <link rel="stylesheet" href="../boostrap/node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="../css/all.min.css">

    <!-- Custome CSS -->
    <link rel="stylesheet" href="../css/custom.css">

   
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-dark fixed-top bg-danger p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="dashboard.php">Telistema</a>
    </nav>

    <!-- Side Bar -->
    <div class="container-fluid mb-5" style="margin-top:40px;">
    <div class="row">
    <nav class="col-sm-3 col-md-2 bg-light sidebar py-5 d-print-none">
        <div class="sidebar-sticky">
        <ul class="nav flex-column">
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'dashboard') { echo 'active'; } ?> " href="dashboard.php">
            <i class="fas fa-tachometer-alt"></i>
            Inicio
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'work') { echo 'active'; } ?>" href="work.php">
            <i class="fab fa-accessible-icon"></i>
            Ordenes de Trabajo
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'request') { echo 'active'; } ?>" href="request.php">
            <i class="fas fa-align-center"></i>
            Solicitudes
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'assets') { echo 'active'; } ?>" href="assets.php">
            <i class="fas fa-database"></i>
            Materiales
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'technician') { echo 'active'; } ?>" href="technician.php">
            <i class="fab fa-teamspeak"></i>
            Technicos
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'Clientes') { echo 'active'; } ?>" href="clients.php">
            <i class="fas fa-users"></i>
            Clientes
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'sellreport') { echo 'active'; } ?>" href="soldproductreport.php">
            <i class="fas fa-table"></i>
            Reportes de Materiales
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'workreport') { echo 'active'; } ?>" href="workreport.php">
            <i class="fas fa-table"></i>
            Reportes de Ordenes
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'Actualización de Email') { echo 'active'; } ?>" href="configEmailContact.php">
        <i class="bi bi-envelope-at"></i>
            Email de Contacto
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?php if(PAGE == 'changepass') { echo 'active'; } ?>" href="changepass.php">
            <i class="fas fa-key"></i>
            Cambiar Clave
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../logout.php">
            <i class="fas fa-sign-out-alt"></i>
            Cerrar Sesión
        </a>
        </li>
        </ul>
        </div>
    </nav>