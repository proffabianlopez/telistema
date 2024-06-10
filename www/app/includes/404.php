<?php
session_start();
define('TITLE', 'Error 404');
define('PAGE', '404');
include ('../includes/header.php'); ?>

<body>


    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php
                include ('../includes/menu.php'); ?>

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
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>

                </nav>




                <div class="middle-box text-center animated fadeInDown">
                    <h1 class="error-code">404</h1>
                    <h3 class="error-title font-bold">Página No Encontrada</h3>
                    <div class="error-desc">
                        Lo sentimos, pero la página que estás buscando no ha sido encontrada. Intenta verificar la URL
                        para errores, luego presiona el botón de actualizar en tu navegador o intenta encontrar algo más
                        en nuestra aplicación.
                    </div>
                </div>


            </div>
            <div class="footer">
                <div class="pull-right">
                   
                </div>
                <div>
                    <strong>Copyright</strong>  Telistema &copy; 2024
                </div>
            </div>

        </div>
    </div>



    <?php include ('../includes/footer.php'); ?>
</body>

</html>