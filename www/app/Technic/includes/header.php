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
    <nav class="navbar navbar-dark fixed-top bg-danger flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="TechnicProfile.php">Telistema</a>
    </nav>

    <!-- Side Bar -->
    <div class="container-fluid mb-5 " style="margin-top:40px;">
    <div class="row">
    <nav class="col-sm-2 bg-light sidebar py-5 d-print-none">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
            <li class="nav-item">
            <a class="nav-link <?php if(PAGE == 'Technic Profile') { echo 'active'; } ?>" href="TechnicProfile.php">
                <i class="fas fa-user"></i>
                Perfil <span class="sr-only">(current)</span>
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php if(PAGE == 'SubmitTechnic') { echo 'active'; } ?>" href="SubmitTechnic.php">
                <i class="fab fa-accessible-icon"></i>
                Enviar Pedido
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php if(PAGE == 'CheckStatus') { echo 'active'; } ?>" href="CheckStatus.php">
                <i class="fas fa-align-center"></i>
                Estado Servicio
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php if(PAGE == 'Requesterchangepass') { echo 'active'; } ?>" href="TechnicChangePass.php">
                <i class="fas fa-key"></i>
                Cambiar Clave
            </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="../logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Salir
            </a>
            </li>
            </ul>
        </div>
    </nav>