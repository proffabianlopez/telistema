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
                    <h2>Compras</h2>
                </div>
                <div class="col-lg-2"></div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight ecommerce">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <table class="footable table table-stripped toggle-arrow-tiny footable-loaded default" data-page-size="15">
                    <thead>
                        <tr>

                            <th class="footable-visible footable-sortable footable-first-column">Order ID<span class="footable-sort-indicator"></span></th>
                            <th data-hide="phone" class="footable-sortable footable-visible" style="display: table-cell;">Customer<span class="footable-sort-indicator"></span></th>
                            <th data-hide="phone" class="footable-sortable footable-visible" style="display: table-cell;">Amount<span class="footable-sort-indicator"></span></th>
                            <th data-hide="phone" class="footable-sortable footable-visible" style="display: table-cell;">Date added<span class="footable-sort-indicator"></span></th>
                            <th data-hide="phone,tablet" class="footable-sortable footable-visible" style="display: table-cell;">Date modified<span class="footable-sort-indicator"></span></th>
                            <th data-hide="phone" class="footable-sortable footable-visible" style="display: table-cell;">Status<span class="footable-sort-indicator"></span></th>
                            <th class="text-right footable-visible footable-sortable footable-last-column">Action<span class="footable-sort-indicator"></span></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr class="footable-even" style="display: table-row;">
                            <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                                3214
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                Customer example
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                $500.00
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                03/04/2015
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                03/05/2015
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right footable-visible footable-last-column">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="footable-even" style="display: table-row;">
                            <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                                642
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                Customer example
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                $6843.00
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                10/04/2015
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                13/07/2015
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right footable-visible footable-last-column">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="footable-even" style="display: table-row;">
                            <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                                324
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                Customer example
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                $320.00
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                12/04/2015
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                21/07/2015
                            </td>
                            <td class="footable-visible" style="display: table-cell;">
                                <span class="label label-warning">Expired</span>
                            </td>
                            <td class="text-right footable-visible footable-last-column">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="footable-visible">
                                <ul class="pagination pull-right"><li class="footable-page-arrow disabled"><a data-page="first" href="#first">«</a></li><li class="footable-page-arrow disabled"><a data-page="prev" href="#prev">‹</a></li><li class="footable-page active"><a data-page="0" href="#">1</a></li><li class="footable-page"><a data-page="1" href="#">2</a></li><li class="footable-page"><a data-page="2" href="#">3</a></li><li class="footable-page-arrow"><a data-page="next" href="#next">›</a></li><li class="footable-page-arrow"><a data-page="last" href="#last">»</a></li></ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>

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
                url: "editMaterial.php?token=<?php echo $token; ?>&id=" + id, // Ruta al archivo de edición de usuario
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
                url: "insertMaterial.php?token=<?php echo $token; ?>", // Ruta al archivo de edición de usuario
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

        function openDeleteModal(id) {
            swal({
                title: "¿Estás seguro?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: "¡Sí, elimínalo!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function() {
                // Realiza una solicitud AJAX para eliminar el admin
                $.ajax({
                    type: "POST",
                    url: "materialsController.php?token=<?php echo $token; ?>",
                    data: {
                        action: "delete_product",
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
</body>

</html>