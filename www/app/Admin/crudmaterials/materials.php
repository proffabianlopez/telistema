<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 1) {
        header("Location:../../includes/404/404.php");
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../../login.php'; </script>";
}
////////////////////////////////
// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Materiales');
define('PAGE', 'Materiales');
include ('../../includes/header.php');
include ('../../dbConnection.php');
include ('../../Querys/querys.php');
?>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php include ('../../includes/menu.php') ?>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
                    </div>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Stock</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="../dashboard/dashboard.php">Inicio</strong></a>
                        </li>
                        <li>
                            <a href="../crudbuys/buys.php">Compras</a>
                        </li>
                        <li class="active">
                            <strong>Materiales</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de materiales</h5>
                            </div>
                            <div class="ibox-content">
                                <?php
                                $sql = SQL_SELECT_MATERIALS;
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<table class="footable table table-stripped toggle-arrow-tiny">
                                    <thead>
                                    <tr>
                                        <th data-toggle="true">Nombre</th>
                                        <th data-hide="phone">Cantidad</th>
                                        <th data-hide="all">Descripción</th>
                                        <th data-hide="phone">Medida</th>
                                        <th data-hide="phone">Estado</th>
                                        <th class="text-right footable-visible footable-last-column">Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>';

                                    // Imprimir los datos de cada producto activo
                                    while ($row = $result->fetch_assoc()) {
                                        $state = $row['id_status'];
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

                                        $state = $row['id_measure'];
                                        $stmt = $conn->prepare(SQL_SELECT_MEASURE_BY_ID);
                                        $stmt->bind_param("i", $state);
                                        $stmt->execute();
                                        $result_state = $stmt->get_result();

                                        // Verificar si hay resultados
                                        if ($result_state->num_rows > 0) {
                                            // Obtener la fila como un array asociativo
                                            $row_state = $result_state->fetch_assoc();
                                            $name_measure = $row_state["name_measure"];
                                        } else {
                                            // Si no hay resultados, asignar un valor por defecto
                                            $name_measure = "Estado no encontrado"; // O el valor que desees
                                        }
                                        
                                        echo '<tr>';
                                        echo '<td>' . $row["material_name"] . '</td>';
                                        echo '<td>' . $row["stock"] . '</td>';
                                        echo '<td>' . $row["description"] . '</td>';
                                        echo '<td>' . $name_measure . '</td>';

                                        if($row["stock"] > $row["stock_alert"]) {
                                            echo '<td class="footable-visible" style="display: table-cell;">
                                                    <span class="label label-primary">Disponible</span>
                                                    </td>';
                                        } elseif($row["stock"] > 0 && $row["stock"] <= $row["stock_alert"]) {
                                            echo '<td class="footable-visible" style="display: table-cell;">
                                                    <span class="label label-warning">Poco stock</span>
                                                    </td>';
                                        } elseif($row["stock"] == 0) {
                                            echo '<td class="footable-visible" style="display: table-cell;">
                                                    <span class="label label-danger">Sin stock</span>
                                                    </td>';
                                        }
                                        
                                        
                                        
                                        echo '<td class="text-right footable-visible footable-last-column">
                                               <div class="btn-group" role="group">
                                                    <button id="edit-'.$row["id_material"].'-'.$token.'" data-crud="materials" class="btn btn-warning btn-xs modaledit-btn" style="margin-right: 5px" >
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button id="delete-'.$row["id_material"].'-'.$token.'" data-crud="materials" class="btn btn-danger btn-xs delete-btn" >
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>';
                                    echo '</tr>';
                                    }

                                    echo '</tbody></table>';
                                } else {
                                    echo "No se han encontrado materiales registrados en el sistema hasta el momento.";
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
                    <strong>Copyright</strong> Telistema &copy; 2024
                </div>
            </div>
        </div>
    </div>

    <div id="small-chat">
        <a class="open-small-chat" onclick="openNewAdminModal()">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>

    <div id="edit-form-container" style="display: none;"></div>
    <?php
    include ('../../includes/footer.php');
    ?>
    <script>
        $(document).ready(function () {
            $('.footable').footable();
            $('.footable2').footable();
        });
        function openNewAdminModal() {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "insertMaterial.php?token=<?php echo $token; ?>", // Ruta al archivo de edición de usuario
                type: "GET",
                success: function (response) {
                    // Muestra el formulario de edición en el contenedor
                    $("#edit-form-container").html(response).slideDown();
                    // Abre el modal
                    $("#myModal6").modal("show");
                },
                error: function () {
                    alert("Error al cargar el formulario de edición.");
                }
            });
        }
    </script>
</body>
</html>
