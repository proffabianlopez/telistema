<?php
session_start();
////////////////////////////////
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location:../../includes/404/404.php");
    exit();
  }
  ////////////////////////////////
  // Genera un token CSRF y lo guarda en la sesión

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Ordenes');
define('PAGE', 'Ordenes');
include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../configsmtp/generate_config.php');
include ('../../includes/header.php');

// if (isset($_REQUEST['update'])) {
//     if (($_POST['order_date'] == "") || ($_POST['order_hour'] == "")) {
//         $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Complete los campos </div>';
//     } else {
//         $order_date = $_POST['order_date'];
//         $order_hour = $_POST['order_hour'];
//         $order_description = $_POST['order_description'];
//         $order_server = $_POST['order_server'];
//         $address = capitalizeWords($_POST['address']);
//         $height = $_POST['height'];
//         $floor = trim($_POST['floor']);
//         $departament = trim($_POST['departament']);
//         $id_client = $_POST['id_client'];
//         $id_priority = trim($_POST['id_priority']);
//         $id_material = trim($_POST['id_material']);
//         $id_state_order = trim($_POST['id_state_order']);
//         $technic_id = trim($_POST['technic_id']);
//         $id_order = $_POST['id_order'];

//         $sql = SQL_UPDATE_ORDER;
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param(
//             "sssisissiiiiii",
//             $order_date,
//             $order_hour,
//             $order_description,
//             $order_server,
//             $address,
//             $height,
//             $floor,
//             $departament,
//             $id_client,
//             $id_priority,
//             $id_material,
//             $id_state_order,
//             $technic_id,
//             $id_order
//         );

//         if ($stmt->execute()) {
//             $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Actualizado con éxito </div>';
//         } else {
//             $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo actualizar </div>';
//         }
//     }
// }
if (isset($_POST['id'])) {
    $id = explode('*', $_POST['id']);

    $id_order = $id[0];
    $sql = SQL_SELECT_ORDER_BY_ID;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningúna orden con ese ID.</div>';
    }
}

?>

<body>
    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close reload" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>

                    <h4 class="modal-title">Editar Orden</h4>
                </div>
                <div class="modal-body">
                    <form id="change-editorder-form" action="" method="POST">
                        <!-- Contenedor principal flex -->
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Primera columna -->
                                <div class="col-md-6">
                                    <div style="display: none;" class="form-group">
                                        <label for="id_order">N° de Orden</label>
                                        <input type="text" class="form-control" id="id_order" name="id_order" value="<?php if (isset($row['id_order'])) {
                                            echo $row['id_order'];
                                        } ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_client">Cliente (No editable)</label>
                                        <p class="form-control" id="full_name_client"><?php if (isset($row['client_name']) && isset($row['client_lastname'])) {
                                            echo $row['client_name'] . ' ' . $row['client_lastname'];
                                        } ?></p> 
                                    </div>
                                    <input type="hidden" name="id_client" value="<?php if (isset($row['id_client'])) {
                                        echo $row['id_client'];
                                    } ?>">
                                    <div class="form-group">
                                        <label for="id_priority">Prioridad <span class="text-danger">*</span></label>
                                        <select name="id_priority" id="id_priority" class="form-control">
                                            <option value="1" <?php if ($row["id_priority"] === 1)
                                                echo 'selected'; ?>>
                                                Normal</option>
                                            <option value="2" <?php if ($row["id_priority"] === 2)
                                                echo 'selected'; ?>>
                                                Urgente</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="technic_id">Asignar Técnico <span class="text-danger">*</span></label>
                                        <select name="technic_id" id="technic_id" class="form-control">
                                            <?php
                                            $technic = $row['technic_id'];
                                            $stmt = $conn->prepare(SQL_SELECT_TECNS_ORDER_BY_ID);
                                            $stmt->bind_param("i", $technic);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row_technic = $result->fetch_assoc();
                                                $name_technic = $row_technic["name_user"] . ' ' . $row_technic["surname_user"];
                                                $id_technic = $row_technic["id_user"];
                                            }

                                            $stmt_all = $conn->prepare(SQL_SELECT_TECNS_ORDERS);
                                            $stmt_all->execute();
                                            $result_all = $stmt_all->get_result();

                                            foreach ($result_all as $tech) {
                                                $technicName = $tech["name_user"] . ' ' . $tech["surname_user"];
                                                $technicId = $tech["id_user"];
                                                $selected = ($technicId == $id_technic) ? "selected" : "";
                                                echo "<option value='$technicId' $selected>$technicName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="state_order">Estado <span class="text-danger">*</span></label>
                                        <select name="id_state_order" id="id_state_order" class="form-control">
                                            <option value="1" <?php if ($row["id_state_order"] === 1)
                                                echo 'selected'; ?>>
                                                Confirmada</option>
                                            <option value="2" <?php if ($row["id_state_order"] === 2)
                                                echo 'selected'; ?>>
                                                Cancelada</option>
                                            <option value="3" <?php if ($row["id_state_order"] === 3)
                                                echo 'selected'; ?>>
                                                Pendiente</option>
                                            <option value="4" <?php if ($row["id_state_order"] === 4)
                                                echo 'selected'; ?>>
                                                Realizada</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="order_description">Descripción <span class="text-danger">*</span></label>
                                        <textarea class="form-control validate-field vtextarea" id="order_description" name="order_description"
                                            style="resize: none; max-width: 100%;"><?php if (isset($row['order_description'])) {
                                                echo $row['order_description'];
                                            } ?></textarea>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Dirección  <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control validate-field vaddress" id="address" name="address" value="<?php if (isset($row['address'])) {
                                            echo $row['address'];
                                        } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="height">Altura  <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control validate-field vhousenumber" id="height" name="height" value="<?php if (isset($row['height'])) {
                                            echo $row['height'];
                                        } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="floor">Piso</label>
                                        <input type="text" class="form-control validate-field vfloor_dep" id="floor" name="floor" value="<?php if (isset($row['floor'])) {
                                            echo $row['floor'];
                                        } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="departament">Departamento</label>
                                        <input type="text" class="form-control validate-field vfloor_dep" id="departament" name="departament"
                                            value="<?php if (isset($row['departament'])) {
                                                echo $row['departament'];
                                            } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="ladda-button btn btn-primary"
                                    data-style="zoom-in">Actualizar</button>
                                <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="text-center" id="response-message"></div>
                        </div>
                    </form>



                    <div class="p-xxs font-italic bg-muted border-top-bottom text">
                        <span class="font-bold">NOTA:</span> Al editar una Orden, asegúrese de revisar y actualizar
                        correctamente todos los campos. Los cambios realizados se reflejarán inmediatamente en el
                        sistema.<br>
                        <span class="text-danger">*</span> Campo Obligatorio
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let token = '<?php echo $token; ?>';
        let email = '';
    </script>
    <script src="../../js/main.js"></script>
    <script>

$(document).ready(function () {

    $('#full_name_client').prop('readonly', true);
    $('#full_name_client').attr('disabled', 'disabled');

});

</script>
</body>

</html>