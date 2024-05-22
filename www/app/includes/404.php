<?php 
session_start();
define('TITLE', 'Error 404');
define('PAGE', '404');
include('../includes/header.php');?>
 <div class="middle-box text-center animated fadeInDown">
        <h1 class="error-code">404</h1>
        <h3 class="error-title font-bold">Página No Encontrada</h3>
        <div class="error-desc">
            Lo sentimos, pero la página que estás buscando no ha sido encontrada. Intenta verificar la URL para errores, luego presiona el botón de actualizar en tu navegador o intenta encontrar algo más en nuestra aplicación.
        </div>
    </div>

<?php include('../includes/footer.php');?>