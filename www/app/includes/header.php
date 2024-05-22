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

    <style>
    .middle-box {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #dc3545;
        }
        .error-title {
            font-size: 24px;
            font-weight: 600;
            color: #343a40;
        }
        .error-desc {
            margin-top: 20px;
            font-size: 16px;
            color: #6c757d;
        }
    </style>
   
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-dark fixed-top bg-danger p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="dashboard.php">Telistema</a>
    </nav>

   <?php include 'menus.php'; ?>