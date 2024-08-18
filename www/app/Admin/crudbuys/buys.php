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
                <div class="ibox-content">
                    <form id="searchForm" method="GET" action="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search_by">Buscar por:</label>
                                    <select name="search_by" id="search_by" class="form-control">
                                        <option value="">Seleccionar</option>
                                        <option value="date_buy">Fecha</option>
                                        <option value="remittance">N° de Remito</option>
                                        <option value="id_supplier">Proveedor</option>
                                        <option value="material_name">Producto</option>
                                        <option value="state_name">Estado de Compra</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" id="state_name_container" style="display: none;">
                                <div class="form-group">
                                    <label for="state_name">Estado de Compra:</label>
                                    <select name="state_name" id="state_name" class="form-control">
                                        <option value="">Seleccionar</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Completado">Completado</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" id="date_buy_container" style="display: none;">
                                <div class="form-group">
                                    <label for="date_buy">Fecha:</label>
                                    <input type="date" name="date_buy" id="date_buy" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3" id="remittance_container" style="display: none;">
                                <div class="form-group">
                                    <label for="remittance">N° de Remito:</label>
                                    <input type="text" name="remittance" id="remittance" class="form-control" placeholder="N° de Remito">
                                </div>
                            </div>
                            <div class="col-md-3" id="product_container" style="display: none;">
                                <div class="form-group">
                                    <label for="material_name">Producto:</label>
                                    <input type="text" name="material_name" id="material_name" class="form-control" placeholder="Nombre de Producto">
                                </div>
                            </div>
                            <div class="col-md-3" id="supplier_container" style="display: none;">
                                <div class="form-group">
                                    <label for="id_supplier">Proveedor:</label>
                                    <input type="text" name="id_supplier" id="id_supplier" class="form-control" placeholder="Nombre del Proveedor">
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>

                    <br>
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
                                    // Conectar a la base de datos

                                    if ($conn->connect_error) {
                                        die("Conexión fallida: " . $conn->connect_error);
                                    }

                                    // Validar que al menos un criterio de búsqueda esté presente
                                    if (
                                        !isset($_GET['state_name']) && !isset($_GET['material_name']) && !isset($_GET['date_buy']) && !isset($_GET['remittance']) && !isset($_GET['id_supplier'])  ||
                                        (empty($_GET['state_name']) && empty($_GET['material_name']) && empty($_GET['date_buy']) && empty($_GET['remittance']) && empty($_GET['id_supplier']))
                                    ) {
                                        echo "Por favor, realice una búsqueda para ver los resultados.";
                                    } else {
                                        $sql = SQL_SELECT_BUYS;

                                        if (isset($_GET['state_name']) && $_GET['state_name'] != '') {
                                            $estado = $conn->real_escape_string($_GET['state_name']);
                                            $sql .= " AND st.state_order = '$estado'";
                                        }

                                        if (isset($_GET['material_name']) && $_GET['material_name'] != '') {
                                            $producto = $conn->real_escape_string($_GET['material_name']);
                                            $sql .= " AND m.material_name LIKE '%$producto%'";
                                        }

                                        if (isset($_GET['id_supplier']) && $_GET['id_supplier'] != '') {
                                            $supplier = $conn->real_escape_string($_GET['id_supplier']);
                                            $sql .= " AND s.supplier_name LIKE '%$supplier%'";
                                        }

                                        if (isset($_GET['date_buy']) && $_GET['date_buy'] != '') {
                                            $fecha = $conn->real_escape_string($_GET['date_buy']);
                                            $sql .= " AND DATE(b.date_buy) = '$fecha'";
                                        }

                                        if (isset($_GET['remittance']) && $_GET['remittance'] != '') {
                                            $remittance = $conn->real_escape_string($_GET['remittance']);
                                            $sql .= " AND b.remittance = $remittance";
                                        }

                                        //Mensaje de depuración para la consulta SQL
                                        //echo "<pre>$sql</pre>";

                                        $result = $conn->query($sql);

                                        if (isset($_GET['state_name']) || isset($_GET['material_name']) || isset($_GET['date_buy']) || isset($_GET['remittance']) || isset($_GET['id_supplier'])) {
                                            if ($result->num_rows > 0) {
                                                echo '<table class="footable table table-stripped toggle-arrow-tiny">
                                                    <thead>
                                                    <tr>
                                                        <th data-toggle="true">Producto</th>
                                                        <th data-toggle="true">Proveedor</th>
                                                        <th data-hide="phone">Cantidad</th>
                                                        <th data-hide="phone">Medida</th>
                                                        <th data-hide="all">N° Remito</th>
                                                        <th data-hide="all">Costo</th>
                                                        <th data-hide="all">Compra</th>
                                                        <th class="text-right footable-visible footable-sortable footable-last-column footable-sorted">Acción<span class="footable-sort-indicator"></span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>';

                                                while ($row = $result->fetch_assoc()) {
                                                    $date = $row["date_buy"];
                                                    $formatted_date = date("d-m-Y", strtotime($date));
                                                    $formatted_cost = number_format($row["cost"], 2, ',', '.');
                                                    $remittance = $row["remittance"];
                                                    $first_part = substr($remittance, 0, 4);
                                                    $second_part = substr($remittance, 4);
                                                    $formatted_remittance = $first_part . '-' . $second_part;

                                                    echo '<tr>';
                                                    echo '<td>' . $row["material_name"] . '</td>';
                                                    echo '<td>' . $row["supplier_name"] . '</td>';
                                                    echo '<td>' . $row["ammount"] . '</td>';
                                                    echo '<td>' . $row["name_measure"] . '</td>';
                                                    echo '<td>' . $formatted_remittance . '</td>';
                                                    echo '<td>$ ' . $formatted_cost . '</td>';
                                                    echo '<td>' . $formatted_date . '</td>';

                                                    // if ($row["state_order"] == "Pendiente") {
                                                    //     echo '<td class="footable-visible" style="display: table-cell;">
                                                    //         <span class="label label-success">' . $row["state_order"] . '</span></td>';
                                                    // } elseif ($row["state_order"] == "Completado") {
                                                    //     echo '<td class="footable-visible" style="display: table-cell;">
                                                    //         <span class="label label-primary">' . $row["state_order"] . '</span></td>';
                                                    // } elseif ($row["state_order"] == "Cancelado") {
                                                    //     echo '<td class="footable-visible" style="display: table-cell;">
                                                    //         <span class="label label-cancel">' . $row["state_order"] . '</span></td>';
                                                    // }

                                                    echo '<td class="text-right footable-visible footable-last-column">';
                                                    echo '<div class="btn-group">';
                                                    if ($row["state_order"] != "Completado" && $row["state_order"] != "Cancelado") {
                                                        echo '<button onclick="openEditModal(' . $row["id_buy"] . ')" class="btn-white btn btn-xs" style="margin-right: 5px;">Editar</button>';
                                                        echo '<button onclick="openCompleteModal(' . $row["id_buy"] . ')" class="label label-primary" style="margin-right: 5px;">Confirmar</button>';
                                                        echo '<button onclick="openDeleteModal(' . $row["id_buy"] . ')" class="btn btn-danger btn-xs" style="margin-right: 5px;">Cancelar</button>';
                                                    }
                                                    echo '</div>';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }

                                                echo '</tbody></table>';
                                            } else {
                                                echo "No hay compras que coincidan con los criterios de búsqueda.";
                                            }
                                        } else {
                                            echo "Por favor, realice una búsqueda para ver los resultados.";
                                        }
                                    }

                                    $conn->close();
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
                    title: "¿Estás seguro que deseas Cancelar?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: "Sí",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false
                }, function() {
                    // Realiza una solicitud AJAX para eliminar el admin
                    $.ajax({
                        type: "POST",
                        url: "buysController.php?token=<?php echo $token; ?>",
                        data: {
                            action: "delete_buy",
                            id: id
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                swal({
                                    title: "¡Eliminado!",
                                    type: "success"
                                }, function() {
                                    location.reload(); // Recarga la página
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: "Hubo un problema al eliminar.",
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
                                text: "Hubo un problema al eliminar.",
                                type: "error"
                            }, function() {
                                location.reload(); // Recarga la página en caso de error también
                            });
                        }
                    });
                });
            }
        </script>

        <script>
            // Función para controlar la visibilidad de los campos según la selección del usuario
            $(document).ready(function() {
                $('#search_by').change(function() {
                    var selectedOption = $(this).val();

                    // Ocultar todos los contenedores
                    $('#state_name_container').hide();
                    $('#date_buy_container').hide();
                    $('#remittance_container').hide();
                    $('#product_container').hide();
                    $('#supplier_container').hide();
                    

                    // Mostrar el contenedor correspondiente al criterio seleccionado
                    switch (selectedOption) {
                        case 'state_name':
                            $('#state_name_container').show();
                            break;
                        case 'date_buy':
                            $('#date_buy_container').show();
                            break;
                        case 'remittance':
                            $('#remittance_container').show();
                            break;
                        case 'material_name':
                        $('#product_container').show();
                        break;

                        case 'id_supplier':
                        $('#supplier_container').show();
                        break;

                        default:
                            // En caso de seleccionar otro criterio, no mostrar ningún campo adicional
                            break;
                    }
                });
            });
        </script>

</body>

</html>