<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_role'] != 'admin') {
        echo "<script> location.href='../../includes/404.php'; </script>";
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
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="../../logout.php">
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Stock</h2>
                </div>
                <div class="col-lg-2"></div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Lista de Productos</h5>
                            </div>
                            <div class="ibox-content">
                                <?php
                                // Usar la consulta para seleccionar solo materiales activos
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
                                        <th class="text-right footable-visible footable-last-column">Accion</th>
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
                                                <div class="btn-group">
                                                    <button onclick="openEditModal(' . $row["id_material"] . ')" class="btn-white btn btn-xs" style="margin-right: 5px" >
                                                        Editar
                                                    </button>
                                                    <button onclick="openDeleteModal(' . $row["id_material"] . ')" class="bbtn-white btn btn-xs" >
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </td>';
                                    echo '</tr>';
                                    }

                                    echo '</tbody></table>';
                                } else {
                                    echo "No hay materiales activos.";
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
                    <!-- Contenido adicional si es necesario -->
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

        function openEditModal(id) {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "editMaterial.php?token=<?php echo $token; ?>&id=" + id, // Ruta al archivo de edición de usuario
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

        function openDeleteModal(id) {
            swal({
                title: "¿Estás seguro?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: "¡Sí, elimínalo!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                // Realiza una solicitud AJAX para eliminar el admin
                $.ajax({
                    type: "POST",
                    url: "materialsController.php?token=<?php echo $token; ?>",
                    data: {
                        action: "delete_product",
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            swal({
                                title: "¡Eliminado!",
                                type: "success"
                            }, function () {
                                location.reload(); // Recarga la página
                            });
                        } else {
                            swal({
                                title: "Error",
                                text: "Hubo un problema al eliminar.",
                                type: "error"
                            }, function () {
                                location.reload(); // Recarga la página en caso de error también si es necesario
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        swal({
                            title: "Error",
                            text: "Hubo un problema al eliminar.",
                            type: "error"
                        }, function () {
                            location.reload(); // Recarga la página en caso de error también
                        });
                    }
                });
            });
        }
    </script>
</body>
</html>
