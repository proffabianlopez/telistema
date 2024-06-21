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

define('TITLE', 'Compras');
define('PAGE', 'Compras');
include('../../includes/header.php');
include('../../dbConnection.php');
include('../../Querys/querys.php');
?>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php include('../../includes/menu.php') ?>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Compras</h2>
                </div>
                <div class="col-lg-2"></div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight ecommerce">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Lista de Compras</h5>
                            </div>
                            <div class="ibox-content">
                            <?php
                                // Usar la consulta para seleccionar solo materiales activos
                                $sql = SQL_SELECT_BUYS;
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo '<table class="footable table table-stripped toggle-arrow-tiny">
                                    <thead>
                                    <tr>
                                        <th data-toggle="true">Producto</th>
                                        <th data-toggle="true">Proveedor</th>
                                        <th data-hide="phone">Cantidad</th>
                                        <th data-hide="phone">Medida</th>
                                        <th data-hide="all">Costo</th>
                                        <th data-hide="phone">Estado</th>
                                        <th class="text-right footable-visible footable-sortable footable-last-column footable-sorted">Action<span class="footable-sort-indicator"></span></th>
                                    </tr>
                                    </thead>
                                    <tbody>';

                                    // Imprimir los datos de cada producto activo
                                    while ($row = $result->fetch_assoc()) {

                                        $state = $row['id_state_order'];
                                        $stmt = $conn->prepare(SQL_SELECT_STATE_ORDER_BY_ID);
                                        $stmt->bind_param("i", $state);
                                        $stmt->execute();
                                        $result_state = $stmt->get_result();

                                        // Verificar si hay resultados
                                        if ($result_state->num_rows > 0) {
                                            // Obtener la fila como un array asociativo
                                            $row_state = $result_state->fetch_assoc();
                                            $name_state = $row_state["state_order"];
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

                                        $state = $row['id_material'];
                                        $stmt = $conn->prepare(SQL_SELECT_PRODUCT_BY_ID);
                                        $stmt->bind_param("i", $state);
                                        $stmt->execute();
                                        $result_state = $stmt->get_result();

                                        // Verificar si hay resultados
                                        if ($result_state->num_rows > 0) {
                                            // Obtener la fila como un array asociativo
                                            $row_state = $result_state->fetch_assoc();
                                            $name_material = $row_state["material_name"];
                                        } else {
                                            // Si no hay resultados, asignar un valor por defecto
                                            $name_material = "Estado no encontrado"; // O el valor que desees
                                        }

                                        $state = $row['id_supplier'];
                                        $stmt = $conn->prepare(SQL_SELECT_SUPPLIER_BY_ID);
                                        $stmt->bind_param("i", $state);
                                        $stmt->execute();
                                        $result_state = $stmt->get_result();

                                        // Verificar si hay resultados
                                        if ($result_state->num_rows > 0) {
                                            // Obtener la fila como un array asociativo
                                            $row_state = $result_state->fetch_assoc();
                                            $supplier_name = $row_state["supplier_name"];
                                        } else {
                                            // Si no hay resultados, asignar un valor por defecto
                                            $supplier_name = "Estado no encontrado"; // O el valor que desees
                                        }
                                        
                                        echo '<tr>';
                                        echo '<td>' . $name_material . '</td>';
                                        echo '<td>' . $supplier_name . '</td>';
                                        echo '<td>' . $row["ammount"] . '</td>';
                                        echo '<td>' . $name_measure . '</td>';
                                        echo '<td>$ ' . $row["cost"] . '</td>';

                                        if($name_state == "pendiente") {

                                            echo '<td class="footable-visible" style="display: table-cell;">
                                                    <span class="label label-success">' . $name_state . '</span>
                                                </td>';

                                        } elseif($name_state == "completado") {

                                            echo '<td class="footable-visible" style="display: table-cell;">
                                                    <span class="label label-primary">' . $name_state . '</span></td>';

                                        } elseif($name_state == "cancelado") {

                                            echo '<td class="footable-visible" style="display: table-cell;">
                                            <span class="label label-warning">' . $name_state . '</span></td>';
                                        }
                                
                                        // Mostrar los botones de acción según el estado
                                        echo '<td class="text-right footable-visible footable-last-column">';
                                        echo '<div class="btn-group">';
                                        if ($name_state != "completado" && $name_state != "cancelado") {
                                            echo '<button onclick="openEditModal(' . $row["id_buy"] . ')" class="btn-white btn btn-xs" style="margin-right: 5px;">Editar</button>';
                                        }
                                        // Mostrar el botón "Completar" solo si el estado no es "completado"
                                        if ($name_state != "completado" && $name_state != "cancelado") {
                                            echo '<button onclick="openCompleteModal(' . $row["id_buy"] . ')" class="label label-primary" style="margin-right: 5px;">Completar</button>';
                                        }

                                        if ($name_state != "completado" && $name_state != "cancelado") {
                                            echo '<button onclick="openDeleteModal(' . $row["id_buy"] . ')" class="btn btn-danger btn-xs" style="margin-right: 5px;">Cancelar</button>';
                                        }
                                        
                                        echo '</div>';
                                        echo '</td>';
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
    include('../../includes/footer.php');
    ?>
    <script>
        $(document).ready(function() {
            $('.footable').footable();
            $('.footable2').footable();
        });

        function openEditModal(id) {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "editBuys.php?token=<?php echo $token; ?>&id=" + id, // Ruta al archivo de edición de usuario
                type: "GET",
                success: function(response) {
                    // Muestra el formulario de edición en el contenedor
                    $("#edit-form-container").html(response).slideDown();
                    // Abre el modal
                    $("#myModal6").modal("show");
                },
                error: function() {
                    alert("Error al cargar el formulario de edición.");
                }
            });
        }

        function openNewAdminModal() {
            // Realiza una solicitud AJAX para obtener el formulario de edición
            $.ajax({
                url: "insertBuys.php?token=<?php echo $token; ?>", // Ruta al archivo de edición de usuario
                type: "GET",
                success: function(response) {
                    // Muestra el formulario de edición en el contenedor
                    $("#edit-form-container").html(response).slideDown();
                    // Abre el modal
                    $("#myModal6").modal("show");
                },
                error: function() {
                    alert("Error al cargar el formulario de edición.");
                }
            });
        }


        function openCompleteModal(id) {
            swal({
                title: "¿Estás seguro?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: "¡Sí, Agregar a Stock!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function() {
                // Realiza una solicitud AJAX para eliminar el admin
                $.ajax({
                    type: "POST",
                    url: "buysController.php?token=<?php echo $token; ?>",
                    data: {
                        action: "complete_buy",
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            swal({
                                title: "¡Compra Completada!",
                                type: "success"
                            }, function() {
                                location.reload(); // Recarga la página
                            });
                        } else {
                            swal({
                                title: "Error",
                                text: "Hubo un problema al Completar.",
                                type: "error"
                            }, function() {
                                location.reload(); // Recarga la página en caso de error también si es necesario
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        swal({
                            title: "Error",
                            text: "Hubo un problema al Completar.",
                            type: "error"
                        }, function() {
                            location.reload(); // Recarga la página en caso de error también
                        });
                    }
                });
            });
        }

        function openDeleteModal(id) {
            swal({
                title: "¿Estás seguro?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: "¡Sí, cancelar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                // Realiza una solicitud AJAX para eliminar el admin
                $.ajax({
                    type: "POST",
                    url: "buysController.php?token=<?php echo $token; ?>",
                    data: {
                        action: "delete_buy",
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