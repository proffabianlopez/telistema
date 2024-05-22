<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../images/logo.png" rel="icon" type="image/png">
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
        <button class="navbar-toggler" type="button" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation" id="sidebarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
  
    </nav>
    <!-- Side Bar -->
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <button class="navbar-toggler" type="button" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation" id="sidebarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Mi Aplicación</a>
    </nav> -->

   <?php include 'menus.php'; ?>