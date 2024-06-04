<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_role'] != 'admin') {
        echo "<script> location.href='../includes/404.php'; </script>";
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../login.php'; </script>";
}
////////////////////////////////

define('TITLE', 'Tecnicos');
define('PAGE', 'Tecnicos');
include ('../includes/header.php');
include ('../dbConnection.php');
include ('../Querys/querys.php');

?>


<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php include ('../includes/menu.php') ?>

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
                    <h2>Tecnicos</h2>

                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de Tecnicos</h5>

                            </div>
                            <div class="ibox-content">


                                <?php
                                $sql = SQL_SELECT_TECHNIC;
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo ' <table class="footable table table-stripped toggle-arrow-tiny">
                                <thead>
                                <tr>
                                    <th data-hide="all">ID</th>
                                    <th data-toggle="true">Nombre</th>
                                    <th data-hide="phone">Email</th>
                                    <th data-hide="all">Telefono</th>
                                    <th data-hide="phone">Estado</th>
                                    <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                ';

                                    // Imprimir los datos de cada técnico
                                    while ($row = $result->fetch_assoc()) {
                                        $state = $row['id_state_user'];
                                        $stmt = $conn->prepare(SQL_SELECT_STATE_BY_ID);
                                        $stmt->bind_param("i", $state);
                                        $stmt->execute();
                                        $result_state = $stmt->get_result();

                                        // Verificar si hay resultados
                                        if ($result_state->num_rows > 0) {
                                            // Obtener la fila como un array asociativo
                                            $row_state = $result_state->fetch_assoc();
                                            $name_state = $row_state["state_user"];
                                        } else {
                                            // Si no hay resultados, asignar un valor por defecto
                                            $name_state = "Estado no encontrado"; // O el valor que desees
                                        }

                                        echo '<tr>';
                                        echo '<td>' . $row["id_user"] . '</td>';
                                        echo '<td>' . $row["name_user"] . '</td>';
                                        echo '<td>' . $row["mail"] . '</td>';
                                        echo '<td>' . $row["phone_user"] . '</td>';
                                        echo '<td>' . $name_state . '</td>';
                                        echo '<td>
            
                                        <div class="btn-group" role="group">
                                                    <form action="editemp.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id_user" value="' . $row["id_user"] . '">
                                                        <button type="submit" class="btn btn-warning btn-xs" name="view" value="View">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                    </form>
                                                    <form action="" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id_user" value="' . $row["id_user"] . '">
                                                        <button class="btn btn-danger btn-xs" name="delete" value="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                    </td> 
                                                         
                                                        </tr>';
                                    }

                                    echo '</tbody>
                                                  </table>';
                                } else {
                                    echo "0 Result";
                                }
                                if (isset($_REQUEST['delete'])) {
                                    $id_client = $_REQUEST['id_user'];

                                    $stmt = $conn->prepare(SQL_DELETE_TECHNIC);

                                    // Asocia parámetros y ejecuta la consulta
                                    $stmt->bind_param("i", $id_client);

                                    if ($stmt->execute()) {

                                        echo '<meta http-equiv="refresh" content= "0;URL=?deleted" />';
                                    } else {
                                        echo "Unable to Delete Data";
                                    }
                                }

                                ?>



                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <ul class="pagination pull-right"></ul>
                                        </td>
                                    </tr>
                                </tfoot>


                            </div>
                        </div>
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
    
    
    
    <div id="small-chat">
        <a class="open-small-chat" href="insertemp.php">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>

    </div>

    <?php
    include ('../includes/footer.php');
    ?>
    <script>
        $(document).ready(function () {

            $('.footable').footable();
            $('.footable2').footable();

        });

    </script>

</body>
</html>